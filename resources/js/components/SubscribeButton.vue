<template>
    <button v-if="isSubscribed" class="button-dropdown-red" type="submit" @click="unsubscribe">Unsubscribe</button>
    <button v-else class="button-dropdown-blue" type="submit" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {
        props: ['subscribed', 'endpoint'],
        data() {
            return {
                isSubscribed: this.subscribed
            }
        },
        methods: {
            subscribe() {
                axios.post(this.endpoint).then(flash('You have been subscribed to post!', 'success'));
                this.isSubscribed = true;
            },
            unsubscribe() {
                axios.delete(this.endpoint).then(flash('You have been unsubscribed from post!', 'success'));
                this.isSubscribed = false;
            }
        }
    }
</script>

<style scoped>

</style>
