import { defineStore } from "pinia";
import { ref } from "vue";

export const useRightViewStore = defineStore('rightView', ()=>{
    const rightView = ref(localStorage.getItem('rightView') || null);
    
    function showRightComponent(param){
        localStorage.setItem('rightView', param)
        rightView.value = localStorage.getItem('rightView')
    }

    function closeRightComponent(){  
        rightView.value = null
        localStorage.removeItem('rightView')
    }

    return { rightView, showRightComponent, closeRightComponent}
})

export const useModalStore = defineStore('modal', ()=>{
    const modal = ref(false)
    const modalAction = ref('')

    function setModalAction(params) {
        modalAction.value = params
    }

    function toggleModal(){
        if(!modal.value){
            modal.value = true
        }else{
            modalAction.value = ''
            modal.value = false
        }
        modal.value ? document.body.style.overflow = 'hidden' : document.body.style.overflow = ''
    }

    modal.value ? document.body.style.overflow = 'hidden' : document.body.style.overflow = ''

    return {modal, modalAction, toggleModal, setModalAction}
})