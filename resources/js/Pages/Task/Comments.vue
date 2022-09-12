<template>
    <div class="ring-1 ring-inset grow">

        <div class="w-full flex gap-2 mt-2">
            <div class="self-start w-7 h-7 rounded-full ring-1 m-1 shrink-0"> </div>

            <div class="w-[12.5rem] mt-1 p-1.5 px-2 rounded-xl ring-1 relative">
                <div class="Oneline h-fit font-semibold" title="">Lorem ipsumcc  casdfasdf dfasdf</div>
                <p class="whitespace-pre-wrap break-words" 
                @mouseover="commentTime = true"
                @mouseleave="commentTime = false">Lorem ipsum dolor sit amet consectetur, adipisicinwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwg elit. Dolores quidem incidunt, veniam alias nesciunt impedit numquam maiores. Minima totam dignissimos voluptatem labore amet ea quas repudiandae magnam nobis qui. Dicta.</p>
                <span v-if="commentTime" class="absolute top-1/2 -right-[3.5rem] ring-1 text-xs rounded-sm px-[0.170rem] p-0.5">7:00 am</span>
            </div>
        </div>


    </div>

    <div class="my-2 w-full h-fit">
        <div class="flex gap-1">
            <div class="w-full rounded-md h-fit overflow-hidden ring-gray-200 ring-1" ref="conComment">
                <p class="w-full min-h-[2.25rem] max-h-[7rem] overflow-y-auto p-2 outline-none ring-inset whitespace-pre-wrap
                    rounded-md bg-gray-200/40 contentScroll editable"
                    contenteditable="true"
                    ref="message"
                    role="textbox"
                    placeholder="Comment"
                    @paste.prevent="plainText"
                    @focus="setStyleOnFocus"
                    @focusout="setStyleOnFocus"
                ></p>
            </div>

            <button 
            class="w-10 h-9 self-end hover:bg-dnscGreen bg-gray-200 shrink-0 hover:text-whiteBg text-dnscGreen flex items-center justify-center rounded-md">
                <span class="material-symbols-rounded text-[24px]"> send </span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';

const conComment = ref(null)
const commentTime = ref(false)

const plainText = (e) => {
    const text = e.clipboardData.getData('text/plain');
    document.execCommand("insertHTML", false, text);
}

const setStyleOnFocus = () => {
    if(conComment.value.classList.contains('ring-gray-200')){
        conComment.value.classList.remove('ring-gray-200')
        conComment.value.classList.add('ring-gray-400')
    }else{
        conComment.value.classList.add('ring-gray-200')
        conComment.value.classList.remove('ring-gray-400')
    }
}
</script>
