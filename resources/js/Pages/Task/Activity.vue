<template>

    <div class="w-full h-8 flex items-center text-base">
        <div class="">Task name</div>
    </div>
    <hr>

    <div class="w-full grow overflow-y-auto">
        <div class="w-full h-fit text-xs pt-4 border-b border-slate-300" v-for="i in 4">
            <div class=" text-gray-400/80">September 1, 2022</div>
            <div class="my-3 w-full">
                <span>Lorem ipsum</span> <span class="text-gray-400/60">Uploaded a document lorem</span>
                <div class="mt-3 w-full py-2.5 px-2 bg-gray-200/40 rounded">Sample document</div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref, watch } from 'vue';

</script>
