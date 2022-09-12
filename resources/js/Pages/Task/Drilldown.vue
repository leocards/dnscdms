<template>
    <Modal modalClass="w-[37%] my-8" innerModalClass="p-2">
        <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group" @click="close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template>

        <div class="w-full flex items-center justify-center gap-10 my-3">
            <div class="w-28 h-28 bg-dnscGreen/90 shrink-0 rounded-full relative grid place-items-center progress before:bg-whiteBg" ref="progressBar">
                <div class="text-base relative progValue" ref="valueContainer">100%</div>
            </div>

            <div class="text-center">
                <div class="text-xl">Area 1</div>
                <div class="text-lg">3/10</div>
                <div>On progress</div>
            </div>
        </div>

        <div class="grid grid-cols-[repeat(auto-fill,minmax(10rem,1fr))] gap-2">
            <div class="h-9 ring-1 rounded flex justify-between items-center px-2 gap-1.5" v-for="i in 2">
                <div class="ring-1 Oneline w-full h-fit">Sample item</div>
                <div class="w-10 text-center shrink-0 ring-1">100%</div>
            </div>
        </div>
    </Modal>
</template>
<script setup>
import Modal from '../../Shared/Modal.vue'
import Close from '../../Shared/closeComponent.vue';
import { useModalStore } from '../../Stores/rigthView'
import { onMounted, ref } from 'vue';
import { useTaskStore } from '../../Stores/taskStore'

const storeTask = useTaskStore()
const storeModal = useModalStore()

const close = () =>{
    storeModal.toggleModal()
}

const progressBar = ref(null)
const valueContainer = ref(null)

let speed = 10;
let progressValue = 0;
let progressEndValue = 100;

onMounted(()=>{
    
    let progress = setInterval(() => {
        progressValue++;
        valueContainer.textContent = `${progressValue}%`;
        progressBar.value.style.background = `conic-gradient(
            #4d5bf9 ${progressValue * 3.6}deg,
            #cadcff ${progressValue * 3.6}deg
        )`;
        if (progressValue == progressEndValue) {
            clearInterval(progress);
        }
    }, speed);
})


/*  */

</script>

<style scoped>
    .progress:before{
        content: "";
        position: absolute;
        width: 80%;
        height: 80%;
        border-radius: 50%;
    }
</style>