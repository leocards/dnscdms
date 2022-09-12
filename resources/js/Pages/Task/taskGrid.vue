<template>
    <div class="h-20 rounded flex flex-col p-1.5 py-1 relative ring-1 ring-inset ring-gray-300 group taskCard" :id="'taskRef'+task.id"
    :class="[selected == true ? 'bg-dnscGreen/20 text-dnscGreen' : 'hover:bg-slate-200/60']" 
    @click="getSelected(task.id)">
        <!-- <button class="min-w-[2rem] z-10 max-w-fit absolute top-1 right-1 px-1 text-center rounded-sm hover:bg-slate-200 text-orange-600 text-xs"
        @click="getdrillDown">98 %</button> -->
        <i class="absolute text-slate-400/80">{{task.program}}</i>
        <div class="w-full grow flex items-center text-base gap-2 cursor-default" :class="{'pb-2.5' : task.dueDate}"
        @click.self="">
            {{task.title}} {{task.set}}
        </div>
        
        <div class="text-xs w-fit p-0.5 rounded-sm absolute bottom-1 left-1" v-if="task.dueDate">Due: <span>{{task.dueDate}}</span></div>
        <!-- <button class="hover:bg-dnscGreen/20 hover:text-dnscGreen text-xs w-fit p-0.5 px-1.5 rounded-sm absolute bottom-1 right-1" @click="">1 Comment</button> -->
        
    </div>

</template>

<script setup>
import { onMounted, ref } from 'vue';
import Context from './Context.vue'
import { useTaskStore } from '../../Stores/taskStore'

const storeTask = useTaskStore()
const props = defineProps({task: Object})
const emits = defineEmits(['openTask', 'drillDown', 'openComment'])

const selected = ref(false)

document.addEventListener('click', e=>{
    if(e.target.closest('#taskRef'+props.task.id) || e.target.closest('.myMenus') || e.target.closest('.moreActions') || e.target.closest('.modalBg')){
        selected.value = selected.value
    }else{
        selected.value = false
    }
})

const getSelected = (id) => {
    selected.value = true
}
</script>