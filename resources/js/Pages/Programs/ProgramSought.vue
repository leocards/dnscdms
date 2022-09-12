<template>
    <div class="grid grid-cols-[repeat(auto-fill,minmax(17rem,1fr))] gap-2 mt-4" v-if="progInst.length !== 0">
        <div class="h-[4.6rem] rounded relative hover:bg-slate-200/60 group ring-1 ring-inset ring-gray-300" v-for="inst in progInst">
            <Link :href="'/program/accred/'+inst.progId+'/'+inst.id">
                <div class="w-full h-full p-2 rounded flex flex-col justify-center gap-0.5">
                    <div class="Oneline h-fit">
                        <span>
                            {{inst.title}} 
                            <span v-if="inst.set">{{inst.set}}</span>
                        </span> 
                        <span v-if="inst.parent === null && inst.status === null" class="text-orange-700/70 text-xs">Unaccredited</span>
                    </div>
                    <div class="h-fit Oneline text-xs max-w-[50%]" :title="inst.description">{{inst.description}}</div>
                </div>
            </Link>

            <button v-if="inst.parent !== null"
            type="button" 
            @click="storeProgram.setAssign(inst, program)" 
            class="absolute top-1 right-1 w-7 h-7 group-hover:flex hidden items-center justify-center group hover:bg-dnscGreen/20 rounded-full">
                <span class="material-symbols-rounded text-[18px] group-hover:text-green-700">assignment_ind</span>
            </button>

            <div class="absolute flex justify-end gap-[1px] bottom-1 right-1.5 max-w-14">
                <div v-for="user in assigned">
                    <button v-if="user.accredId == inst.id" type="button" class="w-6 h-6 shrink-0 rounded-full ring-1 overflow-hidden hover:ring-2" 
                    :title="user.fname+' '+user.lname"
                    @click="storeProgram.show_user(inst, user, program)"></button>  
                </div>
            </div>

        </div>
    </div>
    <div v-else class=" mt-4 text-slate-400 text-center">No Accredit Found</div>
</template>

<script setup>
import { useProgramStore } from '../../Stores/requestStore'
defineProps({progInst: Array, assigned: Array, program: Object})
/* openFacultyStaff(inst.id, true), storeProgram.forms.parent = user.user */
const storeProgram = useProgramStore()


</script>