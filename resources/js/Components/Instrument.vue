<template>
  <div class="w-full py-1.5 mb-2 flex  gap-4">

    <CreateBtn btnClass="px-2.5">
      <span class="material-symbols-rounded text-[24px]"> create_new_folder </span>
      <div>Add Area</div>
    </CreateBtn>

    <CreateBtn @click="open" btnClass="px-2.5">
      <span class="material-symbols-rounded text-[24px]"> create_new_folder </span>
      <div>Create Instrument</div>
    </CreateBtn>

  </div>


  <div class="w-full">
    <Accordion v-if="instruments != 0" v-for="instrument in getParents()" :node="instrument" :getChilds="getChilds">
      <div class="w-fit px-2 items-center gap-2 shrink-0 group-hover:flex hidden">
        <!-- edit -->
        <div class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center hover:bg-dnscGreen/20" title="Edit">
          <span class="material-symbols-rounded text-[20px]"> drive_file_rename_outline </span>
        </div>
        <!-- create -->
        <div class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center hover:bg-dnscGreen/20" title="Create">
          <span class="material-symbols-rounded text-[20px]"> create_new_folder </span>
        </div>
      </div>
    </Accordion>
    <div class="w-full text-center" v-else>No Instruments Available</div>
  </div>

</template>

<script setup>
import { reactive, ref } from 'vue';
import { useModalStore } from '../Stores/rigthView'
import CreateBtn from '../Shared/CreateBtn.vue'
import Modal from '../Shared/Modal.vue'
import Accordion from '../Shared/Accordion.vue'
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({removedItems: Boolean, instruments: Array})

const storeModal = useModalStore()

const instruments = ref(props.instruments)
const form = reactive({
  name: null,
  set: null,
  description: null
})

//getting all the parent with null value in instruments
const getParents = () => {
    const parents = ref([])
    instruments.value.forEach(element => { element.parent == null ? parents.value.push(element) : '' });
    return parents.value
}

const getChilds = id => {
    const array = ref([])
    instruments.value.forEach(element => { if(element.parent == id) { array.value.push(element) } });
    return array.value != 0 ? array.value : 0 
}
// opens a modal
const open = () => {
  storeModal.setModalAction('Create Insrument')
  storeModal.toggleModal()
}

const submit = ()=> {
  Inertia.post('/instrument/create', form);
}

</script>

<style>

</style>