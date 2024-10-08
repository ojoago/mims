<script setup>

    import MainLayout from '@/Layouts/MainLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectComponent from '@/Components/Select.vue';
    import store from '@/store';
    import { ref } from 'vue';


    const genders = [
        {"id":  "Female", "text": "Female"},
        {"id": "Male", "text": "Male"},
    ]
    const status = [
        {"id":  "Single", "text": "Single"},
        {"id": "Married", "text": "Married"},
    ]
    const religion = [
        {"id":  "Islam", "text": "Islam"},
        {"id": "Christainity", "text": "Christainity"},
        {"id": "Other", "text": "Other"},
    ]
    const staffForm = ref({
        firstname:'', 
        // 'staff_id' ,
        lastname:'' , 
        othername:'' , 
        marital_status:'' , 
        gender:'', 
        religion:'' , 
        pob:'' , 
        dob:'' , 
        state_of_origin:'' ,
        lga_of_origin:'' , 
        state_of_residence:'' , 
        lga_of_residence: '', 
        address:'',
        errors:{}
    })

    loadState()
     const states = ref({})
    function loadState() {
        store.dispatch('loadDropdown', 'states').then(({ data }) => {
            states.value = data;
        }).catch(e => {
            console.log(e);
        })
    }

    const origin_lgas = ref({})
    function originLga() {
        store.dispatch('loadDropdown', 'feeder-33/'+id).then(({ data }) => {
            origin_lgas.value = data;
        }).catch(e => {
            console.log(e);
        })
    }
</script>

<template>
    <MainLayout>
        <div class="px-4 py-2">
              <form @submit.prevent="submit" >
                             <div class="flex justify-around items-start md:items-center p-2">
                                <h2 class="text-2xl font-semibold">Generate RRR</h2>
                            </div> 

                            <div class="grid grid-cols-3 gap-4">

                                <div class="">
                                    <InputLabel for="first_name" value="First Name" />
                                        <TextInput
                                            id="first_name"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="staffForm.firstname"
                                            placeholder="First Name"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.firstname" />
                                </div>

                                 <div class="">
                                    <InputLabel for="last_name" value="Last Name" />
                                        <TextInput
                                            id="last_name"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="staffForm.lastname"
                                            placeholder="Last Name"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.lastname" />
                                </div>
                                 <div class="">
                                    <InputLabel for="last_name" value="Last Name" />
                                        <TextInput
                                            id="last_name"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="staffForm.lastname"
                                            placeholder="Last Name"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.lastname" />
                                </div>

                            </div>
                            <div class="grid grid-cols-3 gap-4 py-4 px-4 md:py-8 md:px-8 text-sm">
                                <div class="flex flex-col ">
                                    <InputLabel for="first_name" value="First Name" />
                                        <TextInput
                                            id="first_name"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="staffForm.firstname"
                                            placeholder="First Name"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.firstname" />
                                </div>
                                
                                <div class="flex flex-col ">
                                    <InputLabel for="last_name" value="Last Name" />
                                        <TextInput
                                            id="last_name"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="staffForm.lastname"
                                            placeholder="Last Name"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.lastname" />
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="nin" value="Othername" />
                                        <TextInput
                                            id="nin"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="staffForm.othername"
                                            placeholder="othername"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.othername" />
                                </div>

                            marital_status
gender
religion
pob
dob
state_of_origin
lga_of_origin
state_of_residence
lga_of_residence
address    

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Email address" />
                                        <TextInput
                                            id="email"
                                            type="email"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.email"
                                            placeholder="Email address"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.email" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="gsm" value="Phone Number" />
                                        <TextInput
                                            id="gsm"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="staffForm.gsm"
                                            placeholder="Phone Number"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.gsm" />       
                                </div>

                                <div class="flex flex-col ">
                                            <SelectComponent v-model="staffForm.gender" label="Select Gender" placeholder="Select Gender"
                                         :options="genders"/>
                                        <InputError class="mt-2" :message="staffForm.errors.gender" />   
                                </div>
                                <div class="flex flex-col ">
                                            <SelectComponent v-model="staffForm.marital_status" label="Select Gender" placeholder="Select Gender"
                                         :options="status"/>
                                        <InputError class="mt-2" :message="staffForm.errors.marital_status" />   
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="dob" value="Date of Birth" />
                                        <TextInput
                                            id="dob"
                                            type="date"
                                            class="mt-1 block w-full"
                                            v-model="staffForm.dob"
                                            placeholder="Date of Birth"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.dob" />       
                                </div>

                                <div class="flex flex-col ">
                                    <InputLabel for="dob" value="State of Origin" />  
                                     <select v-model="staffForm.state_of_origin" @change="loadOriginLga($event.target.value)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Choose State</option>
                                        <option v-for="option in states" :key="option.id" :value="option.id">
                                            {{ option.text }}
                                        </option>
                                    </select> 
                                    <InputError class="mt-2" :message="staffForm.errors.state_of_origin" />  
                                </div>

                                <div class="flex flex-col ">
                                    
                                    <SelectComponent v-model="staffForm.lga_of_origin" label="Select LGA of Origin" placeholder="Select Option"
                                         :options="origin_lgas"/>
                                            <InputError class="mt-2" :message="staffForm.errors.lga_of_origin" />   
                                </div>
                        

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4  px-4 md:px-8 text-sm">
                            <div class="flex flex-col ">
                                <InputLabel for="dob" value="State of Residence" />
                                <select v-model="staffForm.residence_state" @change="loadResidentLga($event.target.value)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" >
                                    <option value="">Choose State</option>
                                    <option v-for="option in states" :key="option.id" :value="option.id">
                                        {{ option.text }}
                                    </option>
                                </select> 
                                <InputError class="mt-2" :message="staffForm.errors.residence_state" />   
                            </div>

                            <div class="flex flex-col ">
                               
                                <SelectComponent v-model="staffForm.residence_lga" label="LGA of Origin" placeholder="Select LGA of Origin"
                                         :options="residenceLga"/>
                                        <InputError class="mt-2" :message="staffForm.errors.residence_lga" />   
                            </div>
                             <div class="flex flex-col ">
                                        <InputLabel for="dob" value="Passport" />
                                        <TextInput
                                            id="dob"
                                            type="file"
                                            class="mt-1 block w-full"
                                            @input="staffForm.passport = $event.target.files[0]"
                                            placeholder="Date of Birth"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.passport" />       
                                </div>
                                 <div class="flex flex-col ">
                                        <InputLabel for="dob" value="NIN Image" />
                                        <TextInput
                                            id="dob"
                                            type="file"
                                            class="mt-1 block w-full"
                                            @input="staffForm.nin_path = $event.target.files[0]"
                                            placeholder="Date of Birth"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.nin_path" />       
                                </div>
                        </div>

                        <div class="flex flex-col gap-4  px-4 md:px-8 text-sm">
                            <InputLabel for="email" value="Contact Address" />
                            
                            <textarea class="staffForm-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"  v-model="staffForm.address" placeholder="Address"></textarea>
                            <InputError class="mt-2" :message="staffForm.errors.address" />
                        </div>
                            

                            <div class="gap-4 py-4 px-4">
                                <button class="ms-4 flex justify-center rounded-md  px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm  focus-visible:outline focus-visible:outline-2 
                                            focus-visible:outline-offset-2  bg-indigo-600  hover:bg-indigo-500 focus-visible:outline-indigo-600" :class="{ 'opacity-25': staffForm.processing }" :disabled="staffForm.processing">
                                    Submit
                                </button>
                            </div>

                        </form>
        </div>
    </MainLayout>
</template>


<style  scoped>

</style>