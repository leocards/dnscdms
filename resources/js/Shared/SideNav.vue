<template>

    <div class="h-full w-full flex flex-col">
        <!-- Profile -->
        <div class="w-full h-28 py-2 mb-1 max-md:pt-11">
            <div class="w-fit h-fit mx-auto">
                <div class="w-12 h-12 rounded-full overflow-hidden ring-1 max-md:w-9 max-md:h-9"></div>
            </div>
            <div class="w-full px-1.5 my-2 max-md:hidden relative" v-click-outside="closeUser">
                <div class="w-full justify-center flex gap-0.5 items-center" @click="user = !user">
                    <p class="h-fit w-full text-center" v-text="$page.props.user.user"></p>
                    <!-- <span class="material-symbols-rounded text-[16px] shrink-0"> expand_more </span> -->
                </div>

                <!-- <div class="absolute top-0 left-10 shadow-lg rounded w-full py-1.5 bg-whiteBg" v-if="user"> 
                    <Link href="/logout">
                        <div class="w-full p-1.5 hover:bg-slate-200/60">Log out</div>
                    </Link>
                    <div class="w-full p-1.5 hover:bg-slate-200/60">Edit Profile</div>
                </div> -->
            </div>

        </div>

        <div class="w-full flex flex-col gap-1">
            <div class="notifications hover:notifications-active group" 
            :class="[storeRightView.rightView == 'chat' || storeRightView.rightView == 'conversation' ? 'notifications-active':'']" 
            @click="storeRightView.showRightComponent('chat')" 
            @mouseover="hovers.chat=true" 
            @mouseleave="hovers.chat=false">
                <span class="material-symbols-rounded text-[24px]"> chat_bubble </span>
                <div class="max-md:group-hover:bg-[#C6DED3] p-2 rounded" :class="[hovers.chat ? '' : 'max-md:hidden']">Message</div>
            </div>
            <div class="notifications group hover:notifications-active" 
            :class="[ storeRightView.rightView == 'notification' ? 'notifications-active':'']" 
            @click="storeRightView.showRightComponent('notification')" 
            @mouseover="hovers.notification=true" 
            @mouseleave="hovers.notification=false">
                <span class="material-symbols-rounded text-[24px]"> notifications </span>
                <div class="max-md:group-hover:bg-[#C6DED3] p-2 rounded" :class="[hovers.notification ? '' : 'max-md:hidden']">Notification</div>
            </div>

            <hr>

            <Link href="/dashboard" class="tab group hover:tab-active " 
            :class="{'tab-active' : $page.url.startsWith('/dashboard')}"
            @mouseover="hovers.dashboard=true" 
            @mouseleave="hovers.dashboard=false">
                <span class="material-symbols-rounded">dashboard</span>
                <div class="max-md:group-hover:bg-dnscGreen p-2 rounded" :class="[hovers.dashboard?'':'max-md:hidden']">Dashboard</div>
            </Link>

            <Link href="/institute" class="tab hover:tab-active group" 
            :class="{'tab-active' : $page.url.startsWith('/institute')}"
            @mouseover="hovers.institute=true"
            @mouseleave="hovers.institute=false">
                <span class="material-symbols-rounded">account_balance</span>
                <div class="max-md:group-hover:bg-dnscGreen p-2 rounded" :class="[hovers.institute?'':'max-md:hidden']">Institute</div>
            </Link>

            <Link href="/program" class="tab hover:tab-active group" 
            :class="{'tab-active' : $page.url.startsWith('/program')}"
            @mouseover="hovers.program=true" 
            @mouseleave="hovers.program=false">
                <span class="material-symbols-rounded">domain</span>
                <div class="max-md:group-hover:bg-dnscGreen p-2 rounded" :class="[hovers.program?'':'max-md:hidden']">Program</div>
            </Link>

            <Link href="/accreditation/get/" class="tab hover:tab-active group" 
            :class="{'tab-active' : $page.url.startsWith('/accreditation')}"
            @mouseover="hovers.accreditation=true" 
            @mouseleave="hovers.accreditation=false">
                <span class="material-symbols-rounded">badge</span>
                <div class="max-md:group-hover:bg-dnscGreen p-2 rounded" :class="[hovers.accreditation?'':'max-md:hidden']">Accreditation</div>
            </Link>
            <Link href="/user" class="tab hover:tab-active group" 
            :class="{'tab-active' : $page.url.startsWith('/user')}"
            @mouseover="hovers.user=true" 
            @mouseleave="hovers.user=false">
                <span class="material-symbols-rounded">account_circle</span>
                <div class="max-md:group-hover:bg-dnscGreen p-2 rounded" :class="[hovers.user?'':'max-md:hidden']">User</div>
            </Link>

            <Link href="/task" class="tab hover:tab-active group" 
            :class="{'tab-active' : $page.url.startsWith('/task')}"
            @mouseover="hovers.task=true" 
            @mouseleave="hovers.task=false">
                <span class="material-symbols-rounded">task_alt</span>
                <div class="max-md:group-hover:bg-dnscGreen p-2 rounded" :class="[hovers.task?'':'max-md:hidden']">Task</div>
            </Link>

            <Link href="/shared" class="tab hover:tab-active group" 
            :class="{'tab-active' : $page.url.startsWith('/shared')}"
            @mouseover="hovers.shared=true" 
            @mouseleave="hovers.shared=false">
                <span class="material-symbols-rounded">folder_shared</span>
                <div class="max-md:group-hover:bg-dnscGreen p-2 rounded" :class="[hovers.shared?'':'max-md:hidden']">Shared</div>
            </Link>
        </div>

        <div class="rounded w-full mt-auto mb-6"> 
            <Link href="/logout" class="flex gap-2 items-center px-2 hover:text-dnscGreen/80 hover:bg-dnscGreen/20 hover:font-semibold rounded-r-full">
                <span class="material-symbols-rounded">manage_accounts</span>
                <div class="w-full p-1.5">Account</div>
            </Link>
            <Link href="/logout" class="flex gap-2 items-center px-2 hover:text-dnscGreen/80 hover:bg-dnscGreen/20 hover:font-semibold rounded-r-full">
                <span class="material-symbols-rounded">logout</span>
                <div class="w-full p-1.5">Log out</div>
            </Link>
        </div>
    </div>

</template>

<script setup>
import { ref } from 'vue';
import { useRightViewStore } from '../Stores/rigthView'

const storeRightView = useRightViewStore()

const props = defineProps({user: Object})

const hovers = ref({
    chat: false,
    notification: false,
    dashboard: false,
    institute: false,
    program: false,
    accreditation: false,
    user: false,
    task: false,
    shared: false,
})

const user = ref(false)

const closeUser = () => {
    user.value = false
}
</script>
