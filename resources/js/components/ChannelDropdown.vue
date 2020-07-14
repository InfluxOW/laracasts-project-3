<style lang="scss">
    .channel-list {
        max-height: 400px;
    }
</style>

<script>
    export default {
        data() {
            return {
                channels: [],
                filter: ''
            };
        },
        created() {
            axios.get('/api/channels').then(({ data }) => (this.channels = data));
        },
        computed: {
            filteredChannels() {
                return this.channels.filter(channel => {
                    return channel.name
                        .toLowerCase()
                        .startsWith(this.filter.toLocaleLowerCase());
                });
            }
        }
    };
</script>
