<template>
  <TaskHead>
    
    <template #docs v-if="search">
      <div class="w-fit flex items-center gap-1.5 px-2 py-1 border-b-2 bg-dnscGreen/10 border-dnscGreen text-dnscGreen cursor-pointer">
        Documents
        <div class="flex items-center justify-center p-0.5 hover:bg-dnscGreen/20 rounded-full cursor-pointer"  @click="search = ''">
          <span class="material-symbols-rounded text-[15px]"> close </span>
        </div>
      </div>
    </template>
    
    <div class="relative w-1/2">
      <input type="text" id="search" v-model="search" class="w-full h-8 px-2 pr-9 bg-slate-100/60 outline-none rounded ring-gray-200 focus:ring-gray-400/50 ring-1"
      placeholder="Search document">
      <span class="material-symbols-rounded text-[18px] absolute top-1.5 right-2.5 cursor-pointer" v-if="search" @click="search = ''"> close </span>
      <label for="search" v-else="search" ><span class="material-symbols-rounded text-[18px] absolute top-1.5 text-gray-400/90 right-2.5 cursor-pointer" > search </span></label>
    </div>
 
    <template #extend v-if="true">
      <div class="w-full h-9 flex border-b border-slate-300 sticky top-[2.80rem] bg-[#F3F8F5] z-10 justify-between select-none">
        <div class="max-w-[50%] h-full flex items-center relative">

          <!-- More flex-->
          <div class="w-fit  gap-1 items-center select-none relative hidden">
            <div class="flex items-center justify-center w-8 h-8 shrink-0 hover:bg-dnscGreen/20 text-dnscGreen rounded-full cursor-pointer">
                <span class="material-symbols-rounded text-lg"> more_horiz </span>
            </div>
            <span class="material-symbols-rounded text-xs"> chevron_right </span>

            <div class="absolute z-10 top-7 left-0 w-32 bg-[#F3F8F5] hidden rounded py-1 shadow-lg">
              <!-- crumbs -->
            </div>
          </div>

          <!-- Crumbs -->
          <div class="flex items-center" v-for="i in 3">
            <div class="p-1 rounded-sm hover:bg-dnscGreen/20 hover:text-dnscGreen">Parent Link</div>
            <span class="material-symbols-rounded text-sm"> chevron_right </span> 
          </div>
          <!-- current -->
          <div class="" ref="area">Area 1</div>
        </div>

        <!-- menus -->
        <div class="h-full flex items-center gap-2 pr-9" v-if="storeTask.menus">
          <div title="Upload" class="flex w-8 h-8 relative myMenus rounded-full items-center cursor-pointer justify-center shrink-0 group hover:bg-dnscGreen/20 hover:text-dnscGreen"
          @click="upload">
            <span class="material-symbols-rounded text-[18px]"> upload </span>
          </div>

          <div title="View details" class="flex w-8 h-8 relative myMenus rounded-full items-center cursor-pointer justify-center shrink-0 group hover:bg-dnscGreen/20 hover:text-dnscGreen">
            <span class="material-symbols-rounded text-[18px]"> info </span>
          </div>

          <div class="relative myMenus" v-click-outside="storeTask.moreActions" v-if="true">
            <div class="flex w-8 h-8 relative rounded-full items-center cursor-pointer
            justify-center shrink-0 group hover:bg-dnscGreen/20 hover:text-dnscGreen" title="More"
            @click="storeTask.more = !storeTask.more" :class="{'bg-dnscGreen/20' : storeTask.more}">
              <span class="material-symbols-rounded text-[18px]"> more_vert </span>
            </div>

            <Context v-if="storeTask.more"></Context>
          </div>

        </div>
      </div>
    </template>
  </TaskHead>

  <div v-if="search"></div>

  <div class="grid grid-cols-[repeat(auto-fill,minmax(17rem,1fr))] my-2 pt-2.5 gap-2">
    <TaskGrid v-for="task in Tasks" :key="task.id" :task="task"></TaskGrid>
  </div>
  
  <!-- Documents -->
  <div class="grid grid-cols-[repeat(auto-fill,minmax(17rem,1fr))] my-2 pt-2.5 gap-2">
    
  </div>

  <Upload v-if="storeModal.modalAction == 'Upload Document'"/>
  <Share v-if="storeModal.modalAction == 'Share Document'"/>
  <Drilldown v-if="storeModal.modalAction == 'Drill down'"/>
  <AssignMember v-if="storeModal.modalAction == 'Assign member'"/>

</template>

<script>
import Layout from '../Shared/Layout';
export default {
  components: { Share }, layout: Layout }
</script>
 
<script setup>
import { onMounted, ref } from 'vue';
import TaskHead from './Task/TaskHead.vue'
import TaskGrid from './Task/taskGrid.vue'
import Context from './Task/Context.vue'
import { useTaskStore } from '../Stores/taskStore'
import Upload from './Task/Upload.vue';
import { useModalStore } from '../Stores/rigthView';
import Share from './Task/Share.vue';
import Drilldown from './Task/Drilldown.vue'
import AssignMember from './Task/AssignMember.vue';

const storeModal = useModalStore()
const storeTask = useTaskStore()

const props = defineProps({Tasks: Array})

const search = ref()

const upload = () =>{
  storeModal.setModalAction('Upload Document')
  storeModal.toggleModal()
}

window.addEventListener('click', (e)=>{
  if(e.target.closest('.taskCard') || e.target.closest('.myMenus') || e.target.closest('.moreActions') || e.target.closest('.modalBg')){
    storeTask.menus = true
  }else{
    storeTask.menus =false
  }
})

</script>