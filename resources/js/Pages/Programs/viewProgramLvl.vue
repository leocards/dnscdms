<template>
    <!-- <div class="w-full mt-2">
        <Accordion  
            v-if="instruments != 0" 
            v-for="instrument in getParents()" 
            :node="instrument" 
            :getChilds="getChilds"
            :activeSession="activeSession"
            :findItems="findItems"
        />
    </div> -->
    <div>result</div>
</template>

<script setup>
import { ref } from 'vue';

const instruments = ref([
    {id: 1, name: 'Area', set: 1, description: 'description', parent: null},
    {id: 2, name: 'Area', set: 2, description: 'description', parent: null},
    {id: 3, name: 'Area', set: 3, description: 'description', parent: null},
    {id: 4, name: 'Area', set: 4, description: 'description', parent: null},
    {id: 5, name: 'Area', set: 5, description: 'description', parent: null},
    {id: 6, name: 'Area', set: 6, description: 'description', parent: null},
    {id: 7, name: 'Area', set: 7, description: 'description', parent: null},
    {id: 8, name: 'Area', set: 8, description: 'description', parent: null},
    {id: 9, name: 'Area', set: 9, description: 'description', parent: null},
    {id: 10, name: 'Area', set: 10, description: 'description', parent: null},
    {id: 22, name: 'Area', set: 11, description: 'description', parent: null},
    {id: 11, name: 'Parameter', set: 1, description: 'description', parent: 1},
    {id: 12, name: 'Parameter', set: 2, description: 'description', parent: 1},
    {id: 13, name: 'Parameter', set: 1, description: 'description', parent: 2},
    {id: 14, name: 'Parameter', set: 2, description: 'description', parent: 2},
    {id: 15, name: 'Parameter', set: 1, description: 'description', parent: 10},
    {id: 16, name: 'Parameter', set: 1, description: 'description', parent: 4},
    {id: 17, name: 'Parameter', set: 2, description: 'description', parent: 4},
    {id: 18, name: 'Parameter', set: 3, description: 'description', parent: 4},
    {id: 19, name: 'Parameter', set: 4, description: 'description', parent: 4},
    {id: 20, name: 'S', set: 1, description: 'description', parent: 11},
    {id: 21, name: 'S', set: 1, description: 'description', parent: 20},
])

const items = ref({})
let activeItems = ref([]) 
items.value.activeItems = activeItems

const actives = sessionStorage.getItem('programAccordions');
const accordion = actives.value != undefined ? JSON.parse(actives) : null

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

const activeSession = params => {
    let i = {name: params, status: false}
    activeItems.value.push(i)
    sessionStorage.setItem('programAccordions', JSON.stringify(items.value))
}

const findItems = param => {
    if(accordion != null){
        const itemsSet = ref(accordion.activeItems.find(params=>{
            return params.name == param
        }))
        /* itemsSet.value.status ? itemsSet.value.status = false : itemsSet.value.status = true;
        console.log(itemsSet.value.status) */
        return itemsSet.value.name
    }
}


</script>
