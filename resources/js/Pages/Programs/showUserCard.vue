<template>
    <div class="w-full px-2 py-1 flex items-center justify-between group cursor-default" :class="[selected ? 'bg-dnscGreen/10 cursor-pointer' : 'hover:bg-slate-200/60']"
    @click="selected = true" v-click-outside="outside">
        <div class="flex gap-2 items-center">
            <div class="w-9 h-9 shrink-0 rounded-full overflow-hidden bg-slate-300"></div>
            <div class="Oneline h-fit">{{user.fname + ' ' + user.lname}}</div>
        </div>

        <button type="button" title="assign" v-show="selected" @click="storeProgram.assignAsMember(user.id)"
        class="w-8 h-8 rounded-full shrink-0 hover:bg-dnscGreen/10 hover:text-dnscGreen flex items-center justify-center">
            <span class="material-symbols-rounded text-[18px]"> add </span>
        </button>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useProgramStore } from '../../Stores/requestStore'

const storeProgram = useProgramStore()
const props = defineProps({user: Object})
const selected = ref(false)

const outside = () => {
    selected.value = false
}

</script>