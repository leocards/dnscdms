<template>
  <div class="w-full py-1.5 my-2 flex gap-2 border-b">
    <CreateBtn @click="create"></CreateBtn>

    <div class="w-8 h-8 shrink-0 rounded-full hover:bg-dnscGreen/20 hover:text-dnscGreen cursor-pointer flex items-center justify-center instituteAction"
    @click="setUpdate" v-if="select">
      <span class="material-symbols-rounded text-[18px]">drive_file_rename_outline</span>
    </div>
    <div class="w-8 h-8 shrink-0 rounded-full hover:bg-dnscGreen/20 hover:text-dnscGreen cursor-pointer flex items-center justify-center instituteAction"
    @click="setViewDetails" v-if="select">
      <span class="material-symbols-rounded text-[18px]">info</span>
    </div>
  </div>

  <div class="grid grid-cols-[repeat(auto-fill,minmax(17rem,1fr))] gap-3" v-if="institutes != 0">
    <div class="h-[4.5rem] ring-1 ring-inset ring-gray-300 rounded relative p-2 group flex flex-col justify-center instituteCard cursor-default"
    :class="[select == institute.id ? 'bg-dnscGreen/20 text-dnscGreen' : 'hover:bg-slate-200/60']"
    v-for="institute in institutes" :key="institute.id" @click="selected(institute.id)">
      <div class="text-2xl font-semibold">{{institute.name}}</div>
      <p class="text-xs italic">{{institute.description}}</p>
    </div>
  </div>

  <div class="w-full text-slate-400 text-center" v-else>No Institutes Available</div>

  <!-- Modals -->
  <Modal v-if="storeModal.modal && storeModal.modalAction !== 'Institute Details'" modalClass="w-[37%] my-8" innerModalClass="p-2">
    <template #close>
      <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
      :disabled="form.processing" @click="close">
        <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
      </button>
    </template>

    <form @submit.prevent="submit">
      <div class="my-2 mt-3.5">
        <p class="w-full py-2 mb-2 text-center bg-red-300 rounded mt-2 text-red-700" v-if="form.errors[0]" 
          v-text="form.errors[0]"></p>
        <div class="mb-2">
          <label for="name">Name</label>
          <span class="text-pink-600 mx-2 text-xs" v-if="form.errors.name" v-text="form.errors.name"></span>
          <input type="text" id="name" v-model="form.name" class="input-form my-1.5" placeholder="Enter">
        </div>

        <div class="mb-2">
          <label for="description">Description</label>
          <span class="text-pink-600 mx-2 text-xs" v-if="form.errors.description" v-text="form.errors.description"></span>
          <input type="text" id="description" v-model="form.description" class="input-form my-1.5" placeholder="Enter">
        </div>

        <div class="mb-3 relative">
          <label for="dean">Dean</label>
          <div class="relative bg-slate-100/60 my-1.5">
            <select name="" id="" v-model="form.dean" class="input-form z-10 relative cursor-pointer" style="background: transparent;">
              <option value="" class="text-gray-400">Select</option>
              <option v-for="dean in deans" :value="dean.id">{{dean.fname+' '+dean.lname}}</option>
            </select>
            <span class="material-symbols-rounded text-[24px] absolute z-0 top-1 right-2 select-none"> arrow_drop_down </span>
          </div>
        </div>

        <div class="mb-2">
          <label for="established">Date Established</label>
          <input type="date" id="established" v-model="form.established" class="input-form my-1.5" placeholder="Enter">
        </div>

        <button type="submit" 
        class="w-full h-9 bg-dnscGreen/80 my-2 text-white rounded hover:bg-dnscGreen shadow-inner_white disabled:bg-slate-200 disabled:text-slate-500
        disabled:cursor-wait" 
        :disabled="form.processing"><div v-if="action">Create</div> <div v-else>Update</div></button>
      </div>
    </form>
  </Modal>

  <Modal v-if="storeModal.modal && storeModal.modalAction == 'Institute Details'" modalClass="w-[37%] my-8" innerModalClass="p-2">
    <div class="my-2 mt-3.5">
      <div class="w-full border rounded">
        <div class="flex flex-wrap border-b px-2">
          <div class="py-1.5 w-24 mr-1.5">Name:</div>
          <div class="py-1.5">{{info.name}}</div>
        </div>

        <div class="flex flex-wrap border-b px-2">
          <div class="py-1.5 w-24 mr-1.5">Description:</div>
          <div class="py-1.5">{{info.description}}</div>
        </div>

        <div class="flex flex-wrap border-b px-2">
          <div class="py-1.5 w-24 mr-1.5">Dean:</div>
          <div class="py-1.5">
            <div v-for="dean in deans">
              <span v-if="dean.id == info.Dean">{{dean.fname+' '+dean.lname}}</span>
            </div>
          </div>
        </div>

        <div class="flex flex-wrap px-2">
          <div class="py-1.5 w-24 mr-1.5">Established:</div>
          <div class="py-1.5">{{info.established}}</div>
        </div>
      </div>
    </div>
  </Modal>
</template>

<script>
import Layout from '../Shared/Layout';
import { Inertia } from '@inertiajs/inertia';
export default { layout: Layout }
</script>
 
<script setup>
import { ref } from 'vue';
import { useToastStore } from '../Stores/Notifications'
import { useForm } from '@inertiajs/inertia-vue3';
import { useModalStore } from '../Stores/rigthView'
import CreateBtn from '../Shared/CreateBtn.vue'
import Modal from '../Shared/Modal.vue'
import Close from '../Shared/closeComponent.vue'

const storeModal = useModalStore()
const storeNotif = useToastStore()

const props = defineProps({institutes: Array, deans: Array})

const form = useForm({
  name: null,
  description: null,
  dean: '',
  established: null,// Y-m-d
})

const action = ref(true)
const info = ref()
const ids = ref()
const select = ref()

// METHODS

const create = () =>{
  storeModal.setModalAction('Create Institute')
  storeModal.toggleModal()
}

const selected = id => {
  select.value = id
  return id
}

const setUpdate = () => {
  edit(select.value)
}

const setViewDetails = () => {
  setView(select.value)
}

const edit = id =>{
  const edit = props.institutes.find((value)=> value.id === id)

  action.value = false
  ids.value = id

  storeModal.setModalAction('Update Institute')
  storeModal.toggleModal()

  form.name = edit.name
  form.description = edit.description
  form.established = edit.established
  form.dean = edit.Dean ? edit.Dean : ''

}

const close = () =>{
  form.reset()
  storeModal.toggleModal()
}

const setView = id =>{
  const view = props.institutes.find((value)=> value.id === id)

  storeModal.setModalAction('Institute Details')
  storeModal.toggleModal()

  info.value = view
}

const submit = () =>{
  if(action.value){
    form.post('/institute', {
      onSuccess: () => {
        form.reset(),
        storeModal.toggleModal()
        storeNotif.showToast()
      }
    })
  }else{
    form.post('/institute/update/'+ids.value, {
      onSuccess: () => {
        form.reset(),
        storeModal.toggleModal()
        storeNotif.showToast()
      }
    })
  }
}

window.addEventListener('click', (e) => {
  if(e.target.closest('.instituteCard') || e.target.closest('.instituteAction') || e.target.closest('.modalBg')){
  }else{
    select.value = null
  }
})

</script>
