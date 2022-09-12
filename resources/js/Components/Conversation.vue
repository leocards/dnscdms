<template>

    <div class="w-full h-12 relative flex items-center gap-0.5">
        <button class="w-8 h-8 flex items-center justify-center rounded-full group hover:bg-gray-200 shrink-0" @click="storeRightView.showRightComponent('chat')">
            <span class="material-symbols-rounded text-[24px] text-gray-300 group-hover:text-gray-600"> navigate_before </span>
        </button>

        <div class="w-full h-full px-1 flex gap-1.5 items-center">
            <div>
                <div class="w-10 h-10 rounded-full overflow-hidden ring-1 ring-inset">
                    <!-- img -->
                </div>
            </div>

            <div class="flex items-center">
                <div>
                    <div class="text-normal Oneline">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi doloremque vitae praesentium eveniet cum, facilis et repellendus quisquam. Ea rerum culpa iure. Ab numquam autem laudantium eveniet vel facere culpa?</div>
                    <div>Online</div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full grow ring-1 ring-gray-200 ring-inset flex flex-col-reverse my-1.5 overflow-y-auto">
        <div class="flex flex-col w-full h-fit p-1.5 gap-2">
            <!-- Send to -->
            <div class="h-fit flex gap-2">
                <div class="rounded-full w-7 h-7 self-end shrink-0 ring-1"></div><!-- Img -->
                <div class="w-fit h-fit self-end relative group">
                    <div class="text-xs absolute -right-12 top-2.5 group-hover:block hidden">7:00 am</div>
                    <div class="bg-gray-200 max-w-[11rem] p-1.5 px-3 rounded-2xl">welcome</div>
                </div>
            </div>

            <!-- Recieve -->
            <div class="h-fit flex flex-row-reverse gap-2">
                <div class="rounded-full w-7 h-7 self-end shrink-0 ring-1"></div><!-- Img -->
                <div class="w-fit h-fit self-end relative group">
                    <div class="text-xs absolute -left-12 top-2.5 group-hover:block hidden">7:00 am</div>
                    <div class="bg-gray-200 max-w-[11rem] p-1.5 px-3 rounded-2xl">welcome</div>
                </div>
            </div>

        </div>
    </div>

    <div class="w-full h-fit mb-4">
        <div class="flex gap-1">
            <p class="w-full min-h-[2.25rem] max-h-[7rem] overflow-y-auto p-2 outline-none ring-inset whitespace-pre-wrap
                rounded-md bg-gray-200/40 ring-gray-200 focus:ring-gray-400/30 ring-1 contentScroll editable" 
                contenteditable="true" 
                ref="message"
                role="textbox"
                placeholder="Aa"
                @paste.prevent="plainText"
            ></p>

            <button 
            class="w-10 h-9 self-end hover:bg-dnscGreen bg-gray-200 shrink-0 hover:text-whiteBg text-dnscGreen flex items-center justify-center rounded-md">
                <span class="material-symbols-rounded text-[24px]"> send </span>
            </button>
        </div>
    </div>

</template>

<script setup>
import { ref } from 'vue';
import { useRightViewStore } from '../Stores/rigthView'

const storeRightView = useRightViewStore()

const plainText = (e) => {
    const text = e.clipboardData.getData('text/plain');
    document.execCommand("insertHTML", false, text);
}

</script>




<style scoped>
.contentScroll::-webkit-scrollbar-thumb{border-radius: 30px;}
.contentScroll::-webkit-scrollbar{ width: 7px;}
.contentScroll::-webkit-scrollbar-button{ background: transparent; height: 3px;}
.contentScroll::-webkit-scrollbar-thumb{ background: #16764b; cursor: default;}
</style>