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
    const meterForm = ref({
        'meter_number' :'', 
        'preload':'', 
        'state':'' , 
        'doi':'', 
        'dt_name':'',
        'dt_type':'',
        'upriser':'' ,
        'pole':'' ,
        'tariff':'' ,
        'advtariff':'' ,
        'title' :'',
        'fullname':'' ,
        'gsm':'' ,
        'email' :'',
        'premises':'' ,
        'phase':'',
        'address':'',
        'remark':'',
        'feeder_33kv':'',
        'feeder_11kv':'',
        'meter_type':'',
        'meter_brand':'',
        'meter_tech' :'',
        'estimated' :'',
        'account_no':'' ,
        'business_unit':'',
        'x_cordinate':'',
        'y_cordinate':'' ,
        'installer':'' ,
        'supervisor':'' ,
        'rf_channel':'' ,
        'din':'' ,
        'seal':'' ,
        'dt_code':'',
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

                   



                            <div class="grid gap-4  text-sm grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 ">
                                <div class="flex flex-col ">
                                    <InputLabel for="first_name" value="Meter Number" />
                                        <TextInput
                                            id="meter_number"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.meter_number"
                                            placeholder="Meter Number"
                                            required
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.meter_number" />
                                </div>

                                <div class="grid grid-cols-1  md:grid-cols-2 gap-2">
                                     <div class="flex flex-col ">
                                        <InputLabel for="doi" value="Date" />
                                            <TextInput
                                                id="doi"
                                                type="date"
                                                class="mt-1 block w-full"
                                                v-model="meterForm.doi"
                                               
                                            />
                                            <InputError class="mt-2" :message="meterForm.errors.doi" />
                                    </div>
                                    <div class="flex flex-col ">
                                        <InputLabel for="preload" value="Pre load unit" />
                                            <TextInput
                                                id="preload"
                                                type="number"
                                                class="mt-1 block w-full"
                                                v-model="meterForm.preload"
                                                placeholder="e.g 15"
                                               
                                            />
                                            <InputError class="mt-2" :message="meterForm.errors.preload" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1  md:grid-cols-2 gap-2">
                                     <div class="flex flex-col ">
                                            <InputError class="mt-2" :message="meterForm.errors.state" />
                                             <SelectComponent v-model="meterForm.state" label="State" placeholder="Select Option"
                                                :options="states"/>
                                            <InputError class="mt-2" :message="meterForm.errors.state" /> 
                                    </div>
                                    <div class="flex flex-col ">
                                           
                                             <SelectComponent v-model="meterForm.zone" label="Trading Zone" placeholder="Select Option"
                                                :options="feeder11s"/>
                                                <InputError class="mt-2" :message="meterForm.errors.zone" />  
                                    </div>
                                </div>

                                <!-- next row  -->

                                <div class="grid grid-cols-1  md:grid-cols-2 gap-2">

                                        
                                    <div class="flex flex-col ">
                                        <InputLabel for="dt_code" value="DT Number" />
                                            <TextInput
                                                id="dt_code"
                                                type="number"
                                                class="mt-1 block w-full"
                                                v-model="meterForm.dt_code"
                                                placeholder="e.g 04"
                                            />
                                            <InputError class="mt-2" :message="meterForm.errors.dt_code" />
                                    </div>

                                    <div class="flex flex-col ">
                                            <InputLabel for="dt_capacity" value="DT Capacity" />
                                            <TextInput
                                                id="dt_capacity"
                                                type="number"
                                                class="mt-1 block w-full"
                                                v-model="meterForm.dt_capacity"
                                                placeholder="DT Capacity"
                                            />
                                            <InputError class="mt-2" :message="meterForm.errors.dt_capacity" />
                                    </div>
                                    
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

                                     <div class="flex flex-col ">
                                        <InputLabel for="upriser" value="Upriser" />
                                            <TextInput
                                                id="upriser"
                                                type="number"
                                                class="mt-1 block w-full"
                                                v-model="meterForm.upriser"
                                                placeholder="e.g 02"
                                                required
                                            />
                                            <InputError class="mt-2" :message="meterForm.errors.upriser" />
                                    </div>

                                    <div class="flex  flex-col">
                                        <InputLabel for="feeder_33kv" value="DT Type" />
                                            <div class="flex ">
                                                <div class="flex items-center ml-2">
                                                    <label for="radio1" class="mr-2 text-sm font-medium text-gray-900">Public</label>
                                                    <input id="radio1" type="radio" name="dt_type" v-model="meterForm.dt_type" value="Private" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                                </div>
                                                <div class="flex items-center ml-2">
                                                    <label for="radio2" class="mr-2 text-sm font-medium text-gray-900">Private</label>
                                                    <input id="radio2" type="radio" name="dt_type" v-model="meterForm.dt_type" value="Private" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                                </div>      
                                                
                                            </div>      
                                        </div>
                                </div>


                                <div class="grid grid-cols-1  md:grid-cols-2 gap-2">
                                        
                                    <div class="flex flex-col ">
                                        
                                            <SelectComponent v-model="meterForm.tariff" label="Present Tariff" placeholder="Select Option"
                                                :options="tariffs"/>
                                                <InputError class="mt-2" :message="meterForm.errors.tariff" />  
                                    </div>

                                    <div class="flex flex-col ">
                                             <SelectComponent v-model="meterForm.advtariff" label="Advised Tariff" placeholder="Select Option"
                                                :options="tariffs"/>
                                                <InputError class="mt-2" :message="meterForm.errors.advtariff" />  
                                    </div>
                                    
                                </div>

                        </div>

                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-4">
                             <div class="flex flex-col ">
                                        <InputLabel for="title" value="Title" />
                                        <TextInput
                                            id="title"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.title"
                                            placeholder="Title"
                                            
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.title" />       
                                </div>
                             <div class="flex flex-col ">
                                        <InputLabel for="firstname" value="First name" />
                                        <TextInput
                                            id="firstname"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.firstname"
                                            placeholder="First name"
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.firstname" />       
                                </div>
                             <div class="flex flex-col ">
                                        <InputLabel for="lastname" value="Last Name" />
                                        <TextInput
                                            id="lastname"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.lastname"
                                            placeholder="Last Name"
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.lastname" />       
                                </div>
                             <div class="flex flex-col ">
                                        <InputLabel for="gsm" value="Phone Number" />
                                        <TextInput
                                            id="gsm"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.gsm"
                                            placeholder="Phone Number"
                                            required
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.gsm" />       
                                </div>
                        </div>

                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-4">
                             <div class="flex flex-col ">
                                        <InputLabel for="title" value="Email" />
                                        <TextInput
                                            id="title"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.title"
                                            placeholder="Customer Email"
                                            
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.title" />       
                                </div>
                             <div class="flex flex-col ">
                                        <InputLabel for="feeder_33kv" value="33 kv Feeder" />
                                        <select v-model="meterForm.feeder_33kv" @change="load11kvFeeder($event.target.value)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="" selected>Choose 33 kv Feeder</option>
                                            <option v-for="option in feeder33s" :key="option.id" :value="option.id">
                                                {{ option.text }}
                                            </option>
                                        </select> 
                                      
                                        <InputError class="mt-2" :message="meterForm.errors.feeder_33kv" />       
                                </div>
                             <div class="flex flex-col ">
                                        <SelectComponent v-model="meterForm.feeder_11kv" label="11 kv Feeder" placeholder="Select Feeder"
                                         :options="feeder11s"/>
                                        <InputError class="mt-2" :message="meterForm.errors.feeder_11kv" />       
                                </div>
                             <div class="flex flex-col ">
                                       
                                        <SelectComponent v-model="meterForm.premises" label="Use of Premises" placeholder="Select Option"
                                         :options="premises"/>
                                        <InputError class="mt-2" :message="meterForm.errors.premises" />       
                                </div>
                        </div>


                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-4">
                            
                             
                             <div class="flex  flex-col">
                                <InputLabel for="feeder_33kv" value="Customer Phase" />
                                    <div class="flex ">
                                        <div class="flex items-center ml-2">
                                            <label for="radio1" class="mr-2 text-sm font-medium text-gray-900">Red</label>
                                            <input id="radio1" type="radio" name="phase" v-model="meterForm.phase" value="Red" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </div>
                                        <div class="flex items-center ml-2">
                                            <label for="radio2" class="mr-2 text-sm font-medium text-gray-900">Yellow</label>
                                            <input id="radio2" type="radio" name="phase" v-model="meterForm.phase" value="Yellow" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </div>      
                                        <div class="flex items-center ml-2">
                                            <label for="radio2" class="mr-2 text-sm font-medium text-gray-900">Blue</label>
                                            <input id="radio2" type="radio" name="phase" v-model="meterForm.phase" value="Blue" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </div>
                                    </div>      
                                </div>
                             <div class="flex flex-col ">
                                        <SelectComponent v-model="meterForm.meter_type" label="Meter Type" placeholder="Select Option"
                                         :options="meter_types"/>
                                        <InputError class="mt-2" :message="meterForm.errors.meter_type" />       
                                </div>
                             <div class="flex flex-col ">
                                       
                                        <SelectComponent v-model="meterForm.meter_brand" label="Meter Brand" placeholder="Select Option"
                                         :options="brands"/>
                                        <InputError class="mt-2" :message="meterForm.errors.meter_brand" />       
                                </div>

                                 <div class="flex flex-col ">
                                        <InputLabel for="seal" value="Seal Number" />
                                        <TextInput
                                            id="seal"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.seal"
                                            placeholder="New Seal Number"
                                            
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.title" />       
                                </div>

                                 <div class="flex flex-col ">
                                        <InputLabel for="pole" value="Pole Number" />
                                        <TextInput
                                            id="pole"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.pole"
                                            placeholder="e.g 11 "
                                            
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.pole" />       
                                </div>

                                 <div class="flex flex-col ">
                                        <InputLabel for="pole" value="Estimated Load" />
                                        <TextInput
                                            id="pole"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.estimated"
                                            placeholder="Customer Estimated Load"
                                            
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.estimated" />       
                                </div>

                                 <div class="flex flex-col ">
                                        <InputLabel for="pole" value="Service Center" />
                                        <TextInput
                                            id="pole"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.service_center"
                                            placeholder="Customer Estimated Load"
                                            
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.estimated" />       
                                </div>
                                 <div class="flex flex-col ">
                                        <InputLabel for="account" value="Account Number" />
                                        <TextInput
                                            id="account"
                                            type="number"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.account_no"
                                            placeholder="Customer Estimated Load"
                                            
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.account_no" />       
                                </div>

                                 <div class="flex flex-col ">
                                        <InputLabel for="unit" value="Business Unit" />
                                        <TextInput
                                            id="unit"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.business_unit"
                                            placeholder="Business Unit"
                                            
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.business_unit" />       
                                </div>

                                <div class="flex flex-col ">
                                        <SelectComponent v-model="meterForm.installer" label="Installer" placeholder="Select Installer"
                                         :options="installers"/>
                                        <InputError class="mt-2" :message="meterForm.errors.installer" />       
                                </div>

                                 <div class="flex flex-col ">
                                        <InputLabel for="latitude" value="Latitude" />
                                        <TextInput
                                            id="latitude"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.latitude"
                                            placeholder="0.1121223"
                                            
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.latitude" />       
                                </div>
                                 <div class="flex flex-col ">
                                        <InputLabel for="longitude" value="Longitude" />
                                        <TextInput
                                            id="longitude"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="meterForm.longitude"
                                            placeholder="0.01232333"
                                            
                                        />
                                        <InputError class="mt-2" :message="meterForm.errors.latitude" />       
                                </div>

                                

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <InputLabel for="email" value="Customer Address" />
                                <textarea class="staffForm-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"  v-model="meterForm.address" placeholder="Address"></textarea>
                                <InputError class="mt-2" :message="meterForm.errors.address" />
                            </div>
                            <div class="flex flex-col">
                                <InputLabel for="email" value="Customer Remark" />
                                <textarea class="staffForm-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"  v-model="meterForm.remark" placeholder="Address"></textarea>
                                <InputError class="mt-2" :message="meterForm.errors.remark" />
                            </div>

                        </div>
                            

                            <div class="gap-4 py-4 px-4">
                                <button class="ms-4 flex justify-center rounded-md  px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm  focus-visible:outline focus-visible:outline-2 
                                            focus-visible:outline-offset-2  bg-indigo-600  hover:bg-indigo-500 focus-visible:outline-indigo-600" :class="{ 'opacity-25': meterForm.processing }" :disabled="meterForm.processing">
                                    Submit
                                </button>
                            </div>
 </div>
                        </form>
        </div>
    </div>
</template>


<style  scoped>

</style>