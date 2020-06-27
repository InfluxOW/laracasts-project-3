<script>
    export default {
        props: ['url'],
        data() {
            return {
                editing: false
            };
        },
        methods: {
            showUserActions() {
                let x = document.getElementById("user-actions");
                x.classList.contains('hidden') ? x.classList.remove('hidden') : x.classList.add('hidden');
            },
        },
    }
</script>
