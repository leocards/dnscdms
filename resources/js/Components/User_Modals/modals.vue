<template>

    <!-- New User -->
    <Modal v-if="storeModal.modal && btn == 'new'" modalClass="w-[33%] my-8" innerModalClass="p-2">
        <form @submit.prevent="storeUser.createUser">
            <keep-alive>
                <div class="my-2 mt-3.5" v-if="nextModal">
                    <div class="mb-2">
                        <label for="fname">First Name</label>
                        <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.fname" v-text="storeUser.form.errors.fname"></span>
                        <input type="text" id="fname" v-model="storeUser.form.fname" class="input-form my-1.5" placeholder="Enter">
                    </div>
                    <div class="mb-2">
                        <label for="lname">Last Name</label>
                        <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.lname" v-text="storeUser.form.errors.lname"></span>
                        <input type="text" id="lname" v-model="storeUser.form.lname" class="input-form my-1.5" placeholder="Enter">
                    </div>
                    <div class="mb-2">
                        <label for="email">Email</label>
                        <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.email" v-text="storeUser.form.errors.email"></span>
                        <input type="email" id="email" v-model="storeUser.form.email" class="input-form my-1.5" placeholder="Enter">
                    </div>

                    <div class="mb-3 relative">
                        <label for="designation">Designation</label>
                        <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.designation" v-text="storeUser.form.errors.designation"></span>
                        <div class="relative bg-slate-100/60 my-1.5">
                            <select name="" id="designation" v-model="storeUser.form.designation" class="input-form z-10 relative cursor-pointer" style="background: transparent;">
                                <option value="" class="text-gray-400">Select</option>
                                <option :value="job.id" v-for="job in designations" v-text="job.title"></option>
                            </select>
                            <span class="material-symbols-rounded text-[24px] absolute z-0 top-1 right-2 select-none"> arrow_drop_down </span>
                        </div>
                    </div>

                    <div class="mb-3 relative">
                        <label for="institute">Institute</label>
                        <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.institute" v-text="storeUser.form.errors.institute"></span>
                        <div class="relative bg-slate-100/60 my-1.5">
                            <select name="" id="institute" v-model="storeUser.form.institute" class="input-form z-10 relative cursor-pointer" 
                            @change="progs(storeUser.form.institute)"
                            style="background: transparent;">
                                <option value="" class="text-gray-400">Select</option>
                                <option v-for="institute in institutes" :value="institute.id" v-text="institute.description"></option>
                            </select>
                            <span class="material-symbols-rounded text-[24px] absolute z-0 top-1 right-2 select-none"> arrow_drop_down </span>
                        </div>
                    </div>

                    <div class="mb-3 relative">
                        <label for="program">Program</label>
                        <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.program" v-text="storeUser.form.errors.program"></span>
                        <div class="relative bg-slate-100/60 my-1.5">
                            <select name="" id="program" v-model="storeUser.form.program" class="input-form z-10 relative cursor-pointer" style="background: transparent;">
                                <option value="" class="text-gray-400">Select</option>
                                <option :value="prog.id" v-for="prog in programList" v-text="prog.name" v-if="programList"></option>
                                <option :value="prog.id" v-for="prog in programs" v-text="prog.name" v-else></option>
                            </select>
                            <span class="material-symbols-rounded text-[24px] absolute z-0 top-1 right-2 select-none"> arrow_drop_down </span>
                        </div>
                    </div>

                    <button type="submit" class="w-full h-9 bg-dnscGreen/80 my-2 text-white rounded hover:bg-dnscGreen shadow-inner_white" @click="modalChange">Next</button>
                </div>
            </keep-alive>

            <keep-alive>
                <div v-if="nextModal == false" class="my-2 mt-3.5">

                    <div class="mb-2 text-center text-xl">
                        Set Password
                    </div>

                    <div class="mb-2">
                        <label for="password">Password</label>
                        <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.password" v-text="storeUser.form.errors.password"></span>
                        <input type="password" id="password" v-model="storeUser.form.password" class="input-form my-1.5" placeholder="Enter">
                    </div>

                    <div class="mb-2">
                        <label for="confirmpassword">Confirm Password</label>
                        <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.confirm_password" v-text="storeUser.form.errors.confirm_password"></span>
                        <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors[0]" v-text="storeUser.form.errors[0]"></span>
                        <input type="password" id="confirmpassword" v-model="storeUser.form.confirm_password" class="input-form my-1.5" placeholder="Enter">
                    </div>

                    <button type="submit" class="w-full h-9 bg-dnscGreen/80 my-2 text-white rounded hover:bg-dnscGreen shadow-inner_white">Create</button>
                    
                    <button type="button" class="w-full h-9 mt-2 shadow-inner_white text-gray-500 bg-gray-200 rounded hover:bg-gray-300"
                    @click="modalChange">Back</button>
                </div>  
            </keep-alive>
        </form>
    </Modal>

    <!-- Edit User -->
    <Modal v-if="storeModal.modal && btn == 'edit'" modalClass="w-[33%] my-8" innerModalClass="p-2">
        <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
            :disabled="storeUser.form.processing" @click="close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template>

        <form @submit.prevent="storeUser.updateUser">
            <div class="my-2 mt-3.5">
                <div class="mb-2">
                    <label for="fname">First Name</label>
                    <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.fname" v-text="storeUser.form.errors.fname"></span>
                    <input type="text" id="fname" v-model="storeUser.form.fname" class="input-form my-1.5" placeholder="Enter">
                </div>
                <div class="mb-2">
                    <label for="lname">Last Name</label>
                    <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.lname" v-text="storeUser.form.errors.lname"></span>
                    <input type="text" id="lname" v-model="storeUser.form.lname" class="input-form my-1.5" placeholder="Enter">
                </div>
                <div class="mb-2">
                    <label for="email">Email</label>
                    <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.email" v-text="storeUser.form.errors.email"></span>
                    <input type="email" id="email" v-model="storeUser.form.email" class="input-form my-1.5" placeholder="Enter">
                </div>
                <div class="mb-3 relative">
                    <label for="designation">Designation</label>
                    <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.designation" v-text="storeUser.form.errors.designation"></span>
                    <div class="relative bg-slate-100/60 my-1.5">
                        <select name="" id="designation" v-model="storeUser.form.designation" class="input-form z-10 relative cursor-pointer" style="background: transparent;">
                            <option value="" class="text-gray-400">Select</option>
                            <option :value="job.id" v-for="job in designations" v-text="job.title"></option>
                        </select>
                        <span class="material-symbols-rounded text-[24px] absolute z-0 top-1 right-2 select-none"> arrow_drop_down </span>
                    </div>
                </div>
                <div class="mb-3 relative"> 
                    <label for="institute">Institute</label>
                    <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.form.errors.institute" v-text="storeUser.form.errors.institute"></span>
                    <div class="relative bg-slate-100/60 my-1.5">
                        <select name="" id="institute" v-model="storeUser.form.institute" class="input-form z-10 relative cursor-pointer" 
                        @change="progs(storeUser.form.institute)"
                        style="background: transparent;">
                            <option value="" class="text-gray-400">Select</option>
                            <option v-for="institute in institutes" :value="institute.id" v-text="institute.description"></option>
                        </select>
                        <span class="material-symbols-rounded text-[24px] absolute z-0 top-1 right-2 select-none"> arrow_drop_down </span>
                    </div>
                </div>
                <div class="mb-3 relative">
                    <label for="program">Program</label>
                    <div class="relative bg-slate-100/60 my-1.5">
                        <select name="" id="program" v-model="storeUser.form.program" class="input-form z-10 relative cursor-pointer" style="background: transparent;">
                            <option value="" class="text-gray-400">Select</option>
                            <option :value="prog.id" v-for="prog in programList" v-text="prog.name" v-if="programList"></option>
                            <option :value="prog.id" v-for="prog in programs" v-text="prog.name" v-else></option>
                        </select>
                        <span class="material-symbols-rounded text-[24px] absolute z-0 top-1 right-2 select-none"> arrow_drop_down </span>
                    </div>
                </div>

                <button type="submit" 
                :disabled="storeUser.form.processing" 
                class="w-full h-9 bg-dnscGreen/80 my-2 text-white rounded hover:bg-dnscGreen shadow-inner_white disabled:cursor-wait
                disabled:bg-slate-200 disabled:text-slate-500">Update</button>
            </div>
        </form>
    </Modal>

    <!-- View User Information -->
    <Modal v-if="storeModal.modal && btn == 'view'" modalClass="w-[40%] my-8" innerModalClass="p-2">
        <div class="my-2 mt-3.5">
            <div class="w-full ring-1 ring-slate-300 rounded">
                <div class="w-full py-1.5 border-b border-slate-300  flex flex-wrap px-1.5">
                    <div class="w-32">Name: </div>
                    <div>{{userDetails.fname + ' ' + userDetails.lname}}</div>
                </div>

                <div class="w-full py-1.5 border-b border-slate-300  flex flex-wrap px-1.5">
                    <div class="w-32">Email: </div>
                    <div>{{userDetails.email}}</div>
                </div>

                <div class="w-full py-1.5 border-b border-slate-300  flex flex-wrap px-1.5">
                    <div class="w-32">Designation: </div>
                    <div>{{userDetails.title}}</div>
                </div>

                <div class="w-full py-1.5 border-b border-slate-300  flex flex-wrap px-1.5">
                    <div class="w-32">Institute: </div>
                    <div>{{userDetails.institute}}</div>
                </div>

                <div class="w-full py-1.5 flex flex-wrap px-1.5">
                    <div class="w-32">Program: </div>
                    <div>{{userDetails.program}}</div>
                </div>
            </div>
        </div>
    </Modal>
    
    <!-- View Designation -->
    <Modal v-if="storeModal.modal && btn == 'job'" modalClass="w-[30%] my-8" innerModalClass="p-2">
        <div class="my-2 mt-3.5">
            <div class=" text-right mb-3 "><span class="hover:text-dnscGreen hover:font-semibold cursor-pointer" @click="newJob">Add new</span></div>

            <div class="px-4">
                <div class="font-semibold mb-1.5">Title:</div>
                <ul class="w-full">
                    <li v-for="job in designations" :key="job.id" class="flex w-full justify-between items-center py-1">
                        <div v-text="job.title"></div>
                        <button class="w-7 h-7 rounded-full items-center flex justify-center hover:bg-dnscGreen/20 hover:text-dnscGreen" @click="editJob(job.id)">
                            <span class="material-symbols-rounded text-[18px]"> edit </span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </Modal>

    <!-- New Designation -->
    <Modal v-if="storeModal.modal && btn == 'newjob' || storeModal.modal &&  btn == 'updateJob'" modalClass="w-[30%] my-8" innerModalClass="p-2">
        <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
            :disabled="storeUser.title.processing" @click="close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template>

        <form @submit.prevent="storeUser.createDesignation">
            <div class="my-2 mt-3.5">
                <div class="mb-2">
                    <label for="title">Title</label>
                    <span class="text-pink-600 mx-2 text-xs" v-if="storeUser.title.errors.title" v-text="storeUser.title.errors.title"></span>
                    <input type="text" id="title" v-model="storeUser.title.title" class="input-form my-1.5" placeholder="Enter">
                </div>

                <button type="submit" class="w-full h-9 bg-dnscGreen/80 my-2 text-white rounded hover:bg-dnscGreen shadow-inner_white">
                    <span v-if="btn === 'newjob'">Create</span>
                    <span v-if="btn === 'updateJob'">Update</span>
                </button>
            </div>
        </form>
    </Modal>

    
</template>

<script setup>
import { useModalStore } from '../../Stores/rigthView'
import { useUserStore } from '../../Stores/userStore'
import Modal from '../../Shared/Modal.vue'
import { ref } from '@vue/reactivity'
import Close from '../../Shared/closeComponent.vue'

const storeModal = useModalStore()
const storeUser = useUserStore()

const emits = defineEmits(['newDesignation', 'changeModal'])
const props = defineProps({
    btn: String, 
    nextModal: Boolean, 
    userDetails: Object,
    designationList: Array, 
    errors: Object,
    institutes: Array,
    programs: Array,
    designations: Array,
    editJob: Function,
    close: Function,
})

const programList = ref()

const newJob = () => {
    emits('newDesignation')
}
const modalChange = () => {
    emits('changeModal')
}
 
const progs = id =>{
    let programs = ref([])
    props.programs.forEach(element => {
        if(element.instituteID == id){
            programs.value.push(element)
        }
    });

    programList.value = programs.value

    if(id == ''){
        programList.value = null
    }
}

</script>
