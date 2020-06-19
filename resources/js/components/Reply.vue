<script>
    export default {
        props: ['attributes'],
        data() {
            return {
                editing: false,
                body: this.attributes.body
            };
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.attributes.id, {
                    body: this.body
                });
                this.editing = false;
                flash('Reply has been updated!', 'success');
            },
            destroy() {
                axios.delete('/replies/' + this.attributes.id);
                $(this.$el).fadeOut(2000, () => {
                    flash('Reply has been deleted!', 'success');
                });
            }
        }
    }
</script>
