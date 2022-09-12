<template>
    <Modal v-if="storeModal.modal" modalClass="w-[37%] my-8" innerModalClass="p-2">

        <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group" @click="close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template>

        <div class="mt-2 w-full flex flex-col">

            <div class="w-full h-12 rounded-md bg-slate-200/60 flex items-center px-3">
                <div class="H-full Oneline">Sample Document</div>
            </div>


            <form @submit.prevent class="w-full mt-3 p-1.5 bg-slate-200/50 rounded relative mb-3">
                <input type="text" v-model="share"
                @focus="getDropDpwn" @focusout="getDropDpwn"
                class="w-full h-8 px-2 outline-none rounded ring-gray-200 focus:ring-gray-400/70 ring-1"
                placeholder="Add user or program">

                <div class="w-full rounded-md absolute top-[2.80rem] left-0 overflow-hidden
                bg-whiteBg myshadow" v-if="dropDown">

                    <div class="ring-1 py-1 overflow-y-auto h-56">
                        <div class="w-full h-10 flex gap-2 items-center px-2 hover:bg-dnscGreen/20 hover:text-dnscGreen" v-for="i in 10">
                            <div class="ring-1 w-8 h-8 rounded-full shrink-0"></div>
                            <div class="h-fit Oneline">Hellow world</div>
                        </div>
                        <div class="w-full p-2 text-slate-300 text-center">
                            <i> " No results found " </i>
                        </div>
                    </div>

                </div>
            </form>

            <div>Accessible by:</div>
            <div class="w-full h-72 bg-slate-200/40 my-1 rounded-md overflow-hidden">
                <div class="w-full h-full overflow-y-auto overscroll-contain">
                    <div v-for="i in 15">{{i}}</div>
                </div>
            </div>
            
            <button type="" class="w-32 h-8 bg-dnscGreen rounded text-whiteBg self-end">Share</button>
        </div>

    </Modal>
</template>

<script setup>
import Modal from '../../Shared/Modal.vue';
import Close from '../../Shared/closeComponent.vue';
import { useModalStore } from '../../Stores/rigthView';
import { ref } from 'vue';

const storeModal = useModalStore()

const share = ref()
const dropDown = ref(false)

const getDropDpwn = () => {
    if(dropDown.value){
        dropDown.value = false
    }else{
        dropDown.value = true
    }
}

const close = () =>{
    storeModal.toggleModal()
}
</script>
