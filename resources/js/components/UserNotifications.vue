<template>
    <div v-if="notifications.length > 0">
        <li>
            <dropdown
                button_classes="focus:outline-none outline-none hover:opacity-75 mr-2 w-full"
                :icon_dropdown="true"
            >
                <template v-slot:icon>
                    <svg class="fill-current w-4 h-4 z-10" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m418.438 337.046c-16.087-9.326-26.938-26.722-26.938-46.617v-120.542c0-50.626-37.431-92.67-86.071-99.92v-20.538c-.001-27.255-22.174-49.429-49.429-49.429s-49.429 22.174-49.429 49.429v20.538c-48.64 7.25-86.071 49.294-86.071 99.92v120.542c0 19.895-10.851 37.292-26.938 46.617z"/><path d="m51.643 367.046v76.097h154.928v19.429c0 27.254 22.174 49.428 49.429 49.428s49.429-22.174 49.429-49.429v-19.429h154.929v-76.097h-408.715z"/></svg>
                </template>

                <template v-slot:items>
                    <a class="text-sm py-2 px-4 font-normal block w-full bg-transparent text-gray-800 hover:bg-gray-300"
                       :href="notification.data.link"
                       @click="markAsRead(notification)"
                       v-text="notification.data.message"
                       v-for="notification in notifications"
                    ></a>
                </template>
            </dropdown>
        </li>
    </div>
</template>

<script>
    export default {
        data() {
            return { notifications: false }
        },
        created() {
            axios.get('/profiles/' + window.app.user.username + '/notifications')
                .then(response => this.notifications = response.data);
        },
        methods: {
            markAsRead(notification) {
                axios.delete('/profiles/' + window.app.user.username + '/notifications/' + notification.id)
            }
        }
    }
</script>

<style scoped>

</style>
