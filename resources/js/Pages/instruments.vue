<template>
    <HeadNav>
        <div class="flex gap-2 px-2 border-l border-slate-300 text-xs" >
            <button class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center group hover:bg-dnscGreen/20 hover:text-dnscGreen relative"
            @click="storeInstrument.create(parent)">
                <span class="material-symbols-rounded"> add </span>
                <div class="px-2.5 py-1.5 absolute -mb-[4rem] rounded group-hover:bg-dnscGreen/90 text-whiteBg group-hover:block hidden">Create</div>
            </button>

            <button class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center group hover:bg-dnscGreen/20 hover:text-dnscGreen relative"
            @click="storeInstrument.openCategory" v-if="links.length > 0">
                <span class="material-symbols-rounded text-[18px]"> category </span>
                <div class="px-2.5 py-1.5 absolute -mb-[4rem] rounded group-hover:bg-dnscGreen/90 text-whiteBg group-hover:block hidden">Category</div>
            </button>
        </div>

        <template #subNav>
            <div class="w-full sticky top-[2.45rem] z-[5] bg-[#F3F8F5] border-b border-slate-300 p-1 text-base" v-if="links != 0">
                <div class="w-full flex relative">
                    <div class="w-fit flex items-center" v-for="link in links" v-if="links.length <= 3">

                        <div class="flex items-center" v-if="link.id !== parent.id">
                            <Link :href="'/accreditation/instrument/'+link.id" class="w-full">
                                <div class="min-w-[0.1rem] max-w-[7.5rem] shrink-0 Oneline h-fit rounded-sm hover:bg-dnscGreen/20 hover:text-dnscGreen p-1">
                                    {{link.title}} <span v-if="link.set !== null">{{link.set}}</span>
                                </div>
                            </Link>
                            <span class="material-symbols-rounded text-xs"> chevron_right </span>
                        </div>

                        <div class="p-1 w-full Oneline" v-if="parent != null && link.id === parent.id">
                            <div>{{link.title}} <span v-if="link.set !== null">{{link.set}}</span></div>
                        </div>
                    </div>

                    <div class="flex items-center relative" v-else v-click-outside="setCloseCrumbs">
                        <div class="w-fit flex gap-1 items-center select-none" 
                        @click="setBreadcrumbs">
                            <div class="flex items-center justify-center w-[2rem] h-[2rem] shrink-0 
                            hover:bg-dnscGreen/20 text-dnscGreen rounded-full cursor-pointer" :class="{'bg-dnscGreen/20' : breadCrumbsMore}">
                                <span class="material-symbols-rounded"> more_horiz </span>
                            </div>
                            <span class="material-symbols-rounded text-xs"> chevron_right </span>
                        </div>

                        <div class="p-1 w-full Oneline" v-if="parent != null">
                            <div class="Oneline h-fit" v-text="parent.title+' '+ [parent.set === null ? '': parent.set]"></div>
                        </div>

                        <div ref="crumbs" class="w-44 h-fit shadow-md absolute top-8 py-1.5 rounded z-20 bg-whiteBg outline-none text-sm" 
                        v-if="breadCrumbsMore">
                            <div v-for="link in links" v-if="links.length > 3">
                                <div class="flex items-center" v-if="link.id !== parent.id">
                                    <Link :href="'/accreditation/instrument/'+link.id" class="w-full">
                                        <div class="w-full shrink-0 Oneline h-fit hover:bg-dnscGreen/20 hover:text-dnscGreen p-1 px-2">
                                            {{link.title}} <span v-if="link.set !== null">{{link.set}}</span>
                                        </div>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

    </HeadNav>
    
    <div class="w-full px-1 py-2" v-if="instruments == null">
        <div class="text-center text-slate-400/90">No Instruments Found</div>
    </div>

    <div class="grid grid-cols-[repeat(auto-fill,minmax(17rem,1fr))] gap-2 py-2" v-if="instruments.length != 0">
        <GridVue v-for="cards in instruments" :key="cards.id">

            <div class="w-full h-full flex items-center px-2 cursor-pointer" @click="routes(cards.id)">
                <div class="w-full flex flex-col">
                    <div class="">
                        {{cards.title}} {{cards.set}}
                    </div> 
                    <div class="w-full">
                        <div class="text-xs italic h-fit Oneline" 
                        :class="[cards.category === null && getInteger(cards.category) ||  cards.category !== null && getInteger(cards.category) ? 'max-w-[50%]': '']" 
                        :title="cards.description">{{cards.description}}</div>
                    </div>
                </div>
            </div>

            <div class="group-hover:flex hidden top-0.5 right-0.5 absolute">
                <button class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center hover:bg-dnscGreen/20 hover:text-dnscGreen relative" title="edit"
                @click="storeInstrument.edit(cards.id)" 
                v-if="cards.category === null && getInteger(cards.category) ||  cards.category !== null && getInteger(cards.category)">
                    <span class="material-symbols-rounded text-[18px]"> drive_file_rename_outline </span> 
                </button>

                <button class="w-8 h-8 rounded-full shrink-0 flex items-center justify-center hover:bg-dnscGreen/20 hover:text-dnscGreen relative" title="remove"
                @click="storeInstrument.setRemove(cards)">
                    <span class="material-symbols-rounded text-[18px]"> delete </span>
                </button>
            </div>
        </GridVue>
    </div>

    <div class="w-full text-center py-2 text-slate-400" v-else>No Instruments Available</div>

    <!-- Create Instrument -->
    <Modal v-if="storeInstrument.storeModal.modal && storeInstrument.action !== 'Remove' && storeInstrument.action !== 'Category'" 
    modalClass="w-[90%] sm:w-[33%] my-8" innerModalClass="p-2">
        <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
            :disabled="storeInstrument.form.processing" @click="storeInstrument.close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template>

        <form @submit.prevent="storeInstrument.submit">
            <div class="w-full my-2 mt-3.5">
                <p class="w-full py-2 mb-2 text-center bg-red-300 rounded mt-2 text-red-700" v-if="storeInstrument.form.errors[0]" 
                v-text="storeInstrument.form.errors[0]"></p>
                <div class="mb-2">
                    <label for="name">Name</label>
                    <span class="text-pink-600 mx-2 text-xs" v-if="storeInstrument.form.errors.name" v-text="storeInstrument.form.errors.name"></span>
                    <input type="text" id="name" :disabled="category" v-model="storeInstrument.form.name"
                    class="input-form my-1.5 disabled:ring-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed" placeholder="Enter">
                </div>

                <div class="mb-2">
                    <label for="set">Set</label>
                    <span class="text-pink-600 mx-2 text-xs" v-if="storeInstrument.form.errors.set" v-text="storeInstrument.form.errors.set"></span>
                    <input type="text" id="set" v-model="storeInstrument.form.set" class="input-form my-1.5" placeholder="Enter">
                </div>

                <div class="mb-2">
                    <label for="description">Description</label>
                    <input type="text" id="description" v-model="storeInstrument.form.description" class="input-form my-1.5" placeholder="Enter">
                </div>

                <button type="submit" class="w-full h-9 bg-dnscGreen/80 my-2 text-white rounded hover:bg-dnscGreen shadow-inner_white
                disabled:bg-slate-200 disabled:text-slate-500 disabled:cursor-wait"
                :disabled="storeInstrument.form.processing">{{storeInstrument.action}}</button>
            </div>
        </form>
    </Modal>

    <Modal v-if="storeInstrument.storeModal.modal && storeInstrument.action === 'Remove'" modalClass="w-[90%] sm:w-[33%] my-8" innerModalClass="p-2 ring-pink-700 ring-1 ring-inset">
        <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
            :disabled="storeInstrument.form.processing" @click="storeInstrument.close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template>

        <div class="w-full flex items-center flex-col py-2">
            <div class="">
                <span class="material-symbols-rounded text-[25px] text-pink-700"> dangerous </span>
            </div>

            <div class="my-8">Are you sure you want to remove {{storeInstrument.form.name +' '+storeInstrument.form.set}}?</div>
        </div>

        <div class="flex w-full gap-2 mb-2">
            <button type="button" class="w-full h-8 cursor-pointer rounded hover:bg-slate-300 bg-slate-400 disabled:cursor-wait text-whiteBg hover:text-slate-700"
            :disabled="storeInstrument.form.processing" @click="storeInstrument.close">Cancel</button>
            
            <button type="button" class="w-full h-8 cursor-pointer rounded ring-1 ring-inset ring-pink-700 text-pink-700 hover:text-whiteBg hover:bg-pink-700 disabled:cursor-wait"
            :disabled="storeInstrument.form.processing" @click="storeInstrument.remove(storeInstrument.form.id)">Remove</button>
        </div>
    </Modal>

