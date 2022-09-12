<template>
    <Modal  v-if="storeModal.modal" modalClass="w-[37%] my-8" innerModalClass="p-2">

        <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group" @click="close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template>

        <div class="mt-2 w-full">
            <form class="h-fit">
                <div class="w-full mb-2">
                    <label for="title" class="w-fit">Title: </label>
                    <input type="text" class="input-form my-1.5" placeholder="Enter">
                </div>

                <div class="flex flex-col">
                    <label for="description">Description</label>
                    <textarea placeholder="Enter" class="ring-1 outline-none my-1.5 resize-auto min-h-[4.5rem] p-2 max-h-[13rem] grow rounded bg-slate-100/60
                    ring-gray-200 focus:ring-gray-400/50"></textarea>
                </div>

                <button type="button" 
                class="w-full h-9 bg-dnscGreen/80 my-2 mt-5 text-white rounded hover:bg-dnscGreen shadow-inner_white disabled:bg-slate-200 disabled:text-slate-500
                disabled:cursor-wait" >Upload</button>
            </form>
        </div>

    </Modal>
</template>

<script setup>
import Modal from '../../Shared/Modal.vue';
import Close from '../../Shared/closeComponent.vue';
import { useModalStore } from '../../Stores/rigthView';

const storeModal = useModalStore() 

const close = () =>{

    storeModal.toggleModal()
}
</script>