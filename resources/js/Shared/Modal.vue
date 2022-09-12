<template>

    <teleport to="body">
        <div class="w-full h-full fixed top-0 left-0 bg-secondaryDarkBg/40 backdrop-blur-[1px] overflow-y-auto z-30 modalBg">

            <div class="shadow-md mx-auto rounded-md max-md:w-[70%] max-sm:w-[100%]" :class="modalClass">
                <div class="w-full h-full bg-white rounded-md p-2 shadow-inner_white" :class="innerModalClass">

                    <!-- Modal Head -->
                    <slot name="modalHead">

                        <div class="flex justify-between items-center border-b pb-1.5">
                            <div class="uppercase font-semibold ">{{storeModal.modalAction}}</div>
                            <slot name="close">
                                <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0" @click="storeModal.toggleModal">
                                    <Close closeClass="w-fit h-fit" iconClass="text-[18px]"/>
                                </button>
                            </slot>
                        </div>

                    </slot>
                    
                    <!-- Modal Body -->
                    <slot></slot>

                    <!-- Modal Footer -->
                    <slot name="modalFooter"></slot>
                </div>
            </div>

        </div>
    </teleport>

</template>

<script setup>
import { useModalStore } from '../Stores/rigthView'
import Close from './closeComponent.vue'


const storeModal = useModalStore()
defineProps({modalClass: String, innerModalClass: String})
</script>

<style>

</style>