<template>
    <div class="w-full h-fit sticky top-0 pt-2 flex items-center border-b border-slate-300 bg-[#F3F8F5] z-10" @contextmenu.prevent>
        <div class="w-full h-9 flex gap-2">

            <Link href="/task"
            class="w-fit flex items-center gap-1 px-2 py-1 border-b-2 hover:border-dnscGreen hover:text-dnscGreen cursor-pointer" 
            :class="[$page.url === '/task'? 'border-dnscGreen text-dnscGreen' : 'border-transparent']">
                <div>All</div>
            </Link>

            <Link href="/task/current" class="w-fit flex items-center gap-1 px-2 py-1 border-b-2 hover:border-dnscGreen hover:text-dnscGreen cursor-pointer" 
            :class="[$page.url.startsWith('/task/current')? 'border-dnscGreen text-dnscGreen' : 'border-transparent']">
                <div>Current </div>
                <span class="text-red-400 font-semibold">0</span>
            </Link>

            <Link href="/task/complete" class="w-fit flex items-center gap-1 px-2 py-1 border-b-2 hover:border-dnscGreen hover:text-dnscGreen cursor-pointer" 
            :class="[$page.url.startsWith('/task/complete')? 'border-dnscGreen text-dnscGreen' : 'border-transparent']">
                <div>Complete</div>
            </Link>

            <slot name="docs"/>

        </div>

        <slot></slot>
    </div>
    <slot name="extend" />
</template>

<script setup>
import { ref } from 'vue';

const btnActive = ref(false)
</script>