<script setup>

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

//        marital_status
// gender
// religion
// pob
// dob
// state_of_origin
// lga_of_origin
// state_of_residence
// lga_of_residence
// address    
</script>

<template>
    <div>
        <div class="px-4 py-2">
              <form @submit.prevent="submit" >
                    
                    <div class="py-4 px-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-2">
                            <div class="flex flex-col ">
                                    <InputLabel for="first_name" value="Date" />
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
                                    <InputLabel for="first_name" value="Date" />
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
                                    <InputLabel for="first_name" value="Date" />
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
                                    <InputLabel for="first_name" value="Date" />
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
                                    <InputLabel for="first_name" value="Date" />
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
                                    <InputLabel for="first_name" value="Date" />
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
                                    <InputLabel for="first_name" value="Date" />
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
                        </div>
                    </div>
                            <div class="grid gap-4 py-4 px-4  text-sm grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 ">
                                <div class="flex flex-col ">
                                    <InputLabel for="first_name" value="Date" />
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
                                    <InputLabel for="first_name" value="Meter Number" />
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
                                    <InputLabel for="last_name" value="Pre load unit" />
                                        <TextInput
                                            id="last_name"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="staffForm.lastname"
                                            placeholder="Last Name"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.lastname" />
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="nin" value="State" />
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


                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Trading Zone" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>
                                
                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="DT Number" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>
                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="DT Capacity" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="DT Type" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>
                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Upriser" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Present Tarrif" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                
                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Advised Tarrif" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>
                                
                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Customer  Title" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>
                                
                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="First Name" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>
                                
                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Last Name" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Phone Number" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Email" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Use of Premises" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Customer Address" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Customer Type " />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="11 kv Feeder" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="33 kv Feeder" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="New Meter Type" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Meter Brand" />
                                        <TextInput
                                            id="username"
                                            type="text"
                                            readonly
                                            class="mt-1 block w-full"
                                            v-model="staffForm.username"
                                            placeholder="e.g aminu.kudan"
                                            required
                                        />
                                        <InputError class="mt-2" :message="staffForm.errors.username" />       
                                </div>

                                <div class="flex flex-col ">
                                        <InputLabel for="email" value="Old Meter Number" />
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
                                        <InputLabel for="gsm" value="Old Meter Reading" />
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
                                        <InputLabel for="gsm" value="Old Meter Seal" />
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
                                        <InputLabel for="gsm" value="New Meter Seal" />
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
                                        <InputLabel for="gsm" value="Estimated Cumulative Load" />
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
                                        <InputLabel for="gsm" value="Service Center" />
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
                                        <InputLabel for="gsm" value="Pole Number" />
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
                                        <InputLabel for="gsm" value="Account Number" />
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
                                        <InputLabel for="gsm" value="Business Unit" />
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
                                        <InputLabel for="gsm" value="Customer Remarks" />
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
                                        <InputLabel for="gsm" value="Latitude" />
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
                                        <InputLabel for="gsm" value="Longitude" />
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
                                        <InputLabel for="gsm" value="Installer" />
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
                                        <InputLabel for="gsm" value="Supervisor" />
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
                                            <SelectComponent v-model="staffForm.marital_status" label="Select Marital Status" placeholder="Select Marital Status"
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

                                
                        

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4  px-4 md:px-8 text-sm">
                            <div class="flex flex-col ">
                                    <InputLabel for="dob" value="State of Origin" />  
                                     <select v-model="staffForm.state_of_origin" @change="loadOriginLga($event.target.value)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="" selected>Choose State</option>
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

                            <div class="flex flex-col ">
                                <InputLabel for="dob" value="State of Residence" />
                                <select v-model="staffForm.residence_state" @change="loadResidentLga($event.target.value)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" >
                                    <option value="" selected>Choose State</option>
                                    <option v-for="option in states" :key="option.id" :value="option.id">
                                        {{ option.text }}
                                    </option>
                                </select> 
                                <InputError class="mt-2" :message="staffForm.errors.residence_state" />   
                            </div>

                            <div class="flex flex-col ">
                               
                                <SelectComponent v-model="staffForm.residence_lga" label="Residence LGA" placeholder="Select Residence LGA"
                                         :options="residenceLga"/>
                                        <InputError class="mt-2" :message="staffForm.errors.residence_lga" />   
                            </div>
<!---
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
                            -->
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
    </div>
</template>


<style  scoped>

</style>