<template>
    <div class="grid grid-cols-[repeat(auto-fill,minmax(13rem,1fr))] gap-2 mt-10">
        <div class="h-[11rem] ring-1 ring-slate-300 rounded-md flex flex-col overflow-hidden">
            <div class=" w-full grow bg-slate-200 rounded-t-md group relative overflow-hidden">
                <div>sdfasdf</div>
                <div class="w-full h-full bg-secondaryDarkBg/20 backdrop-blur-[1px] top-0 left-0 absolute hidden group-hover:flex items-center justify-center gap-2 cursor-pointer" >
                    <span class="material-symbols-rounded text-[18px]">open_in_new</span>
                    <div>Open</div>
                </div>
            </div>
            <div class="w-full h-14 flex items-center justify-between px-2 group">
                <div class="Oneline h-fit text-xs mr-0.5">Sample Docu m enddd ddddd dddddd ddd d ddd dddd d dddd ddd ddt</div>
                <button type="button" class="h-8 w-8 shrink-0 items-center justify-center rounded-full hover:bg-dnscGreen/10 group-hover:flex hidden hover:text-dnscGreen">
                    <span class="material-symbols-rounded text-[18px]">info</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>

</script>