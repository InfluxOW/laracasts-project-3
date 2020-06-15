<template>
    <div class="flex flex-wrap items-center dropdown">
        <div class="w-full">
            <div class="relative inline-flex align-middle w-full z-50">
                <button :class="button_classes" style="transition: all 0.15s ease;" type="button" v-on:click="toggleDropdown()" ref="btnDropdownRef">
                    {{ button_title }}
                </button>

                <div v-bind:class="{'hidden': !dropdownPopoverShow, 'block': dropdownPopoverShow}" class="bg-white text-base py-2 list-none rounded shadow-lg mt-1 text-center w-full" ref="popoverDropdownRef">
                    <slot name="items"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Popper from "popper.js";

export default {
    props: {
        button_classes: { default: '' },
        button_title: { default: '' },
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
