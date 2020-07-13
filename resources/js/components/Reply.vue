<template>
    <div class="mb-2 font-sans py-2 rounded-lg" :class="isBest ? 'bg-green-200 border-2 border-green-500' : 'bg-white border border-gray-300'" :id="id">
        <div class="flex py-2">
            <div class="w-1/8 mr-1 text-center">
                <div class="flex justify-center">
                    <img :src="reply.user.avatar" alt="" class="h-12 w-12 rounded-full mx-2">
                </div>
                <span class="text-gray-700 text-xs" v-text="reply.user.reputation + ' XP'"></span>
            </div>
            <div class="w-full">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="font-bold"><a :href="'/profiles/'+reply.user.username" class="text-black hover:text-opacity-50" v-text="reply.user.name"></a></span>
                        <span class="text-gray-700" v-text="'@'+reply.user.username"></span>
                        <span class="text-gray-700">·</span>
                        <span class="text-gray-700" v-text="createdAt"></span>
                        <span class="text-gray-700">·</span>
                        <span class="text-gray-700"><a :href="reply.link" class="text-black hover:text-opacity-50">#</a></span>
                    </div>
                    <div class="mr-2 flex items-center">
                        <button @click="markReplyAsBest" v-if="authorize('owns', reply.thread)" v-show="! isBest" class="button-new mr-2">Best Reply?</button>
                        <favorite :model="reply" type="reply" :is-favorited="reply.isFavorited" v-if="signedIn"></favorite>
                        <span class="inline-flex items-center leading-none text-sm" v-else>
                            <svg
                                class="w-4 h-4 mr-1"
                                stroke-width="50" stroke-linecap="round"
                                stroke-linejoin="round" viewBox="0 -10 540 540" stroke="#718096" fill="none">
                                <path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0"/></svg>
                            {{ reply.favorites_count }}
                        </span>
                    </div>
                </div>
                <div v-if="editing">
                    <form @submit.prevent="update">
                        <div class="pr-8">
                            <wysiwyg name="body" :value="body" v-model="body" class="text-left border border-gray-300 rounded-lg p-4 mt-2 mb-4 text-gray-700 rounded text-sm focus:shadow-outline w-full"></wysiwyg>
                        </div>
                        <slot name="honeypot"></slot>

                        <button class="uppercase font-bold text-xs text-blue-600 outline-none focus:outline-none hover:opacity-75 mr-2">Update</button>
                        <button @click="editing = false" class="uppercase font-bold text-xs text-gray-600 outline-none focus:outline-none hover:opacity-75 mr-2" type="button">Cancel</button>
                    </form>
                </div>

                <div v-if="! editing">
                    <div class="text-sm my-2 wysiwyg w-11/12" ref="body">
                        <highlight :content="body"></highlight>
                    </div>
                    <div v-if="authorize('owns', reply)">
                        <div class="mt-4">
                            <button class="uppercase font-bold text-xs text-blue-600 outline-none focus:outline-none hover:opacity-75 mr-2" @click="editing = true">Edit</button>

                            <button
                                @click="handleClick"
                                class="uppercase font-bold text-xs text-red-600 outline-none focus:outline-none hover:opacity-75 mr-2">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var moment = require('moment');

    export default {
        props: ['reply'],
        data() {
            return {
                editing: false,
                body: this.reply.body,
                id: 'reply-' + this.reply.id,
                isBest: this.reply.isBest,
            };
        },
        computed: {
            createdAt() {
                return moment(this.reply.created_at).format('MMM DD, hh:mm:ss');
            }
        },
        created() {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.reply.id);
            });
        },
        mounted() {
            this.highlight(this.$refs['body']);
        },
        watch: {
            editing() {
                if (this.editing) return;
                this.$nextTick(() => {
                    this.highlight(this.$refs['body']);
                });
            }
        },
        methods: {
            update() {
                axios.patch(
                    '/replies/' + this.reply.id, {
                        body: this.body
                    })
                    .then(({data}) => {
                        this.editing = false;
                        flash('Reply has been updated!', 'success');
                    })
                    .catch(error => {
                        flash(error.response.data.errors.body.toString(), 'error');
                        this.body = this.reply.body;
                    });
            },
            destroy() {
                axios.delete('/replies/' + this.reply.id);
                $(this.$el).fadeOut(2000, () => {
                    flash('Reply has been deleted!', 'success');
                });
            },
            markReplyAsBest() {
                axios.post('/replies/' + this.reply.id + '/best');
                window.events.$emit('best-reply-selected', this.reply.id);
            },
            handleClick(){
                this.$confirm(
                    {
                        message: `Are you sure?`,
                        button: {
                            no: 'No',
                            yes: 'Yes'
                        },
                        /**
                         * Callback Function
                         * @param {Boolean} confirm
                         */
                        callback: confirm => {
                            if (confirm) {
                                this.destroy();
                            }
                        }
                    }
                )
            }
        }
    }
</script>
