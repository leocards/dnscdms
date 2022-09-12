<template>

    <!-- <div class="h-16 ring-1 rounded">

        <button class="w-full h-full" >
            <div class="w-full h-full flex items-center px-2">Area 1</div>
        </button>

    </div> -->
    <div :class="marginLeft" class="select-none">
        <div class="w-full h-11  group rounded relative hover:accordion-active flex items-center sm:text-base lg:text-sm px-2 justify-between mb-1 ring-dnscGreen/70" 
        :class="[childs ? 'accordion-active' : 'bg-slate-300/40']">

            <div class="Oneline">{{node.title + " "}} <span v-if="node.set">{{node.set}}</span> <span class="ml-2.5">{{node.description}}</span></div>
            
            <div class="flex gap-2">
                <slot>
                    <div class="hidden gap-2 items-center h-full my-auto group-hover:flex">
                        <button class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center hover:bg-dnscGreen/20 hover:text-dnscGreen relative"
                        @click="storeInstrument.create(node.id)">
                            <span class="material-symbols-rounded text-[18px]"> create_new_folder </span>
                        </button>

                        <button class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center hover:bg-dnscGreen/20 hover:text-dnscGreen relative"
                        >
                            <span class="material-symbols-rounded text-[18px]"> drive_file_rename_outline </span>
                        </button>

                        <button class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center hover:bg-dnscGreen/20 hover:text-dnscGreen relative"
                        >
                            <span class="material-symbols-rounded text-[18px]"> delete </span>
                        </button>
                    </div>
                </slot>

                <div class="w-9 h-9 flex items-center justify-center hover:accordion-active rounded-full cursor-pointer" 
                @click="getChilds(node.id)">
                    <span class="material-symbols-rounded text-[28px] select-none" v-if="childs"> arrow_drop_down </span>
                    <span class="material-symbols-rounded text-[28px] select-none" v-else> arrow_right </span>
                </div>
            </div>
        </div>

        <div v-if="childs === 'empty'" class="w-full py-0.5 text-xs">
            empty
        </div>
 
        <div v-else>
            <Grid 
                v-for="child in childs"
                marginLeft="pl-5"
                :node="child"
            />
        </div>


    </div>

</template>

<script setup>
import { ref } from 'vue';
import { useInstrumentStore } from '../../Stores/requestStore';

const axios = require('axios').default;
const storeInstrument = useInstrumentStore()
const emits = defineEmits(['clickInstrument'])
const props = defineProps({
    node: Object, 
    marginLeft: String, 
})

const childs = ref()

const getChilds = id => {
    if(childs.value == null){
        axios.get('/api/instruments/'+id)
        .then(function (response) {
            if(response.data.childrens == 0){
                childs.value = 'empty'
            }else{
                childs.value = response.data.childrens
            }
        })
        .catch(function (error) {
            console.log(error);
        })
    }else{
        childs.value = null
    }
}


</script>