<template>
  <div class="grid grid-cols-[repeat(auto-fill,minmax(13rem,17rem))] justify-around gap-2 my-2">
    <div class="rounded h-[4.5rem] p-1.5 bg-dnscGreen text-whiteBg">  
      <div class="w-full h-full flex gap-1.5 items-center">
        <div class="w-9 flex h-9 rounded-full justify-center items-center bg-whiteBg/30 shrink-0">
          <span class="material-symbols-rounded text-[20px]">account_circle</span>
        </div>
        <div class="text-base w-full">Users</div>
        <div class="text-xl">1400</div>
      </div>
    </div>

    <div class="rounded h-[4.5rem] p-1.5 bg-dnscGreen text-whiteBg">  
      <div class="w-full h-full flex gap-1.5 items-center">
        <div class="w-9 flex h-9 rounded-full justify-center items-center bg-whiteBg/30 shrink-0">
          <span class="material-symbols-rounded text-[20px]">account_balance</span>
        </div>
        <div class="text-base w-full">Institutes</div>
        <div class="text-xl">1400</div>
      </div>
    </div>

    <div class="rounded h-[4.5rem] p-1.5 bg-dnscGreen text-whiteBg">  
      <div class="w-full h-full flex gap-1.5 items-center">
        <div class="w-9 flex h-9 rounded-full justify-center items-center bg-whiteBg/30 shrink-0">
          <span class="material-symbols-rounded text-[20px]">domain</span>
        </div>
        <div class="text-base w-full">Programs</div>
        <div class="text-xl">1400</div>
      </div>
    </div>

    <div class="rounded h-[4.5rem] p-1.5 bg-dnscGreen text-whiteBg">  
      <div class="w-full h-full flex gap-1.5 items-center">
        <div class="w-9 flex h-9 rounded-full justify-center items-center bg-whiteBg/30 shrink-0">
          <span class="material-symbols-rounded text-[20px]">verified</span>
        </div>
        <div class="text-base w-full">Accredited</div>
        <div class="text-xl">1400</div>
      </div>
    </div>
  </div>

  <div class="w-full flex gap-2 h-[46%] py-2">
    <div class="ring-1 w-1/2 rounded"></div>
    <div class="ring-1 w-1/2 rounded"></div>
  </div>

  <div class="w-full flex gap-2 h-[46%] py-2">
    <div class="ring-1 w-1/2 rounded"></div>
    <div class="ring-1 w-1/2 rounded"></div>
  </div>
 <!--  <CalendarVue></CalendarVue> -->

</template>

<script>
import Layout from '../Shared/Layout';
export default { layout: Layout }
</script>
 
<script setup>
import CalendarVue from '../Shared/Calendar.vue'

</script>

<style>

</style>