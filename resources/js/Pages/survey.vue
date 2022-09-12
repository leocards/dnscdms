<template>
    <!-- side nav -->
    <div class="w-72 h-screen fixed top-0 left-0 shadow-lg bg-dnscGreen/10 py-2 flex flex-col gap-2" @contextmenu.prevent>
        <div class="w-full h-16 rounded flex gap-1 px-2">
            <div class="h-full w-16 flex items-center justify-center shrink-0">
                <div class="w-14 h-14 overflow-hidden shrink-0 rounded-full ring-1"></div><!-- IMG LOGO-->
            </div>

            <div class="w-full grow pr-1.5 py-2.5 font-bold">
                <div class="text-base Oneline h-fit">BSIT</div>
                <div class="Oneline h-fit">Level 1 Phase 1</div>
            </div>
        </div>

        <div class="w-full grow overflow-y-auto border-t border-dnscGreen/40 pt-2 px-2">

            <ul class="w-full flex flex-col gap-2">
                <li class="w-full h-12 rounded ring-1 flex items-center px-2" v-for="i in 3">
                    <div class="w-full">
                        <div class="font-bold">Area 1</div>
                        <div class="text-xs" title="">Area Description</div>
                    </div>
                </li>
            </ul>

            <div>
                
            </div>
        </div>
    </div>

    <!-- body -->
    <div class="ml-72 w-full min-h-screen ring-1">
        
        <!-- top nav -->
        <div class="w-full h-10 ring-1 flex gap-2 px-2.5 items-center">
            <div class="w-full"></div>
            <div class="w-40 h-full flex items-center pr-10 gap-2 text-slate-500">
                <label for="rate">Rate:</label>
                <select id="rate" class="input-form">
                    <option value="">0</option>
                </select>
            </div>
        </div>



    </div>

</template>

<script setup>

</script>

<style>

</style>