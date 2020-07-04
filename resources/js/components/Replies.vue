<template>
    <div>
        <hr class="my-6 border-2 opacity-75" v-if="items.length > 0">
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :reply="reply" @deleted="remove(index)">
                <template v-slot:honeypot>
                    <slot name="honeypot"></slot>
                </template>
            </reply>
        </div>
        <hr class="my-6 border-2 opacity-75" v-if="items.length > 0">

        <paginator :dataSet="dataSet" @changed="fetch"></paginator>

        <p v-if="$parent.closed" class="text-center text-red-700 border border-red-500 bg-red-300 p-4 ">
            Commenting is disabled by the administrator.
        </p>
        <new-reply @created="add" v-else>
            <template v-slot:honeypot>
                <slot name="honeypot"></slot>
            </template>
        </new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    import collection from '../mixins/collection.js';

    export default {
        components: { Reply, NewReply },
        mixins: [collection],
        data() {
            return {
                dataSet: false
            };
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch(page) {
                axios.get(this.url(page))
                    .then(this.refresh);
            },
            url(page) {
                if (! page) {
                    let query = location.search.match(/page=(\d+)/);
                    page = query ? query[1] : 1;
                }

                return location.pathname + `/replies?page=${page}`;
            },
            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;
            }
        }
    }
</script>
