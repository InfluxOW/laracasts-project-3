<template>
    <div class="mt-6 mb-2" v-if="signedIn">
        <div class="border border-gray-300 rounded-lg p-4 bg-page">
            <textarea class="w-full" name="body" placeholder="Enter your comment..." rows="3" v-model="body" id="body"></textarea>
        </div>
        <slot name="honeypot"></slot>

        <button type="submit" class="button-new mt-2" @click="addReply">Submit</button>
    </div>
</template>

<script>
    import Tribute from "tributejs";

    export default {
        data() {
            return {
                body: ''
            };
        },
        computed: {
            signedIn() {
                return window.app.signedIn;
            }
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
                        flash('Reply has been posted!', 'success');
                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
