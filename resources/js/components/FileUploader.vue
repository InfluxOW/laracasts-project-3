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

    const FileUploader = vueFilePond(
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
        components: { FileUploader },
        props: ['url'],
        data() {
            return {
                csrfToken: document.querySelector('meta[name="csrf-token"]').content
            };
        },
    }
</script>
