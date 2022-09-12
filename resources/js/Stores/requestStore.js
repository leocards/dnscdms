import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import { useModalStore } from './rigthView'
import { useForm } from '@inertiajs/inertia-vue3';
import { useToastStore } from './Notifications'
import { Inertia } from "@inertiajs/inertia";
import { isInteger, isNumber } from "lodash";

export const useProgramStore = defineStore('institute', ()=> {
  const axios = require('axios').default;

  const institutes = ref()
  const action = ref('Create')
  const programId = ref()
  const storeNotif = useToastStore()
  const storeModal = useModalStore()
  const showUser = ref(false)
  const assUser = ref(null)
  const instAssign = ref()
  const setView = ref(null)
  const allProgram = ref()
  const newMember = ref()
  const users = ref([])
  const form = useForm({
    name: '',
    description: '',
    institute: '',
    resolution: '',
    established: null
  })

  const forms = useForm({
    user: null,
    area: null,
    task: null,
    program: null,
    parent: null,
    role: null,
    action: null,
  })
  
  fetch('http://localhost:3000/api/program/institute/')
  .then((response) => response.json())
  .then((data) => institutes.value = data.institute)

  const setUpdate = update => {
    form.name = update.name
    form.description = update.description
    form.institute = update.instituteID
    form.resolution = update.resolution
    form.established = update.established
  }

  const loadMember = ref(false) //changes
  const members = ref([])

  const reqMember = (user, area) => {
    axios.get('/program/getAssignedMember/'+user+'/'+area)
    .then(res=> {
      loadMember.value = false
      members.value = res.data.users
    })
  }
  
  const show_user = (instrument, user, program) => {
    storeModal.setModalAction(instrument.title+' '+instrument.set)
    assUser.value = user
    forms.parent = user.user
    forms.program = program.id
    forms.role = 'member'
    forms.area = instrument.id
    storeModal.toggleModal()
    showUser.value = true
    
    loadMember.value = true //changes
    reqMember(user.user, instrument.id)
  }

  const searchNewMember = () => {
    let member = newMember.value.replace(/\s/g, '')
    if(member != ''){
        axios.get(`/program/search/${forms.parent}/${member}`)
        .then( res => {
          users.value = res.data.users
        })
    }else{
        newMember.value = ''
    }
  }

  const assignAsMember = (user) => {
    forms.user = user
    forms.post('/program/assign/member', {
      onSuccess: ()=>{
        storeNotif.showToast()
        reqMember(forms.parent, forms.area)
        newMember.value = ''
      }
    })
  }

  const wait = ref(false)
  const setAssign = (id, program) => {
    storeModal.toggleModal()
    instAssign.value = true
    storeModal.setModalAction('Assign user to '+id.title+' '+id.set)
    forms.area = id.id
    forms.task = id.id
    forms.program = program.id
    wait.value=true
  }

  const assignUserTask = (user) => {
    forms.user = user
    forms.post('/program/assignUser/', {
      onSuccess: ()=>{
          instAssign.value = false
          forms.reset(),
          storeModal.toggleModal()
          storeNotif.showToast()
      }
    })
  }

  const view = id => {
    setView.value = ''
    axios.get('/program/view/'+id)
    .then(res => {
      setView.value = res.data
    })
    .catch(() => {
      
    })

    storeModal.setModalAction('Program details')
    storeModal.toggleModal()
  }

  const close = () =>{
    storeModal.toggleModal()
    form.clearErrors()
    setView.value = null
  }
  
  const submit = () =>{
    if(action.value == 'Create'){
      form.post('/program', {
        onSuccess: page => {
          form.reset(),
          storeModal.toggleModal()
          storeNotif.showToast()
        }
      })
    }else{
      form.post('/program/update/'+ programId.value, {
        onSuccess: () => {
          form.reset(),
          storeModal.toggleModal()
          storeNotif.showToast()
        },
        onErrors: errr => {
          console.log(errr)
        }
      })
    }
  }

  return {
    instAssign, loadMember, assUser, setView, allProgram, wait, users,
    showUser, institutes, action, members, newMember,
    programId, form, forms, setUpdate, searchNewMember,
    close, submit, storeNotif, show_user, assignUserTask, reqMember, assignAsMember,
    setAssign, view}
})

