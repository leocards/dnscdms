<template>
    <div class="w-80 h-screen top-0 right-0 flex flex-col fixed shrink-0 border-l bg-whiteBg/90 px-1.5 overflow-y-auto overscroll-none 
    max-smd:fixed max-smd:right-0 max-smd:bg-whiteBg z-30">
        <div class="flex items-center justify-between top-0 sticky bg-whiteBg z-30 pt-1">
            <div class="text-lg capitalize">{{storeRightView.rightView}}</div>
            <Close closeClass="w-7 h-7 hover:text-dnscGreen rounded-full hover:bg-dnscGreen/20 flex items-center justify-center"
            iconClass="text-[18px]" @click="storeRightView.closeRightComponent"/>
        </div>

        <Chat v-if="storeRightView.rightView == 'chat'" />
        <conversation v-if="storeRightView.rightView == 'conversation'" />
        <Notification v-if="storeRightView.rightView == 'notification'" />
        <Comments v-if="storeRightView.rightView == 'comments'" />
        <Activity v-if="storeRightView.rightView == 'activity'" />
    </div>
</template>

<script setup>
import { useRightViewStore } from '../Stores/rigthView'
import Close from './closeComponent.vue'
import Chat from '../Components/Chat.vue'
import Notification from '../Components/Notification.vue'
import conversation from '../Components/Conversation.vue'
import Comments from '../Pages/Task/Comments.vue'
import Activity from '../Pages/Task/Activity.vue'

const storeRightView = useRightViewStore()
</script>

<style scoped>
::-webkit-scrollbar-track {background: transparent}
::-webkit-scrollbar{ width: 5px; }
::-webkit-scrollbar-button{ background: transparent; display: none;}
::-webkit-scrollbar-thumb{ background: #16764b; }
</style>