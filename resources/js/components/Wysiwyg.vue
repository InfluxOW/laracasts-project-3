<template>
    <div class="wysiwyg">
        <input id="trix" :value="value" type="hidden" :name="name">
        <trix-editor input="trix" ref="trix" :placeholder="placeholder"></trix-editor>
    </div>
</template>

<script>
    import Trix from 'trix';

    export default {
        props: ['name', 'value', 'placeholder', 'shouldClear'],

        mounted() {
            this.$refs.trix.addEventListener("trix-change", e =>
                this.$emit("input", e.target.innerHTML)
            );
            this.$watch('shouldClear', () => {
                this.$refs.trix.value = '';
            });
        }
    }
</script>
