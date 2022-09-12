import { defineStore } from "pinia";
import { reactive, ref } from "vue";
import { useModalStore } from './rigthView'
import { useForm } from '@inertiajs/inertia-vue3';

export const useTaskStore = defineStore('task', ()=> {

    const storeModal = useModalStore()

    const form = useForm({
        id: null
    })
    const context = ref()
    const taskId = ref()
    const more = ref(false)
    const selects = ref()

    const dummy = ref(
        {id: 1, text: 'document 1'},
        {id: 2, text: 'document 2'},
        {id: 3, text: 'document 3'},
        {id: 4, text: 'document 4'},
        {id: 5, text: 'document 5'},
    )

    const close = () => {
        storeModal.toggleModal()
    }

    const upload = id => {
        storeModal.setModalAction('Create Insrument')
        storeModal.toggleModal()
        form.id = id
    }

    const moreActions = ()=>{
        more.value = false
    }

    return {selects, more, storeModal, taskId, context, close, upload, moreActions, dummy}
})