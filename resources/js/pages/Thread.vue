<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from "../components/SubscribeButton";

    export default {
        props: ['thread'],
        components: {Replies, SubscribeButton},
        data() {
            return {
                closed: this.thread.closed,
                title: this.thread.title,
                body: this.thread.body,
                image: this.thread.image,
                form: {},
                editing: false
            };
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
                    image: this.thread.image
                };
                this.editing = false;
            }
        }
    }
</script>
