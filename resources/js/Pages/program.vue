<template>
  <div class="w-full py-1.5 my-2 border-b flex gap-2">
    <CreateBtn @click="create"></CreateBtn>

    <div class="w-8 h-8 rounded-full hover:bg-dnscGreen/20 flex items-center justify-center cursor-pointer programAction" v-if="select"
    @click="edit(select)">
      <span class="material-symbols-rounded hover:text-green-700 text-[18px]">drive_file_rename_outline</span>
    </div>

    <div class="w-8 h-8 rounded-full hover:bg-dnscGreen/20 flex items-center justify-center cursor-pointer programAction" v-if="select"
    @click="storeProgram.view(select)">
      <span class="material-symbols-rounded hover:text-green-700 text-[18px]">info</span>
    </div>
  </div>

  <div class="grid grid-cols-[repeat(auto-fill,minmax(17rem,1fr))] gap-2" v-if="programs">
    <!-- loop -->
    <div class="h-[5rem] hover:text-dnscGreen rounded relative ring-1 ring-inset ring-gray-300 programCard"
    v-for="program in programs" :key="program.id" 
    :class="[select == program.id ? 'bg-dnscGreen/20 text-dnscGreen' : 'hover:bg-slate-200/60']">

      <div  class="h-full w-full p-1 pl-1.5 flex flex-col justify-center cursor-default" 
      @click="selected(program.id)" 
      @dblclick="linkTo(program.id)">

        <div class="text-xl font-semibold w-fit" 
        v-text="program.name" :title="program.description"></div>

        <div class="w-full" v-if="accredit">
          <div class="w-[90%] text-xs mt-1" v-for="accred in accredit">
            <div v-if="accred.program_id == program.id">
              <div class="text-orange-700/70">Unaccredited</div>
              <div class="Oneline text-slate-400/80" v-text="accred.title"> </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- end loop -->
  </div>

  <div v-if="programs == 0" class="text-slate-400 text-center">No Programs Available</div>

  <Modal v-if="storeModal.modal && storeProgram.setView === null" modalClass="w-[33%] my-8" innerModalClass="p-2">
    <template #close>
      <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
      :disabled="storeProgram.form.processing" @click="storeProgram.close">
        <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
      </button>
    </template>

    <p class="w-full py-2 text-center bg-red-300 rounded mt-2 text-red-700" v-if="storeProgram.form.errors[0]" v-text="storeProgram.form.errors[0]"></p>

    <form @submit.prevent="storeProgram.submit">
      <div class="w-full my-2 mt-3.5">
        <div class="mb-2">
          <label for="">Name</label>
          <span class="text-pink-600 mx-2 text-xs" v-if="storeProgram.form.errors.name" v-text="storeProgram.form.errors.name"></span>
          <input type="text" id="" v-model="storeProgram.form.name" class="input-form my-1.5" placeholder="Enter">
        </div>
        
        <div class="mb-2">
          <label for="">Description</label>
          <span class="text-pink-600 mx-2 text-xs" v-if="storeProgram.form.errors.description" v-text="storeProgram.form.errors.description"></span>
          <input type="text" id="" v-model="storeProgram.form.description" class="input-form my-1.5" placeholder="Enter">
        </div>

        <div class="mb-3 relative">
          <label for="institute">Institute</label>
          <span class="text-pink-600 mx-2 text-xs" v-if="storeProgram.form.errors.institute" v-text="storeProgram.form.errors.institute"></span>
          <div class="relative bg-slate-100/60 my-1.5">
            <select name="" id="institute" v-model="storeProgram.form.institute" class="input-form z-10 relative cursor-pointer" style="background: transparent;">
              <option value="" class="text-gray-400" selected>Select</option>
              <option v-for="institute in storeProgram.institutes" :value="institute.id" v-text="institute.description"></option>
            </select>
            <span class="material-symbols-rounded text-[24px] absolute z-0 top-1 right-2 select-none"> arrow_drop_down </span>
          </div>
        </div>

        <div class="mb-2">
          <label for="">BOT Resolution</label>
          <span class="text-pink-600 mx-2 text-xs" v-if="storeProgram.form.errors.resolution" v-text="storeProgram.form.errors.resolution"></span>
          <input type="text" id="" v-model="storeProgram.form.resolution" class="input-form my-1.5" placeholder="Enter">
        </div>

        <div class="mb-2">
          <label for="">Date Established</label>
          <input type="date" id="" v-model="storeProgram.form.established" class="input-form my-1.5" placeholder="Enter">
        </div>

        <button type="submit" 
        class="w-full h-9 bg-dnscGreen/80 my-2 text-white rounded hover:bg-dnscGreen shadow-inner_white
        disabled:bg-slate-200 disabled:text-slate-500 disabled:cursor-wait"
        :disabled="storeProgram.form.processing">{{storeProgram.action}}</button>
      </div>
    </form>
  </Modal>

  <Modal v-if="storeProgram.setView" modalClass="w-[40%] my-8" innerModalClass="p-2">
    <template #close>
      <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
      :disabled="storeProgram.form.processing" @click="storeProgram.close">
        <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
      </button>
    </template>

    <div class="w-full border rounded-md mt-3.5">
      <div class="flex flex-wrap border-b px-2">
        <div class="py-1.5 w-32 mr-1.5">Program name:</div>
        <div class="py-1.5">{{storeProgram.setView.view.name}}</div>
      </div>
      <div class="flex flex-wrap border-b px-2">
        <div class="py-1.5 w-32 mr-1.5">Description:</div>
        <div class="py-1.5 max-w-[55%]">{{storeProgram.setView.view.description}}</div>
      </div>
      <div class="flex flex-wrap border-b px-2">
        <div class="py-1.5 w-32 mr-1.5">Institute:</div>
        <div class="py-1.5">{{storeProgram.setView.view.institute}}</div>
      </div>
      <div class="flex flex-wrap border-b px-2">
        <div class="py-1.5 w-32 mr-1.5">Resolution:</div>
        <div class="py-1.5">{{storeProgram.setView.view.resolution}}</div>
      </div>
      <div class="flex flex-wrap border-b px-2">
        <div class="py-1.5 w-32 mr-1.5">Established:</div>
        <div class="py-1.5">{{storeProgram.setView.view.established}}</div>
      </div>
      <div class="flex flex-wrap border-b px-2">
        <div class="py-1.5 w-32 mr-1.5">Accredited:</div>
        <div class="py-1.5 max-w-[55%]">
          <span v-for="accred in storeProgram.setView.accredited">
            {{accred.title}},
          </span>
        </div>
      </div>
      <div class="flex flex-wrap px-2">
        <div class="py-1.5 w-32 mr-1.5">Unaccredited:</div>
        <div class="py-1.5 max-w-[55%]">
          <span v-for="unaccred in storeProgram.setView.unaccredited">
            {{unaccred.title}}, 
          </span>
        </div>
      </div>
    </div>
  </Modal>