<!-- category -->
    <Modal v-if="storeInstrument.storeModal.modal && storeInstrument.action === 'Category'" 
    modalClass="w-[90%] sm:w-[33%] my-8" innerModalClass="p-2">
        <template #close>
            <button class="w-7 h-7 rounded-full hover:bg-gray-200 flex justify-center items-center shrink-0 disabled:cursor-wait group"
            :disabled="storeInstrument.form.processing" @click="storeInstrument.close">
                <Close closeClass="w-fit h-fit" iconClass="text-[18px] group-disabled:cursor-wait"/>
            </button>
        </template>

        <div class="w-full py-3 flex flex-col gap-2">
            <button type="button" class="w-full rounded py-2 text-dnscGreen bg-dnscGreen/30 hover:bg-dnscGreen hover:text-whiteBg" 
            v-for="categ in storeInstrument.category" 
            @click="storeInstrument.createCategory(categ.id, parent.id)">
                {{categ.description}}
            </button>
        </div>
    </Modal>
</template>

<script>
import Layout from '../Shared/Layout'
export default { layout: Layout }
</script>

<script setup>
import { ref } from 'vue';
import Modal from '../Shared/Modal.vue' 
import Close from '../Shared/closeComponent.vue'
import HeadNav from '../Components/AccreditationHead.vue'
import GridVue from './Instruments/GridInstrument.vue'
import { useInstrumentStore } from '../Stores/requestStore';
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({instruments: Array, parent: Object, crumbs: Array})

const storeInstrument = useInstrumentStore()

const routes = (child) => {
    Inertia.get('/accreditation/instrument/'+child)
}

storeInstrument.getInstruments(props.instruments)
//storeInstrument.getParent(props.instruments)

const links = ref([])
const breadCrumbsMore = ref(false)
const category = ref()
const crumbs = ref(null)

const setBreadcrumbs = ()=>{
    breadCrumbsMore.value = !breadCrumbsMore.value
}
const setCloseCrumbs =()=>{
    breadCrumbsMore.value = false
}

function isCategory(){
    if(props.parent){
        props.parent.category !== null ? category.value = true : category.value =false
    }
}
isCategory()

if(props.parent !== null){
    props.crumbs.forEach(el => { links.value.push(el) });
}

const getInteger = id => {
    const arr = ['1', '2', '3']
    if(id !== null && arr.includes(id)){
        return false
    }else{
        return true
    }
}

</script>   