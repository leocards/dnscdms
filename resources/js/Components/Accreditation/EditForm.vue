<template>
    <Modal v-if="storeModal.modal && storeAccredit.action === 'Update'" modalClass="w-[33%] my-8" innerModalClass="p-2">
        <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
            @click="storeAccredit.close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template>

        <form @submit.prevent="storeAccredit.submit">
            <div class="w-full my-2 mt-3.5">
                <div class="mb-3 relative">
                    <label for="program">Program</label>
                    <div class="relative bg-slate-100/60 my-1.5">
                        <select id="program" 
                        v-model="storeAccredit.form.program" 
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
                    <input type="text" id="sought" v-model="storeAccredit.form.sought" class="input-form my-1.5" placeholder="Enter">
                </div>

                <div class="mb-2">
                    <label for="title">Title</label>
                    <input type="text" id="title" v-model="storeAccredit.form.title" class="input-form my-1.5" placeholder="Enter">
                </div>

                <div class="mb-2">
                    <label for="date">Date of Survey</label>
                    <input type="date" id="date" v-model="storeAccredit.form.date_survey" class="input-form my-1.5" placeholder="Enter">
                </div>

                <button type="submit" 
                class="w-full h-9 bg-dnscGreen/80 my-2 text-white rounded hover:bg-dnscGreen shadow-inner_white
                disabled:bg-slate-200 disabled:text-slate-400 disabled:cursor-not-allowed"
                @click="">Update</button>
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
</script>
