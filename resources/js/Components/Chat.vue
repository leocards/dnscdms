<template>
    <div class="my-1 relative flex items-center">
        <input class="bg-[#e4e6eb]/50 w-full h-9 outline-none pl-3.5 pr-10 py-1.5 rounded-full" type="text" v-model="search" placeholder="Search User">
        <div class="absolute right-1.5 dark:hover:bg-dnscGreen/10 group w-7 h-7 rounded-full flex items-center justify-center cursor-pointer" 
        v-if="search" @click="clearSearch">
            <Close closeClass="w-fit h-fit" iconClass="text-[18px]"/>
        </div>
    </div>

    <!-- active users -->
    <div class="w-full min-h-[3rem] py-1  relative overflow-hidden">
        <div class="flex gap-1.5">
            <div class="rounded-full ring-1 ring-inset ring-green-600 w-10 h-10 overflow-hidden">
                <!-- <img src="" alt=""> -->
            </div>
        </div>

        <!-- next and prev button -->
        <button class="w-6 h-6 flex items-center justify-center rounded-full group hover:bg-gray-200 absolute top-3 right-0">
            <span class="material-symbols-rounded text-[19px] text-gray-300 group-hover:text-gray-600"> navigate_next </span>
        </button>
        <button class="w-6 h-6 flex items-center justify-center rounded-full group hover:bg-gray-200 absolute top-3 left-0">
            <span class="material-symbols-rounded text-[19px] text-gray-300 group-hover:text-gray-600"> navigate_before </span>
        </button>
    </div>

    <!-- messages -->
    <div class="w-full h-fit flex flex-col gap-1 py-1.5">

        <div class="w-full h-14 rounded bg-gray-100" v-for="i in 20" :key="i" @click="storeRightView.showRightComponent('conversation')">{{i}}</div>

    </div>
</template>

<script setup>
import { ref } from 'vue'
import Close from '../Shared/closeComponent.vue'
import { useRightViewStore } from '../Stores/rigthView'

const search = ref('')
const clearSearch = ()=>{
    search.value = ''
}

const storeRightView = useRightViewStore()
</script>

<style>

</style>