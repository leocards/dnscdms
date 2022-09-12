<template>
    <div class="w-full h-9 border-b flex gap-4">
        <button class="w-8 h-8 rounded-full flex items-center justify-center text-slate-400 group hover:bg-dnscGreen/10 shrink-0" @click="back">
            <span class="material-symbols-rounded group-hover:text-green-700">arrow_back</span>
        </button>

        <div class="Oneline text-[1rem] mt-1.5 h-fit" title="">BSIT - Level 1 Phase 1 - Accreditation name</div>
    </div>

</template>

<script setup>
import { ref } from 'vue';
import Accordion from '../Shared/Accordion.vue'

/* emits */
const emits = defineEmits(["closeProgram"])

const back = () => { emits("closeProgram") }

/* Objects */
const instruments = ref()

//getting all the parent with null value in instruments
const getParents = () => {
    const parents = ref([])
    instruments.value.forEach(element => { element.parent == null ? parents.value.push(element) : '' });
    return parents.value
}

//getting all the child of each parents
const getChilds = id => {
    const array = ref([])
    instruments.value.forEach(element => {
        if(element.parent == id){
            array.value.push(element)
        }
    });
    return array.value != 0 ? array.value : 0 
}


</script>

<style>

</style>