</template>

<script>
import Layout from '../Shared/Layout';
export default {
  layout: Layout
}
</script>

<script setup>
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue'
import { useModalStore } from '../Stores/rigthView'
import { useProgramStore } from '../Stores/requestStore'
import CreateBtn from '../Shared/CreateBtn.vue'
import Modal from '../Shared/Modal.vue'
import Close from '../Shared/closeComponent.vue'

const storeModal = useModalStore()
const storeProgram = useProgramStore()

const props = defineProps({programs: Array, institutes: Array, success_message: String, errors: Object, accredit: Array})

const select = ref()

const create = () => {
  storeProgram.action = 'Create'
  storeProgram.form.reset()
  storeModal.setModalAction('Create Program')
  storeModal.toggleModal()
}

const edit = id =>{
  const edit = props.programs.find((value)=> value.id === id) 

  storeProgram.action = 'Update'
  storeProgram.programId = id

  storeModal.setModalAction('Update Program')
  storeProgram.setUpdate(edit)
  storeModal.toggleModal()
}

const selected = id => {
  select.value = id
}

const linkTo = id => {
  Inertia.get('/program/accred/' +id+'/')
}

window.addEventListener('click', (e) => {
  if(e.target.closest('.programAction') || e.target.closest('.programCard') || e.target.closest('.modalBg')){
  }else{
    select.value = null
  }
})


</script>
