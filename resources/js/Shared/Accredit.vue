<template>
  <div class="w-full py-1.5 my-2 mt-0" v-if="openProgram == null">
    <CreateBtn @click="open"></CreateBtn>
  </div>

  <div class="grid grid-cols-[repeat(auto-fill,minmax(17rem,1fr))] gap-2" v-if="openProgram == null">
    <div class="h-fit relative group" v-for="i in 5" :key="i" >
      <div class="h-24 group-hover:bg-slate-300/50 ring-1 ring-slate-200 shadow rounded relative p-2 cursor-pointer" @click="showProgram">
        <div class="text-2xl font-semibold">IC</div>
        <p class="text-xs italic">Institute of Computing</p>
      </div>
      <button class="w-fit hidden absolute bottom-1.5 right-2 group-hover:flex gap-1.5">
        <span class="material-symbols-rounded hover:text-green-700">drive_file_rename_outline</span>
      </button>
    </div>
  </div>

  <Program v-if="openProgram == 'show'" @closeProgram="showProgram"/>

  <!-- Modal -->
  <Modal v-if="storeModal.modal && changeModal == null" modalClass="w-[33%] my-8" innerModalClass="p-2">
    <div class="w-full my-2 mt-3.5">
      <div class="mb-3 relative">
        <label for="program">Program</label>
        <div class="relative bg-slate-100/60 my-1.5">
          <select name="" id="program" class="input-form z-10 relative cursor-pointer" style="background: transparent;">
            <option value="" class="text-gray-400" selected>Select program</option>
            <option value="" class="text-gray-400">Select</option>
          </select>
          <span class="material-symbols-rounded text-[24px] absolute z-0 top-1 right-2 select-none"> arrow_drop_down </span>
        </div>
      </div>

      <div class="mb-2">
        <label for="sought">Accreditation sought</label>
        <input type="text" id="sought" class="input-form my-1.5" placeholder="Enter">
      </div>

      <div class="mb-2">
        <label for="title">Title</label>
        <input type="text" id="title" class="input-form my-1.5" placeholder="Enter">
      </div>

      <div class="mb-2">
        <label for="date">Date of Survey</label>
        <input type="date" id="date" class="input-form my-1.5" placeholder="Enter">
      </div>

      <button type="submit" class="w-full h-9 bg-dnscGreen/80 my-2 text-white rounded hover:bg-dnscGreen shadow-inner_white" @click="showModal2">Next</button>
    </div>
  </Modal>

  <Modal v-if="storeModal.modal && changeModal" modalClass="w-[40%] my-8" innerModalClass="p-2">
    <div class="w-full my-2 mt-3">
      <div class="flex justify-between items-center">
        <span>Add Instrument</span>
        <button class="flex justify-between items-center gap-1 px-1.5" :class="{'text-dnscGreen/90 font-bold' : selectAll}" @click="selects">
          <span class="material-symbols-rounded text-[16px] select-none" v-if="selectAll">checklist_rtl</span> Select All
        </button>
      </div>

      <div class="w-full my-2">
         <div class="w-full h-10 rounded flex items-center px-2 justify-between mb-1 bg-slate-300/40" v-for="obj in obj">
          <div></div>
         </div>
      </div>

      <button type="submit" class="w-full h-9 bg-dnscGreen/80 my-2 text-white rounded hover:bg-dnscGreen shadow-inner_white" @click="showModal2">Add</button>
    </div>
  </Modal>


</template>

<script setup>
import { ref } from 'vue';
import { useModalStore } from '../Stores/rigthView'
import CreateBtn from '../Shared/CreateBtn.vue'
import Program from '../Components/AccreditProgram.vue'
import Modal from './Modal.vue'

const storeModal = useModalStore()

// reference for opening a program accreditation
const openProgram = ref(localStorage.getItem('openProgram'))

// reference for changing modal 
const changeModal = ref(sessionStorage.getItem('changeModal'))

const selectAll = ref(false)

const selects = () => {
  selectAll.value = !selectAll.value
}

// open a program when click
const showProgram = () => {
  if(openProgram.value == null) {
    localStorage.setItem('openProgram', 'show')
    openProgram.value = localStorage.getItem('openProgram')
  }else{
    localStorage.removeItem('openProgram')
    openProgram.value = localStorage.getItem('openProgram')
    sessionStorage.clear()
  }
}

// opens a modal
const open = () => {
  storeModal.setModalAction('Create Program Accreditation')
  storeModal.toggleModal()
  sessionStorage.removeItem('changeModal')
  changeModal.value = sessionStorage.getItem('changeModal')
}

// open next modal
const showModal2 = () => {
  if(sessionStorage.getItem('changeModal') == null){
    sessionStorage.setItem('changeModal', 'true')
    changeModal.value = sessionStorage.getItem('changeModal')
  }else{
    sessionStorage.removeItem('changeModal')
    changeModal.value = sessionStorage.getItem('changeModal')
  }
}

</script>
