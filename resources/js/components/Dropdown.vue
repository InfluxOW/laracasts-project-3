<template>
    <div class="flex flex-wrap items-center dropdown align-middle z-50" :class="icon_dropdown ? '' : 'relative'">
        <button :class="button_classes" style="transition: all 0.15s ease;" type="button" v-on:click="toggleDropdown()" ref="btnDropdownRef">
                <span class="inline-flex">
                    <slot name="icon"></slot>
                    {{ button_title }}
                </span>
        </button>

        <div :class="classes" class="bg-white text-base py-2 list-none rounded shadow-lg mt-1 text-center max-w-sm z-50" ref="popoverDropdownRef">
            <slot name="items"></slot>
        </div>
    </div>
</template>

<script>

import Popper from "popper.js";

export default {
    props: {
        button_classes: { default: '' },
        button_title: { default: '' },
        icon_dropdown: { default: false }
    },
    computed: {
        classes() {
            return [this.icon_dropdown ? '' : 'w-full', this.dropdownPopoverShow ? 'block' : 'hidden'];
        }
    },
    name: "dropdown",
    data() {
        return {
            dropdownPopoverShow: false
        }
    },
    watch: {
        dropdownPopoverShow(dropdownPopoverShow) {
            if (dropdownPopoverShow) {
                document.addEventListener('click', this.closeIfClickedOutside);
            }
        }
    },
    methods: {
        toggleDropdown: function(){
            if(this.dropdownPopoverShow){
            this.dropdownPopoverShow = false;
            } else {
            this.dropdownPopoverShow = true;
            new Popper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
                placement: "bottom-start"
            });
            }
        },
        closeIfClickedOutside(event) {
            if (! event.target.closest('.dropdown')) {
                this.dropdownPopoverShow = false;
                document.removeEventListener('click', this.closeIfClickedOutside);
            }
        }
    }
}
</script>
