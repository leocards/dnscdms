<template>
    <div class="w-full pl-2 flex gap-1 items-center py-1 border-b sticky top-0 z-10 bg-[#F3F8F5] ">
        <Link :href="crumbs.length === 0 ? '/program' : prev ? '/program/accred/'+program.id+'/'+prev.id : '/program/accred/'+program.id" 
        class="w-8 h-8 rounded-full flex items-center justify-center group hover:bg-dnscGreen/10 shrink-0">
            <span class="material-symbols-rounded group-hover:text-green-700">arrow_back</span>
        </Link>

        <div class="flex gap-2.5" @click="openFacultyStaff()">
            <div class="w-8 h-8 rounded-full flex items-center justify-center hover:bg-dnscGreen/10 group cursor-pointer"
            title="Program Members">
                <span class="material-symbols-rounded text-[20px] group-hover:text-green-700">group</span>
            </div>
        </div>

        <component :is="links.length === 0 ? 'div' : 'Link'" 
        :href="links.length === 0 ? '' : '/program/accred/'+program.id" 
        class="text-base Oneline h-fit px-1.5 rounded select-none" :class="[links.length === 0 ? '' : 'hover:bg-dnscGreen/20 hover:text-dnscGreen']"> 
            {{program.name}} 
        </component>

        <span class="material-symbols-rounded text-xs w-fit" v-if="links.length !== 0"> chevron_right </span>
        <div class="flex relative">
            <div class="w-fit flex items-center" v-for="link in links" v-if="links.length <= 3">

                <div class="flex items-center" v-if="link.id !== parent.id">
                    <Link :href="'/program/accred/'+program.id+'/'+link.id" class="w-full">
                        <div class="min-w-[0.1rem] max-w-[7.5rem] shrink-0 Oneline h-fit rounded hover:bg-dnscGreen/20 hover:text-dnscGreen p-1">
                            {{link.title}} <span v-if="link.set !== null">{{link.set}}</span>
                        </div>
                    </Link>
                    <span class="material-symbols-rounded text-xs"> chevron_right </span>
                </div>

                <div class="p-1 Oneline" v-if="parent != null && link.id === parent.id">
                    <div>{{link.title}} <span v-if="link.set !== null">{{link.set}}</span></div>
                </div>
            </div>

            <div class="flex items-center relative" v-else v-click-outside="setCloseCrumbs">
                <div class="w-fit flex gap-1 items-center select-none" 
                 @click="setBreadcrumbs">
                    <div class="flex items-center justify-center w-[1.6rem] h-[1.6rem] shrink-0 hover:bg-dnscGreen/20 text-dnscGreen rounded-full cursor-pointer">
                        <span class="material-symbols-rounded text-lg"> more_horiz </span>
                    </div>
                    <span class="material-symbols-rounded text-xs"> chevron_right </span>
                </div>

                <div class="p-1 w-full Oneline" v-if="parent != null">
                    <div class="Oneline h-fit" v-text="parent.title+' '+ [parent.set === null ? '': parent.set]"></div>
                </div>

                <div ref="crumbs" class="w-32 h-fit shadow-md absolute top-10 p-1 rounded bg-[#F3F8F5] outline-none" 
                v-if="breadCrumbsMore">
                    <div v-for="link in links" v-if="links.length > 3">
                        <div class="flex items-center" v-if="link.id !== parent.id">
                            <Link :href="'/program/accred/'+program.id+'/'+link.id" class="w-full">
                                <div class="min-w-[0.1rem] max-w-[7.5rem] shrink-0 Oneline h-fit rounded hover:bg-dnscGreen/20 hover:text-dnscGreen p-1">
                                    {{link.title}} <span v-if="link.set !== null">{{link.set}}</span>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->

    </div>

    <Modal v-if="listOfFaculty" modalClass="w-[60%] my-8" innerModalClass="p-2">
        <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
            @click="close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template>


        <div class="grid grid-cols-[repeat(auto-fill,minmax(13rem,1fr))] gap-2 mt-2" v-if="!search"><!-- when filter is same as program -->
            <div class="ring-1 ring-inset ring-gray-300 h-14 items-center rounded relative" 
            :class="{'hover:bg-slate-200/60' : assign}" 
            v-for="user in ofc">
                <div class="w-full h-full rounded flex p-2 items-center gap-2">
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-slate-400/70 shrink-0"> </div>
                    <div class="w-full">
                        <div>{{user.fname+' '+user.lname}}</div>
                        <div class="text-xs">{{user.title}}</div>
                    </div>
                </div>
            </div>

            <div class="ring-1 ring-inset ring-gray-300 h-14 items-center rounded relative" 
            :class="{'hover:bg-slate-200/60' : assign}" 
            v-for="user in members">
                <div class="w-full h-full rounded flex p-2 items-center gap-2">
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-slate-400/70 shrink-0"> </div>
                    <div class="w-full">
                        <div>{{user.fname+' '+user.lname}}</div>
                        <div class="text-xs">{{user.title}}</div>
                    </div>
                </div>
            </div>
        </div>
    </Modal>

    <ShowAssigned></ShowAssigned>
    <Sought :progInst="progInst" :assigned="assigned" :program="program"></Sought>
    <Documents v-if="false"></Documents>
    <AssignUser v-if="storeProgram.instAssign" :program="program"></AssignUser>

</template>

<script>
import Layout from '../../Shared/Layout';
export default { layout: Layout }
</script>

<script setup>

import { ref } from 'vue';
import { useModalStore } from '../../Stores/rigthView'
import Modal from '../../Shared/Modal.vue'
import Sought from './ProgramSought.vue'
import Close from '../../Shared/closeComponent.vue'
import { useToastStore } from '../../Stores/Notifications'
import { useProgramStore } from '../../Stores/requestStore'
import ShowAssigned from './showAssigned.vue';
import Documents from './Documents.vue';
import AssignUser from './AssignUser.vue'; 


const storeProgram = useProgramStore()
const storeNotif = useToastStore()

const axios = require('axios').default;
const storeModal = useModalStore()
const props = defineProps({progInst: Array, program: Object, crumbs: Array, parent: Object, prev: Object, members: Array, ofc: Array, assigned: Array})

const links = ref([])
const search = ref(null)
const assign = ref(false)
const breadCrumbsMore = ref(false)
const campusInstitute = ref([])
const listOfFaculty = ref(false)
const tagUser = ref(false)


// METHODS
if(props.parent !== null){
    props.crumbs.forEach(el => { links.value.push(el) });
}

const setBreadcrumbs = ()=>{
    breadCrumbsMore.value = !breadCrumbsMore.value
}
const setCloseCrumbs =()=>{
    breadCrumbsMore.value = false
}

const close = () => {
    listOfFaculty.value = false
    tagUser.value = false
    storeModal.toggleModal()
    storeProgram.forms.reset()
}

const openFacultyStaff = () => {
    storeModal.setModalAction('Faculty and Staff')
    storeModal.toggleModal()
    listOfFaculty.value = true
}

axios.get('/api/program/institute/')
.then((res)=>{
    campusInstitute.value = res.data.institute
})
.catch((err)=>{
    console.log(err)
})


</script>