<template>
    <Modal modalClass="w-[35%] my-8" innerModalClass="p-2">

        <div class="font-semibold mt-4">Assign user to "<i class="text-slate-400"> Sample </i>"</div>

        <div class="w-full mt-4">
            <div>Assigned</div>

            <div class="w-full overflow-hidden rounded-md mt-1">
                <div class="w-full max-h-[10rem] overflow-y-auto overscroll-contain px-1">
                    <div class="w-full px-2 py-1.5 flex items-center rounded-md justify-between hover:bg-slate-200/60">
                        <div class="w-full flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full shrink-0 bg-slate-300"></div>
                            <div class="Oneline h-fit"></div>
                        </div>

                        <button type="button" class="w-8 h-8 shrink-0 rounded-full hover:bg-dnscGreen/20 flex items-center justify-center">
                            <span class="material-symbols-rounded text-[18px]"> remove </span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <div class="w-full mt-4">
            <div class="mb-1">Members</div>

            <div class="w-full px-1">
                <div class="w-full px-2 py-1.5 flex items-center justify-between hover:bg-slate-200/60 rounded-md">
                    <div class="w-full flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full shrink-0 bg-slate-300"></div>
                        <div class="Oneline h-fit"></div>
                    </div>
    
                    <button type="button" class="w-8 h-8 shrink-0 rounded-full hover:bg-dnscGreen/20 flex items-center justify-center">
                        <span class="material-symbols-rounded text-[18px]"> add </span>
                    </button>
                </div>
            </div>
        </div>

    </Modal>
</template>

<script setup>
import Modal from '../../Shared/Modal.vue';

</script>

