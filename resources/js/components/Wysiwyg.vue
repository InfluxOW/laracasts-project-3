<template>
    <div class="wysiwyg">
        <input id="trix" value="Editor content goes here" type="hidden" :name="name">
        <trix-editor input="trix" ref="trix"></trix-editor>
    </div>
</template>

<script>
    export default {
        props: ['name'],

        mounted() {
            this.$refs.trix.addEventListener('trix-change', e => {
                this.$emit('input', e.target.innerHTML);
            });
        }
    }
</script>
