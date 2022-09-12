<template>

    <div class="absolute top-8 -left-[9.7rem] w-48 rounded shadow-lg py-1.5 bg-whiteBg z-10 flex flex-col moreActions"><!-- changes in class -->

        <button class="flex items-center py-1.5 pl-2 gap-2 group hover:bg-dnscGreen/20 hover:text-dnscGreen disabled:text-gray-400/80 mb-1.5
        disabled-hover:bg-gray-200">
            <span class="material-symbols-rounded text-[18px]"> open_in_new </span>
            <span class="">Open</span>
        </button>
        <hr>
        <button class="flex items-center py-1.5 pl-2 gap-2 group hover:bg-dnscGreen/20 hover:text-dnscGreen mt-1.5"
        @click="getComments">
            <span class="material-symbols-rounded text-[18px]"> comment </span>
            <span class="">See Comments</span>
        </button>
        <button class="flex items-center py-1.5 pl-2 gap-2 group hover:bg-dnscGreen/20 hover:text-dnscGreen"
        @click="activity">
            <span class="material-symbols-rounded text-[18px]"> history_toggle_off </span>
            <span class="">See Activity</span>
        </button>
        <button class="flex items-center py-1.5 pl-2 gap-2 group hover:bg-dnscGreen/20 hover:text-dnscGreen mb-1.5"
        @click="drillDown">
            <span class="material-symbols-rounded text-[18px]"> filter_list </span>
            <span class="">Drill down</span>
        </button>
        <hr>
        <button class="flex items-center py-1.5 pl-2 gap-2 group hover:bg-dnscGreen/20 hover:text-dnscGreen my-1.5"
        @click="assignMember">
            <span class="material-symbols-rounded text-[18px]"> assignment_ind </span>
            <span class="">Assign Member</span>
        </button>
        <hr>
        <button class="flex items-center py-1.5 pl-2 gap-2 group hover:bg-dnscGreen/20 hover:text-dnscGreen mt-1.5">
            <span class="material-symbols-rounded text-[18px]"> drive_file_rename_outline </span>
            <span class="">Edit</span>
        </button>
        <button class="flex items-center py-1.5 pl-2 gap-2 group hover:bg-dnscGreen/20 hover:text-dnscGreen"
        @click="share">
            <span class="material-symbols-rounded text-[18px]"> share </span>
            <span class="">Share document</span>
        </button>
        <button class="flex items-center py-1.5 pl-2 gap-2 group hover:bg-dnscGreen/20 hover:text-dnscGreen">
            <span class="material-symbols-rounded text-[18px]"> manage_history </span>
            <span class="">Manage version</span>
        </button>
        <button class="flex items-center py-1.5 pl-2 gap-2 group hover:bg-dnscGreen/20 hover:text-dnscGreen">
            <span class="material-symbols-rounded text-[18px]"> download </span>
            <span class="">Download</span>
        </button>
        <button class="flex items-center py-1.5 pl-2 gap-2 group hover:bg-dnscGreen/20 hover:text-dnscGreen">
            <span class="material-symbols-rounded text-[18px]"> delete_forever </span>
            <span class="">Remove</span>
        </button>

    </div>
        
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useTaskStore } from '../../Stores/taskStore'
import { useRightViewStore } from '../../Stores/rigthView'
import { useModalStore } from '../../Stores/rigthView';

const storeModal = useModalStore()
const storeRightView = useRightViewStore()
const storeTask = useTaskStore()

const getComments = () => {
    storeRightView.showRightComponent('comments')
    storeTask.more = false
}

const share = () => {
  storeModal.setModalAction('Share Document')
  storeModal.toggleModal()
  storeTask.more = false
}

const activity = () => {
    storeRightView.showRightComponent('activity')
    storeTask.more = false
}

const drillDown = () =>{
  storeModal.setModalAction('Drill down')
  storeModal.toggleModal()
  storeTask.more = false
}

const assignMember = () =>{
  storeModal.setModalAction('Assign member')
  storeModal.toggleModal()
  storeTask.more = false
}
</script>