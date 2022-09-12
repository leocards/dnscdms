<template>

    <teleport to="body">
        <div class="absolute bottom-10 left-8 shadow-xl rounded-md bg-whiteBg w-[23%] min-h-[3.5rem] z-[400]"><!-- $page.props.flash.message -->
            <div class="w-full min-h-[3.5rem] flex items-center rounded-md p-2 gap-3">
                <div class="flex w-7 h-7 items-center justify-center rounded-lg bg-dnscGreen/20 text-dnscGreen"
                v-if="$page.props.flash.success">
                    <span class="material-symbols-rounded text-lg"> done_outline </span>
                </div>
                <div class="flex w-7 h-7 items-center justify-center rounded-lg bg-pink-200/60 text-pink-700" v-if="$page.props.flash.error">
                    <span class="material-symbols-rounded text-lg"> dangerous </span>
                </div>
                <slot></slot>
            </div>
        </div>
    </teleport>

</template>

<script setup>
//
</script>

<style>

</style>