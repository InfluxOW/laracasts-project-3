<template>
    <div class="mt-6 mb-2" v-if="signedIn">
        <div class="border border-gray-300 rounded-lg p-4 bg-page">
            <textarea class="w-full" name="body" placeholder="Enter your comment..." rows="3" v-model="body"></textarea>
        </div>
        <slot name="honeypot"></slot>

        <button type="submit" class="button-new mt-2" @click="addReply">Submit</button>
    </div>
</template>

<script>
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
        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        flash(error.response.data.errors.body.toString(), 'error');
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
