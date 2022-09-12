import { defineStore } from "pinia";
import { reactive, ref } from "vue";

export const useToastStore = defineStore('toast', ()=>{
    const showtToastNotification = ref(false)
    
    const showToast = ()=>{
        showtToastNotification.value = true
        setTimeout(()=>{
            showtToastNotification.value = false
        }, 3000)
    }
    return {showtToastNotification, showToast}
})