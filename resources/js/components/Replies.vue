<template>
    <div>
        <hr class="my-6 border-2 opacity-75">
        <div v-for="(reply, index) in items">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
        <hr class="my-6 border-2 opacity-75">

        <new-reply :endpoint="endpoint" @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';

    export default {
        props: ['data'],
        components: { Reply, NewReply },
        data() {
            return {
                items: this.data,
                endpoint: location.pathname + '/replies'
            }
        },
        methods: {
            add(reply) {
                this.items.push(reply);
                this.$emit('added');
            },
            remove(index) {
                this.items.splice(index, 1);
                this.$emit('removed');
                flash('Reply was deleted!', 'success');
            }
        }
    }
</script>
