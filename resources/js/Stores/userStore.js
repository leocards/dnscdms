import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import { useModalStore } from './rigthView'
import { useForm } from '@inertiajs/inertia-vue3';
import { useToastStore } from './Notifications'

export const useUserStore = defineStore('user', ()=>{

    const storeNotif = useToastStore()
    const form = useForm({
        fname: '',
        lname: '',
        email: '',
        institute: '',
        program: '',
        designation: '',
        password: '',
        confirm_password: '',
        id: null
    })

    const storeModal = useModalStore()
      
    const title = useForm({
        title: '',
        id: null
    })

    const findUser = id => {
        
    }

    const createUser = () => {
        form.post('/user/create', {
            onSuccess: () => {
                form.reset(),
                storeModal.toggleModal()
                storeNotif.showToast()
            }
        })
    }

    const updateUser = () => {
        form.post('/user/edit/'+form.id, {
            onSuccess: () => {
                form.reset(),
                storeModal.toggleModal()
                storeNotif.showToast()
            }
        }) 
    }
  //axios

    const createDesignation = () => {
        if(sessionStorage.getItem('btn') == 'newjob'){
            title.post('/user/create-designation', {
                onSuccess: () => {
                    title.reset(),
                    storeModal.toggleModal()
                    storeNotif.showToast()
                }
            })
        }else{
            title.post('/user/update-designation/'+title.id, {
                onSuccess: () => {
                    title.reset(),
                    storeModal.toggleModal()
                    storeNotif.showToast()
                }
            })
        }
    }

    return { form, title, createUser, createDesignation, updateUser}
})