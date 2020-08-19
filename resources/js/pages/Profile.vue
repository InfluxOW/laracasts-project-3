<script>
    import FileUploader from "../components/FileUploader";
    import Popper from 'vue-popperjs';

    export default {
        components: { FileUploader, 'popper': Popper },
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
