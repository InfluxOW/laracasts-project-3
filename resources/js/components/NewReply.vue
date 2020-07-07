<template>
    <div class="mt-6 mb-2" v-if="signedIn">
        <div class="border border-gray-300 rounded-lg p-4 bg-page">
            <wysiwyg name="body" v-model="body" placeholder="Enter your comment..." :shouldClear="completed" id="body"></wysiwyg>
            <slot name="honeypot"></slot>
            <button type="submit" class="button-new mt-2" @click="addReply">Submit</button>
        </div>
    </div>
</template>

<script>
    import Tribute from "tributejs";

    export default {
        data() {
            return {
                body: '',
                completed: false
            };
        },
        mounted: function () {
            let tribute = new Tribute({
                // column to search against in the object (accepts function or string)
                lookup: 'value',
                // column that contains the content to insert by default
                fillAttr: 'value',
                values: function (query, cb) {
                    axios.get('/api/users', {params: {username: query}})
                        .then(function (response) {
                            console.log(response);
                            cb(response.data);
                        });
                },
            });
            tribute.attach(document.querySelectorAll("#body"));
        },
        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        flash(error.response.data.message, 'error');
                    })
                    .then(({data}) => {
                        this.body = '';
                        this.completed = true;
                        flash('Reply has been posted!', 'success');
                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
