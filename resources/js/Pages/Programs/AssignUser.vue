<template>

    <Modal modalClass="w-[35%] my-8" innerModalClass="p-2">
         <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
            @click="close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template>

        <div class="mt-3 w-full">

            <div class="w-full relative mb-4" v-click-outside="outsideList"><!-- changes -->
                <input type="text" class="w-full h-10 px-2 bg-slate-100/40 outline-none rounded ring-gray-200 focus:ring-gray-400/50 ring-1" 
                placeholder="Search user" v-model="search" @focus="isFocus = true">
                <transition
                    enter-active-class="transform transition duration-500 ease-custom"
                    enter-class="-translate-y-1/2 scale-y-0 opacity-0"
                    enter-to-class="translate-y-0 scale-y-100 opacity-100"
                    leave-active-class="transform transition duration-300 ease-custom"
                    leave-class="translate-y-0 scale-y-100 opacity-100"
                    leave-to-class="-translate-y-1/2 scale-y-0 opacity-0">

                    <div class="top-10 w-full absolute left-0 rounded overflow-hidden z-10"  v-show="isFocus" :class="{'myshadow bg-whiteBg': search}">
                        <transition
                        enter-active-class="transform transition duration-500 ease-custom"
                        enter-class="-translate-y-1/2 scale-y-0 opacity-0"
                        enter-to-class="translate-y-0 scale-y-100 opacity-100"
                        leave-active-class="transform transition duration-300 ease-custom"
                        leave-class="translate-y-0 scale-y-100 opacity-100"
                        leave-to-class="-translate-y-1/2 scale-y-0 opacity-0">
                            <div class="w-full h-full max-h-[20rem] overflow-auto bg-whiteBg" v-show="search" >

                                <Users v-for="user in searchedUser" :key="user.id" :user="user" />

                                <div class="w-full py-3 text-center text-slate-300" v-if="searchedUser.length == 0 && search"><i>No user found</i></div>

                            </div>     
                        </transition>
                    </div>
                </transition>
            </div>

            <label for="filter">Program: </label>
            <select v-model="filter" id="filter" class="w-28 shrink-0 text-center h-8 bg-slate-100/60 outline-none rounded ring-gray-200 focus:ring-gray-400/50 ring-1 mt-3">
                <option :value="program.id" v-for="program in storeProgram.allProgram">{{program.name}}</option>
            </select>

            <div class="w-full mt-3 overflow-hidden rounded-md">
                <div class="w-full max-h-[24rem] overflow-y-auto bg-slate-100/50">

                    <div class="w-full px-2 py-1 flex items-center justify-between animate-pulse" v-if="storeProgram.wait">
                        <div class="w-full flex gap-2 items-center">
                            <div class="w-9 h-9 shrink-0 rounded-full overflow-hidden bg-slate-300"></div>
                            <div class="w-full h-fit">
                                <div class="w-1/2 py-1 rounded-2xl bg-slate-300 mb-1.5"></div>
                                <div class="w-16 py-1 rounded-2xl bg-slate-300"></div>
                            </div>
                        </div>
                    </div>
                    
                    <Users v-for="user in users" :key="user.id" :user="user" />

                    <div class="w-full py-3 text-center text-slate-300" 
                    v-if="storeProgram.wait == false && users.length == 0 || filter == ''">
                        <i>No user found</i>
                    </div>
                </div>
            </div>
        </div>

    </Modal>
</template>

<script setup>
import { useModalStore } from '../../Stores/rigthView'
import Modal from '../../Shared/Modal.vue'
import Close from '../../Shared/closeComponent.vue'
import { useProgramStore } from '../../Stores/requestStore'
import { ref, watch } from 'vue';
import Users  from './userCard.vue'


const props = defineProps({program: Object})
const axios = require('axios').default;
const storeProgram = useProgramStore()
const storeModal = useModalStore()

const search = ref()
const filter = ref('')
const setFilterInst = ref()
const users = ref([])
const isFocus = ref(false)
const searchedUser = ref([])

storeProgram.forms.program, filter.value = props.program.id
setFilterInst.value = props.program.instituteId

const outsideList = () => {//changes
    isFocus.value = false
}

const close = () => {
    storeProgram.instAssign = false
    storeModal.toggleModal()
    storeProgram.forms.reset()
}

const getFilter = () => {
    storeProgram.allProgram.find((item)=>{
        if(filter.value == item.id){
            filter.value = item.id
            setFilterInst.value = item.instituteID
        }
    })
}

function getUsers(){
    return axios.get('/program/assign/user/'+filter.value+'/'+setFilterInst.value)
}
function getprograms(){
    return axios.get('/program/allProgram')
}
Promise.all([getUsers(), getprograms()])
.then(res => {
    users.value = res[0].data.users
    storeProgram.allProgram = res[1].data.programs
    storeProgram.wait = false
})


watch(filter, ()=> {
    if(filter.value != ''){
        getFilter()
        storeProgram.wait = true
        axios.get('/program/assign/user/'+filter.value+'/'+setFilterInst.value)
        .then(res => {
            users.value = res.data.users
            storeProgram.wait = false
        })
    }else{
        users.value = []
    }
})

watch(search, ()=> {//changes
    if(search.value.replace(/\s/g, '') == ''){
        search.value = ''
    }else{
        axios.get('/program/search-user/'+search.value)
        .then(res => {
            searchedUser.value = res.data.users
        })
    }
})

</script>
