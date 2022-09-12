<template>
  <HeadNav>
    <div class="flex gap-2 px-2 border-l border-slate-300">

      <button class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center group hover:bg-dnscGreen/20 hover:text-dnscGreen relative" 
      @click="storeAccredit.create">
          <span class="material-symbols-rounded text-[]"> add </span>
          <div class="px-2.5 py-1.5 absolute text-xs -mb-[4rem] rounded group-hover:bg-dnscGreen/90 text-whiteBg group-hover:block hidden">Create</div>
      </button>

    </div>
  </HeadNav>

  <div class="grid grid-cols-[repeat(auto-fill,minmax(17rem,1fr))] gap-2 py-2" v-if="accreditations.length != 0">
    <GridAccreditationVue v-for="accred in accreditations">

      <Link :href="'/program/accred/'+accred.program_id+'/'+accred.id" class="w-full h-full">
        <div class="w-full h-full p-2 rounded flex flex-col justify-center">
          <div class="Oneline h-fit"><span v-if="accred.parent === null">{{accred.program}} - </span> <span>{{accred.title}} <span v-if="accred.set">{{accred.set}}</span></span></div>
          <div class="h-fit Oneline text-xs">{{accred.description}}</div>
        </div>
      </Link>

      <div class="group-hover:flex hidden top-0.5 right-0.5 absolute">
        <button class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center hover:bg-dnscGreen/20 hover:text-dnscGreen relative"
        @click="storeAccredit.edit(accred.id)">
            <span class="material-symbols-rounded text-[18px]"> drive_file_rename_outline </span> 
        </button>
      </div>

      <div class="absolute bottom-0 right-2 text-[11px]" v-if="accred.date_survey">
        <div>Date of survey: <span>{{accred.date_survey}}</span></div>
      </div>
    </GridAccreditationVue>
  </div>

  <div class="py-2 px-1" v-else>
    <div class="text-center text-slate-400/90">
      No Accreditation Available
    </div>
  </div>

  <FormVue :programs="programs"></FormVue>
  <EditForm :programs="programs"></EditForm>

  <modalLoader :wait="storeAccredit.wait"></modalLoader>

</template>

<script>
import Layout from '../Shared/Layout'
export default { layout: Layout }
</script>
 
<script setup>
import { useModalStore } from '../Stores/rigthView'
import { useAccreditationStore } from '../Stores/requestStore'
import HeadNav from '../Components/AccreditationHead.vue'
import FormVue from '../Components/Accreditation/Form.vue'
import EditForm from '../Components/Accreditation/EditForm.vue'
import GridAccreditationVue from '../Components/Accreditation/GridAccreditation.vue'
import modalLoader from '../Shared/modalLoader.vue'

const props = defineProps({programs: Array, accreditations: Array})

const storeModal = useModalStore()
const storeAccredit = useAccreditationStore()



</script>
