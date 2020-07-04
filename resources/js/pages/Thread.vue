<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from "../components/SubscribeButton";

    export default {
        props: ['thread'],
        components: {Replies, SubscribeButton},
        data() {
            return {
                closed: this.thread.closed,
            };
        },
        methods: {
            closeThread() {
                this.$confirm(
                    {
                        message: `Are you sure you want to close thread? It can't be undone.`,
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
                                this.closed = true;
                                axios.post('/threads/' + this.thread.id + '/close');
                            }
                        }
                    }
                )
            }
        }
    }
</script>
