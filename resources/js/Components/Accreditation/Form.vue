<template>
    <Modal v-if="storeModal.modal && storeAccredit.action === 'Create'" modalClass="w-[33%] my-8" innerModalClass="p-2">
        <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
            @click="storeAccredit.close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template>

        <form @submit.prevent="storeAccredit.submit">
            <div class="w-full my-2 mt-3.5" v-if="next">
                <div class="mb-3 relative">
                    <label for="program">Program</label>
                    <div class="relative bg-slate-100/60 my-1.5">
                        <select id="program" 
                        v-model="storeAccredit.form.program" 
                        @change="NextPage"
                        class="input-form z-10 relative cursor-pointer" 
                        style="background: transparent; padding-right: 2.35rem;">
                            <option value="" class="text-gray-400">Select program</option>
                            <option v-for="program in programs" :value="program.id" :key="program.id" v-text="program.description"></option>
                        </select>
                        <span class="material-symbols-rounded text-[24px] absolute z-0 top-1 right-2 select-none"> arrow_drop_down </span>
                    </div>
                </div>

                <div class="mb-2">
                    <label for="sought">Accreditation sought</label>
                    <input type="text" id="sought" v-model="storeAccredit.form.sought" class="input-form my-1.5" placeholder="Enter" @keyup="NextPage">
                </div>

                <div class="mb-2">
                    <label for="title">Title</label>
                    <input type="text" id="title" v-model="storeAccredit.form.title" class="input-form my-1.5" placeholder="Enter" @keyup="NextPage">
                </div>

                <div class="mb-2">
                    <label for="date">Date of Survey</label>
                    <input type="date" id="date" v-model="storeAccredit.form.date_survey" class="input-form my-1.5" placeholder="Enter" @keyup="NextPage">
                </div>

                <button type="button" 
                class="w-full h-9 bg-dnscGreen/80 my-2 text-white rounded hover:bg-dnscGreen shadow-inner_white
                disabled:bg-slate-200 disabled:text-slate-400 disabled:cursor-not-allowed"
                :disabled="disable"
                @click="next = false">Next</button>
            </div>

            <div class="w-full my-2 mt-0" v-else>
                <div class="w-full h-8 pb-0.5 border-b flex justify-between gap-2 items-center relative select-none mb-1.5">
                    <div class="flex items-center">
                        <button type="button" class="flex items-center mr-2 hover:text-dnscGreen" @click="next = true">
                            <span class="material-symbols-rounded"> chevron_left </span>
                            <span>Back</span>
                        </button>
                        <!-- <div class="w-fit flex gap-1 items-center pl-2 border-l">
                            <div class="flex items-center justify-center w-7 h-7 shrink-0 hover:bg-dnscGreen/20 text-dnscGreen rounded-full cursor-pointer">
                                <span class="material-symbols-rounded text-lg"> more_horiz </span>
                            </div>
                            <span class="material-symbols-rounded text-xs"> chevron_right </span>
                        </div>
                        <div class="ml-0.5 max-w-[16rem] Oneline">Area 1</div>-->
                    </div>

                    <div class="flex items-center gap-2 text-xs">
                        <label for="selectAll">Select all</label>
                            <input type="checkbox" 
                            id="selectAll" 
                            :disabled="storeAccredit.disableIfEmptyInst"
                            :checked="storeAccredit.select" 
                            @change="storeAccredit.getAll">
                        <div v-if="storeAccredit.form.instruments.length !== 0">({{ storeAccredit.form.instruments.length }})</div>
                    </div>
                </div>
                <div>
                    <span>Select Instrument</span>
                    <span class="text-pink-600 mx-2 text-xs" v-if="storeAccredit.form.errors.instruments" v-text="storeAccredit.form.errors.instruments"></span>
                </div>
                <div class="w-full px-0.5 max-h-[30rem] overflow-y-auto overscroll-contain">
                    <div class="w-full h-12 rounded  my-1.5 relative" v-for="i in storeAccredit.instruments" v-if="storeAccredit.instruments.length !== 0"
                    :class="[storeAccredit.isChecked(i.id) ? 'bg-dnscGreen/20': 'bg-slate-200/60']">
                        <label :for="i.id">
                            <div class="rounded w-full h-full flex items-center px-2">

                                <div>{{i.title + ' ' + i.set}}</div>
                                <span class="Oneline h-fit ml-2.5 max-w-[70%]">{{i.description}}</span>

                                <input type="checkbox" class="hidden"  
                                :id="i.id"
                                :value="i.id"
                                v-model="storeAccredit.form.instruments" 
                                @change="storeAccredit.unselectAll">
                            </div>
                        </label>

                        <!-- <div 
                        class="absolute w-12 text-center text-xs py-1 rounded bg-dnscGreen/20 
                        text-dnscGreen top-[0.73rem] right-2 cursor-pointer hover:bg-dnscGreen hover:text-white">Open</div> -->
                    </div>
                    <div class="w-full text-center my-4 text-slate-400" v-if="storeAccredit.instruments.length === 0">No Instruments Available</div>
                </div>

                <div class="w-full flex gap-2 mt-2.5">
                    <button type="submit" class="w-full h-9 bg-dnscGreen/80 rounded hover:bg-dnscGreen text-white">Create</button>
                </div>
            </div>
        </form>
    </Modal>
</template>

<script setup>
import { useModalStore } from '../../Stores/rigthView'
import { useAccreditationStore } from '../../Stores/requestStore'
import Modal from '../../Shared/Modal.vue'
import Close from '../../Shared/closeComponent.vue'
import { ref } from 'vue'

const props = defineProps({programs: Array})

const storeModal = useModalStore()
const storeAccredit = useAccreditationStore()

const next = ref(true)
const disable = ref(true)

const NextPage = () => {
    let sought = storeAccredit.form.sought.replace(/\s/g, '')
    let program = storeAccredit.form.program
    let title = storeAccredit.form.title.replace(/\s/g, '')
    if(program != '' && sought != '' && title != ''){
        disable.value = false
    }else{
        disable.value = true 
    }
}
NextPage()



</script>
