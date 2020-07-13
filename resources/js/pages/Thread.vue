<script>
    import Replies from '../components/Replies';
    import SubscribeButton from "../components/SubscribeButton";

    export default {
        props: ['thread'],
        components: {Replies, SubscribeButton},
        data() {
            return {
                closed: this.thread.closed,
                title: this.thread.title,
                body: this.thread.body,
                form: {},
                editing: false
            };
        },
        computed: {
            image() {
                return (this.thread.image === null) ? `https://picsum.photos/seed/${this.thread.slug}/720/400` : this.thread.image;
            }
        },
        mounted () {
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
        created () {
            this.resetForm();
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
            },
            update () {
                let uri = `/threads/${this.thread.id}`;
                axios.patch(uri, this.form)
                    .then(({data}) => {
                        this.editing = false;
                        this.title = this.form.title;
                        this.body = this.form.body;
                        this.image = this.form.image;
                        flash('Thread has been updated', 'success');
                    })
                    .catch(error => {
                        let errors = error.response.data.errors;
                        Object.keys(errors).forEach(function callback(error) {
                            flash(errors[error].toString(), 'error');
                        });
                    });
            },
            resetForm () {
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body,
                    image: this.image
                };
                this.editing = false;
            }
        }
    }
</script>
