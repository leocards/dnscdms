<template>
    <Modal v-if="storeProgram.showUser" modalClass="w-[35%] my-8" innerModalClass="p-2">
         <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
            @click="close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template> 

        <div class="w-full mt-3">

            <div class="w-full relative mb-3" v-click-outside="outsideList"> <!-- changes -->
                <input type="text" class="w-full h-10 px-2 bg-slate-100/40 outline-none rounded ring-gray-200 focus:ring-gray-400/50 ring-1" 
                placeholder="Add member" v-model="storeProgram.newMember" @keyup="storeProgram.searchNewMember()" @focus="isFocus = true"><!-- Changes -->
                <transition
                    enter-active-class="transform transition duration-500 ease-custom"
                    enter-class="-translate-y-1/2 scale-y-0 opacity-0"
                    enter-to-class="translate-y-0 scale-y-100 opacity-100"
                    leave-active-class="transform transition duration-300 ease-custom"
                    leave-class="translate-y-0 scale-y-100 opacity-100"
                    leave-to-class="-translate-y-1/2 scale-y-0 opacity-0">

                    <div class="absolute top-10 left-0 w-full h-fit rounded-md overflow-hidden" v-show="isFocus" :class="{'bg-whiteBg myshadow' : storeProgram.newMember}">
                        <transition
                            enter-active-class="transform transition duration-500 ease-custom"
                            enter-class="-translate-y-1/2 scale-y-0 opacity-0"
                            enter-to-class="translate-y-0 scale-y-100 opacity-100"
                            leave-active-class="transform transition duration-300 ease-custom"
                            leave-class="translate-y-0 scale-y-100 opacity-100"
                            leave-to-class="-translate-y-1/2 scale-y-0 opacity-0">

                            <div class="w-full h-full max-h-[20rem] overflow-auto bg-whiteBg" v-if="storeProgram.newMember">
                                <ShowUser v-for="user in storeProgram.users" :key="user.id" :user="user" />
                                
                                <div class="w-full py-3 text-center text-slate-300" v-if="storeProgram.users.length == 0"><i>No user found</i></div>
                            </div>
                        </transition>
                    </div>
                </transition>
            </div>

            <div>Assigned user:</div> 
            <div class="w-full flex gap-2 items-center mt-1.5 px-2">
                <div class="w-9 h-9 shrink-0 rounded-full overflow-hidden bg-slate-300"></div>
                <div class="Oneline h-fit">{{storeProgram.assUser.fname+' '+storeProgram.assUser.lname}}</div>
            </div>

            <div class="mt-3 w-full">
                <div>Member/s:</div>
                <div class="w-full mt-1.5 rounded-md overflow-hidden bg-slate-100/50">
                    <div class="w-full max-h-[20rem] overflow-y-auto" v-if="storeProgram.loadMember == false">

                        <div class="w-full px-2 py-1 flex items-center justify-between hover:bg-slate-200/60 group" v-for="member in storeProgram.members">
                            <div class="flex gap-2 items-center">
                                <div class="w-9 h-9 shrink-0 rounded-full overflow-hidden bg-slate-300"></div>
                                <div class="Oneline h-fit">{{member.fname + ' ' + member.lname}}</div>
                            </div>
                            <button type="button" title="remove" class="w-7 h-7 rounded-full group-hover:flex hidden items-center justify-center 
                            hover:bg-red-300/40 hover:text-red-600
                            text-slate-400">
                                <span class="material-symbols-rounded text-[18px]"> remove </span>
                            </button>
                        </div>

                    </div>

                    <div class="w-full flex items-center px-2 py-1 gap-2 animate-pulse" v-if="storeProgram.loadMember">
                        <div class="w-9 h-9 shrink-0 rounded-full overflow-hidden bg-slate-300/70"></div>
                        <div class="w-[30%] py-1.5 bg-slate-300/70 rounded-xl"></div>
                        <div class="ml-auto w-6 h-6 rounded-full bg-slate-300/70"></div>
                    </div>

                    <div class="w-full py-3 text-center text-slate-300" v-if="storeProgram.members.length === 0 && storeProgram.loadMember == false">
                        <i>No member/s</i>
                    </div>
                </div>
            </div>

        </div>

    </Modal>

</template>

<script setup>
import { useModalStore } from '../../Stores/rigthView'
import Modal from '../../Shared/Modal.vue'
import { useProgramStore } from '../../Stores/requestStore'
import Close from '../../Shared/closeComponent.vue'
import { ref, watch } from 'vue';
import ShowUser  from './showUserCard.vue'

const axios = require('axios').default;

const storeProgram = useProgramStore()
const storeModal = useModalStore()
const props = defineProps({})

const isFocus = ref(false)

const close = () => {
    storeModal.toggleModal()
    storeProgram.forms.reset()
    storeProgram.showUser = false
    storeProgram.newMember = ''
}

const outsideList = () => {
    isFocus.value = false
}

</script>
