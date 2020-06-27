<script>
    import vueFilePond from 'vue-filepond';
    import FilePondPluginImagePreview from "filepond-plugin-image-preview";
    import FilePondPluginImageValidateSize from "filepond-plugin-image-validate-size";
    import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
    import FilePondPluginImageCrop from "filepond-plugin-image-crop";
    import FilePondPluginImageTransform from "filepond-plugin-image-transform";
    import FilePondPluginImageResize from "filepond-plugin-image-resize";
    import FilePondPluginFileEncode from "filepond-plugin-file-encode";
    import FilePondPluginImageExifOrientation from "filepond-plugin-image-exif-orientation";

    const FilePond = vueFilePond(
        FilePondPluginImagePreview,
        FilePondPluginImageValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImageCrop,
        FilePondPluginImageTransform,
        FilePondPluginImageResize,
        FilePondPluginFileEncode,
        FilePondPluginImageExifOrientation
    );

    export default {
        components: { FilePond },
        props: ['url'],
        data() {
            return {
                editing: false,
                csrfToken: document.querySelector('meta[name="csrf-token"]').content
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
