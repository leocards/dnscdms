<template>
    <div>{{storeRightView.rightView}}</div>
</template>

<script setup>
import { useRightViewStore } from '../Stores/rigthView'

const storeRightView = useRightViewStore()
</script>

<style>

</style>