export const useAccreditationStore = defineStore('accreditation', ()=> {
  const axios = require('axios').default;
  const storeModal = useModalStore()
  const storeNotif = useToastStore()
  const form = useForm({
    program: '',
    sought: '',
    title: '',
    date_survey: null,
    instruments: [],
    id: null
  })
  const instruments = ref([])
  const select = ref(false)
  const disableIfEmptyInst = ref(true)
  const action = ref()
  const wait = ref(false)

  const selectAllInst = () => {
    if(instruments.value.length !== 0){
      disableIfEmptyInst.value = false
    }else{
      disableIfEmptyInst.value = true
    }
  }
  
  const create = () => {
    storeModal.setModalAction('Create Program Accreditation')
    action.value = 'Create'
    
    wait.value = true
    axios.get('/accreditation/get-intruments')
    .then(res=>{
      instruments.value = res.data.instrument
      storeModal.toggleModal()
      selectAllInst()
      getAll()
      wait.value = false
    })
  }

  const edit = id => {
    storeModal.setModalAction('Edit Program Accreditation')
    action.value = 'Update'

    wait.value = true
    axios.get('/accreditation/edit/'+id)
    .then(res=>{
      console.log(res.status)
      form.program = res.data.accred.program_id
      form.sought = res.data.accred.title
      form.title = res.data.accred.description
      form.date_survey = res.data.accred.date_survey
      form.id = id
      wait.value = false
      storeModal.toggleModal()
    })
  }

  const close = () => {
    storeModal.setModalAction()
    form.clearErrors()
    form.reset()
    storeModal.toggleModal()
  }

  const getAll = () =>{
    if(select.value === false){
      form.instruments = []
      select.value = true
      instruments.value.forEach(element => {
        form.instruments.push(element.id)
      });
    }else{
      select.value = false
      form.instruments = []
    }
  }

  const unselectAll = id => {
    select.value = false
    if(form.instruments.length === instruments.value.length){
      select.value = true
    }
  }

  const isChecked = id => {
    return form.instruments.includes(id)
  }

  const submit = () => {
    
    if(action.value === 'Create'){
      form.post('/accreditation-create', {
        onSuccess: ()=>{
          storeModal.toggleModal()
          storeNotif.showToast()
        }
      })
    }else{
      form.post('/accreditation-update/'+form.id, {
        onSuccess: ()=>{
          storeModal.toggleModal()
          storeNotif.showToast()
        }
      })
    }
  }

  return {wait, action, disableIfEmptyInst, instruments, select, form, create, close, getAll, unselectAll, isChecked, submit, edit}
})

export const useInstrumentStore = defineStore('instrument', ()=> {
  
  const axios = require('axios').default;

  const action = ref()
  const active = ref()
  const instrument = ref()
  const storeModal = useModalStore()
  const storeNotif = useToastStore()
  const category = ref([
    {id: 1, title: 'S', description: 'System - Inputs and Processes'},
    {id: 2, title: 'I', description: 'Implementation'},
    {id: 3, title: 'O', description: 'Outcome/s'},
  ])
  const cat = useForm({
    categoryDir: null,
    parent: null,
  })

  const form = useForm({
    set: '',
    name: '',
    description: '',
    parent: null,
    category: null,
    id: null,
  })

  const create = id => {
    storeModal.setModalAction('Create Insrument')
    storeModal.toggleModal()
    action.value = 'Create'
    id !== null ? form.parent = parseInt(id.id) : form.parent = null

    if(id.category != null){
      //console.log(id.category)
      form.name = id.title
      form.category = id.title
    }
    //console.log(id)
    //console.log(form.parent)
  }

  const openCategory = () => {
    storeModal.setModalAction('Category')
    storeModal.toggleModal()
    action.value = 'Category'
  }


  const getInstruments = param => {
    instrument.value = param
  }

  const edit = id => {
    storeModal.setModalAction('Edit Instrument')
    action.value = 'Update'

    axios.get('/api/accreditation/instrument/edit/'+id)
    .then(res=>{
      form.set = res.data.instrument.set
      form.name = res.data.instrument.title
      form.description = res.data.instrument.description
      form.parent = res.data.instrument.parent
      form.id = res.data.instrument.id
      storeModal.toggleModal()
    }) 
  }

  const close = () => {
    storeModal.setModalAction()
    form.clearErrors()
    form.reset()
    storeModal.toggleModal()
  }

  const submit = ()=>{
    if(action.value == 'Create'){
      form.post('/instrument/create', {
        onSuccess: page => {
          form.reset(),
          storeModal.toggleModal()
          storeNotif.showToast()
        },
        onErrors: error => {
        }
      })
    }else{
      form.post('/accreditation/instrument/update/'+form.id, {
        onSuccess: page => {
          form.reset(),
          storeModal.toggleModal()
          storeNotif.showToast()
        },
        onErrors: error => {
        }
      })
    }
  }

  const setRemove = id => {
    storeModal.setModalAction('Remove Instrument')
    action.value = 'Remove'
    form.id=id
    storeModal.toggleModal()
    form.name = id.title
    form.set = id.set
    form.id = id.id
  }

  const remove = id => {
    Inertia.visit('/accreditation/instrument-remove/'+id, {
      method: 'get',
      onSuccess: page => {
        storeModal.toggleModal()
        form.reset()
        storeNotif.showToast()
        action.value = null
      }
    })
  }

  const createCategory = (id, parent) => {
    const categ = category.value.find((cat)=>{
      if(cat.id === id){
        return cat
      }
    })
    cat.categoryDir = categ
    cat.parent = parent
    //console.log(cat.parent)
    cat.post('/instrument/create',{
      onSuccess: ()=>{
        cat.reset()
        storeModal.toggleModal()
        storeNotif.showToast()
      },
      onError: err => {
        alert(err)
      }
    })

  }
  return {action, active, form, category, create, close, submit, storeModal, getInstruments, edit, remove, createCategory, openCategory, setRemove}
})