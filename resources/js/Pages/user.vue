<template>
      
  <div class="mt-5 mb-3 flex items-center justify-between">
    <div class="flex gap-2">
      <CreateBtn @click="open">
        <span class="material-symbols-rounded text-[20px]"> person_add </span>
        <div>New User</div>
      </CreateBtn>
      <CreateBtn @click="openDesignation" btnClass="px-2">
        <span class="material-symbols-rounded text-[20px]"> badge </span>
        <div>Designation</div>
      </CreateBtn>
    </div>
    <div class="relative w-1/3">
      <input type="text" id="search" v-model="search" class="w-full h-8 px-2 pr-9 bg-slate-100/60 outline-none rounded ring-gray-200 focus:ring-gray-400/50 ring-1"
      placeholder="Search">
      <span class="material-symbols-rounded text-[18px] absolute top-1.5 right-2.5 cursor-pointer" v-if="search" @click="search = ''"> close </span>
      <label for="search" v-else="search" ><span class="material-symbols-rounded text-[18px] absolute top-1.5 text-gray-400/90 right-2.5 cursor-pointer" > search </span></label>
    </div>
  </div>

  <!-- user list -->
  <table class="table-fixed border border-slate-300 border-collapse w-full mb-3">
    <thead class="font-semibold border-b border-slate-300 bg-slate-300/60">
      <tr>
        <td class="p-3 px-1.5">First name</td>
        <td class="p-3 px-1.5">Last name</td>
        <td class="p-3 px-1.5">Email</td>
        <td class="p-3 px-1.5 w-24 text-center shrink-0">Action</td>
      </tr>
    </thead>
    <tbody>
      <tr class="h-11 border-b border-slate-300" v-if="users != 0" v-for="user in users" :key="user.id">
        <td class="px-1.5">
          <div class="flex items-center gap-2">
            <div class="w-9 h-9 rounded-full ring-1 shrink-0"></div>
            <div class="h-full Oneline"> {{ user.fname }} </div>
          </div>
        </td>
        <td class="px-1.5"><div class="h-fit Oneline" v-text="user.lname"></div></td>
        <td class="px-1.5"><div class="h-fit Oneline">{{user.email}}</div></td>
        <td class="px-1.5 w-24 shrink-0">
          <div class="flex items-center justify-around">
            <span class="material-symbols-rounded text-[18px] text-gray-400/90 cursor-pointer hover:text-dnscGreen" @click="edit(user.id)"> edit_square </span>
            <span class="material-symbols-rounded text-[18px] text-gray-400/90 cursor-pointer hover:text-dnscGreen" @click="view(user.id)"> info </span>
          </div>
        </td>
      </tr>
      
      <tr v-else>
        <td>No users</td>
      </tr>
    </tbody>
  </table>

  <Modals :btn="btn" :nextModal="nextModal" @newDesignation="newDesignation" @changeModal="changeModal" :userDetails="userDetails"
  :institutes="institutes" :programs="programs" :designations="designations" :editJob="editJob" :close="close"/>

  <Teleport to="body">
    <div class="fixed top-0 left-0 w-full h-screen bg-secondaryDarkBg/40 backdrop-blur-[1px]" v-if="wait">
      <div class="w-[30%] min-h-[25%] bg-whiteBg rounded-md mx-auto my-10">
        <div class="w-full h-full p-2 flex flex-col animate-pulse">
          <div class="w-full h-8 border-b border-slate-200 flex items-center justify-between pr-3">
            <div class="w-[35%] h-2 bg-slate-200 rounded-full"></div>
            <div class="w-4 h-4 rounded-full bg-slate-200"></div>
          </div>
          <div class="w-full mt-6">
            <div class="w-[85%] h-2 bg-slate-200 rounded-full mb-3"></div>
            <div class="w-[35%] h-2 bg-slate-200 rounded-full mb-3"></div>
          </div>
          <div class="w-full h-7 bg-slate-200 rounded-full mt-3"></div>
        </div>
      </div>
    </div>
  </Teleport>

</template>

<script>
import Layout from '../Shared/Layout';
export default {
  layout: Layout
}//
</script>
 
<script setup>
import { ref } from 'vue';
import { useModalStore } from '../Stores/rigthView'
import { useUserStore } from '../Stores/userStore'
import CreateBtn from '../Shared/CreateBtn.vue'
import Modals from '../Components/User_Modals/modals.vue'

const axios = require('axios').default;
const props = defineProps({
  users: Array,
  programs: Array,
  institutes: Array,
  designations: Array,
})

const storeUser = useUserStore()
const storeModal = useModalStore()

const search = ref('')
const wait = ref(false)
const userDetails = ref()
const nextModal = ref(true)
const btn = ref(sessionStorage.getItem('btn'))

const changeModal = () => {
  nextModal.value = !nextModal.value
}

const close = () =>{
  storeModal.toggleModal()
  sessionStorage.removeItem('btn')
  btn.value = sessionStorage.getItem('btn')
}

const open = () => {
  sessionStorage.setItem('btn', 'new')
  storeModal.setModalAction('Create User')
  storeModal.toggleModal()
  storeUser.form.reset()
  btn.value = sessionStorage.getItem('btn')
  nextModal.value = true
}

const edit = id => {
  sessionStorage.setItem('btn', 'edit')
  storeModal.setModalAction('Update User')
  btn.value = sessionStorage.getItem('btn')

  wait.value = true
  axios.get('/api/user/edit/'+id)
  .then(function (response) {
    if(response.status == 200){
      wait.value = false

      storeModal.toggleModal()
      storeUser.form.fname = response.data.user.fname
      storeUser.form.lname = response.data.user.lname
      storeUser.form.email = response.data.user.email
      storeUser.form.institute = response.data.user.instituteId
      storeUser.form.program = response.data.user.programId ? response.data.user.programId : ''
      storeUser.form.designation = response.data.user.designationId
      storeUser.form.id = id
    }
  })
}

const view = id => {
  sessionStorage.setItem('btn', 'view')
  storeModal.setModalAction('User Details')

  wait.value = true
  axios.get('/user-view-info/'+id)
  .then(res=>{
    userDetails.value = res.data.user
    storeModal.toggleModal()
    wait.value = false
  })

  btn.value = sessionStorage.getItem('btn')
}

const openDesignation = () => {
  sessionStorage.setItem('btn', 'job')
  storeModal.setModalAction('Designation')
  storeModal.toggleModal()
  btn.value = sessionStorage.getItem('btn')
}

const newDesignation = () => {
  sessionStorage.setItem('btn', 'newjob')
  storeModal.setModalAction('Create Designation')
  btn.value = sessionStorage.getItem('btn')
  storeUser.title.title = ''
}

const editJob = id => {
  sessionStorage.setItem('btn', 'updateJob')
  storeModal.setModalAction('Edit Designation')
  btn.value = sessionStorage.getItem('btn')

  const job = props.designations.find(ids=>{
    return ids.id == id
  })

  storeUser.title.title = job.title
  storeUser.title.id = id
}
</script>