<template>
    <div class="w-full h-screen bg-dnscGreen/10 relative py-12">
        
        <img src="../../../img/dnsc_logo.png" alt="" class="drop-shadow-lg mx-auto w-32 h-32">

        <div class="mx-auto w-fit bg-whiteBg px-16 py-4 mt-3 rounded-lg shadow">
            
            <h2 class="text-2xl font-semibold text-center my-2 mb-3"> Welcome! </h2>
            
            <form @submit.prevent="submit" class="w-[18rem] h-fit">

                <div class="w-full h-fit p-2 py-1.5 bg-red-200 text-red-700 flex items-center gap-2 mb-2 rounded" v-if="error">
                    <div class="w-[90%] whitespace-pre-wrap break-words" v-text="error"></div>
                    <span class="material-symbols-rounded text-[20px] text-red-500 hover:text-red-700 cursor-pointer" @click="error = false"> close </span>
                </div>

                <div class="w-full mb-3">
                    <label for="email" class="text-base">Email 
                        <span class="text-pink-600 mx-2 text-xs" v-if="form.errors.email" v-text="form.errors.email"></span>
                    </label><br>
                    <input type="email" id="email" v-model="form.email"
                    class="w-full h-9 bg-whiteBg/50 mt-2 outline-none px-2 rounded ring-1 focus:ring-dnscGreen/70 ring-slate-300 placeholder:italic"
                    placeholder="example@gmail.com">
                </div>

                <div class="w-full mb-7">
                    <label for="pass" class="text-base">Password
                        <span class="text-pink-600 mx-2 text-xs" v-if="form.errors.password" v-text="form.errors.password"></span>
                    </label><br>
                    <input type="password" id="pass" v-model="form.password"
                    class="w-full h-9 bg-whiteBg/50 mt-2 outline-none px-2 rounded ring-1 focus:ring-dnscGreen/70 ring-slate-300 placeholder:italic"
                    placeholder="must be atleast 8 characters">
                </div>

                <button type="submit" class="w-full h-9 bg-dnscGreen text-whiteBg rounded hover:bg-dnscGreen/90">Log in</button>
            </form>
        </div>

    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props = defineProps({errors: Object})

const error = ref()
const form = useForm({
    email: null, password: null
})

const submit = () => {
    form.post('/login', {
        onError: ()=>{
            error.value = props.errors[0]
        }
    })
}
</script>
