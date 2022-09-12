<template>
    <div class="w-40 h-screen shrink-0 top-0 fixed max-md:w-12 z-30">
        <Sidenav />
    </div>

    <div class="w-full min-h-[100vh] pl-2.5 max-md:ml-12 ml-40" :class="[storeRightView.rightView == null || storeRightView.rightView == '' ? 'mr-1.5': 'mr-80 pr-1.5']">
        <slot />
    </div>

    <RightView v-if="storeRightView.rightView" />

    <ToastVue v-if="$page.props.flash.success && storeNotif.showtToastNotification">
        <div>{{$page.props.flash.success}}</div>
    </ToastVue>

    <ToastVue v-if="$page.props.flash.error && storeNotif.showtToastNotification">
        <div >{{$page.props.flash.error}}</div>
    </ToastVue>
    
</template>

<script setup>
import { useRightViewStore } from '../Stores/rigthView'
import Sidenav from './SideNav.vue'
import RightView from '../Shared/RightComponent.vue'
import ToastVue from '../Components/Toast.vue';
import { useToastStore } from '../Stores/Notifications'

const storeNotif = useToastStore()
const storeRightView = useRightViewStore()
</script>

<style>

</style>