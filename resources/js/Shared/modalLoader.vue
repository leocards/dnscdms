<template>
    <Teleport to="body">
        <div class="fixed top-0 left-0 w-full h-screen bg-secondaryDarkBg/40 backdrop-blur-[1px] z-20" v-if="wait">
            <div class="w-[30%] min-h-[25%] bg-whiteBg rounded-md mx-auto my-10">
                <div class="w-full h-full p-2 flex flex-col animate-pulse">
                    <div class="w-full h-8 border-b border-slate-200 flex items-center justify-between pr-3">
                        <div class="w-[35%] h-2 bg-slate-200 rounded-full"></div>
                        <div class="w-4 h-4 rounded-full bg-slate-200"></div>
                    </div>
                    <div class="w-full mt-6">
                        <div class="w-[85%] h-2 bg-slate-200 rounded-full mb-3"></div>
                        <div class="w-[35%] h-2 bg-slate-200 rounded-full mb-3"></div>
                    </div>
                    <div class="w-full h-7 bg-slate-200 rounded-full mt-3"></div>
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { onMounted } from 'vue';

defineProps({wait: Boolean})

/* onMounted(()=>{
    console.log('mounted')
}) */

</script>
