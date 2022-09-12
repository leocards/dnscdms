<template>

    <button class="min-w-[7rem] min-h-[2rem] rounded flex justify-center items-center gap-2 hover:text-dnscGreen
    hover:bg-dnscGreen/20 bg-slate-300" :class="btnClass">
        <slot>
            <span class="material-symbols-rounded text-[20px]"> add </span>
            <div class="">Create</div>
        </slot>
    </button>

</template>

<script setup>

defineProps({btnClass: String})

</script>

<style>

</style>