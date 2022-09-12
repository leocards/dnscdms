<script setup>

    defineProps({closeClass: String, iconClass: String})

</script>

<template>
    <div class="max-w-full flex cursor-pointer" :class="closeClass">
        <span class="material-symbols-rounded" :class="iconClass">close</span>
    </div>
</template>