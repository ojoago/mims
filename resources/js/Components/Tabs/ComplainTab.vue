
<script setup>
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import BaseSelect from '@/Components/BaseSelect.vue';
    const { transformValidationErrors } = formatError()
    
    import store from '@/store';
    import { ref } from 'vue';
    
    import { formatError } from "@/composables/formatError";
    const showModal = ref(false)
    const closeModal = () =>{
        showModal.value = false;
    }
    const status = [
        {id: 'PENDING', text: 'PENDING'},
        {id: 'RESOLVED', text: 'RESOLVED'},
        {id: 'UNRESOLVED', text: 'UNRESOLVED'},
        {id: 'REPLACED', text: 'REPLACED'},
    ]



    
    const schedules = ref({})
    function loadItem(url = 'installed-list'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            schedules.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }
    loadItem()

     const handleKeyup = (event) => {
        
        store.dispatch('getMethod', { url:'search-installed-list/'+event.target.value }).then((data) => {
        if (data?.status == 200) {
            schedules.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }


        const complainForm = ref({
            meter_number:'' ,
            meter_pid:'' ,
            complain:'' ,
            status:'' ,
            resolution:'' ,
            new_meter_number:'' ,
            new_seal:'' ,
            errors:[]
        })


     const attachCompalin = (data) =>{
        complainForm.value.meter_number = data.meter_number
        complainForm.value.meter_pid = data.pid
        showModal.value  = true
    }
     const addComplain = () =>{
       complainForm.value.errors = {}
        store.dispatch('postMethod', { url: '/add-customer-complain', param: complainForm.value }).then((data ) => {
        if (data?.status == 422) {
            complainForm.value.errors = transformValidationErrors(data.data)
        } else if (data?.status == 201) {
            closeModal()
        }
        }).catch(e => {
            console.log(e);
        })
    }

</script>

<template>

            
        <Modal :show="showModal" max-width="sm" @close="closeModal" title="Add Complains " @submit="addComplain">
           <form action="" class="px-4 py-2">
            
                <div>
                    <InputLabel for="complain" value="Customer Complain" />
                    <textarea class="w-full border-gray-300 focus:border-optimal focus:ring-optimal rounded-md shadow-sm"  v-model="complainForm.complain" placeholder="Enter Complain"></textarea>
                    <InputError class="mt-2" :message="complainForm.errors.complain" />
                </div>
                <div>
                    <InputLabel for="complain" value=" Resolution" />
                    <textarea class="w-full border-gray-300 focus:border-optimal focus:ring-optimal rounded-md shadow-sm"  v-model="complainForm.resolution" placeholder="Enter resolution"></textarea>
                    <InputError class="mt-2" :message="complainForm.errors.complain" />
                </div>
                   

                <div>
                    <BaseSelect v-model="complainForm.status" label="Status"  :selected="complainForm.status"
                                        :options="status" />
                    <InputError class="mt-2" :message="complainForm.errors.status" />
                </div>

                <div v-if="complainForm.status == 'replaced'">
                    
                     <div>
                         <InputLabel for="new_meter_number" value="New Meter Number" />
                        <TextInput
                            id="new_meter_number"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="complainForm.new_meter_number"
                            required
                            placeholder="Enter new Meter Number"
                            
                        />
                        <InputError class="mt-2" :message="complainForm.errors.new_meter_number" />
                    </div>

                     <div>
                         <InputLabel for="new_seal" value="New Seal" />
                        <TextInput
                            id="new_seal"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="complainForm.new_seal"
                            required
                            placeholder="Enter New Seal"
                            
                        />
                        <InputError class="mt-2" :message="complainForm.errors.new_seal" />
                    </div>
                    
                </div>

              
           </form>
        </Modal>
        
        <div class="overflow-auto rounded-lg shadow">
                <div>
                    <TextInput
                                            id="longitude"
                                            type="text"
                                            class="mt-1 block w-full"
                                           @keyup="handleKeyup" 
                                            placeholder="enter account number or name"
                                            
                                        />
                </div>
                <table class="min-w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Account Number</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Account Name</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Address</th>
                            <!--<th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">33Kv feeder</th> -->
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">11kv Feeder</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">DT Name</th>
                            <!--<th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Band</th> -->
                            <!--<th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Expected Load (In Amps)</th> -->
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Meter Type</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Meter Number</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Meter Seal</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Latitude</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Longitude</th>
                            <!--<th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Connection Status</th> -->
                            <!-- <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">contact information</th> -->
                            <th  class="p-3 text-sm font-semibold tracking-wide text-left table-bordered"> 
                               <!--<font-awesome-icon icon="fa-solid fas fa-cog"/> -->
                                Date
                            </th>
                            <th width ="3%"  class=" text-sm font-semibold tracking-wide text-left table-bordered"> 
                               <font-awesome-icon icon="fa-solid fas fa-cog"/>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white" v-for="(item,loop) in schedules" :key="loop">
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.account_no }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.fullname }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.address }}</td>
                            <!--<td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.feeder_33 }}</td> -->
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.feeder11kv?.name }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.dt_name }}</td>
                            <!--<td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.band }}</td>-->
                            <!--<td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.load }}</td>-->
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.meter_type }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.meter_number }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.seal }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.x_cordinate }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.y_cordinate }}</td>
                            <!--<td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.connection_status }}</td>-->
                            <!--<td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.contact }}</td>-->
                           <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered" >
                                {{ item.date }}
                            </td>
                           <td class="p-1 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button  class=" bg-optimal text-white px-4 py-1 rounded mr-2" @click="attachCompalin(item)">Mark</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                
        </div>

</template>

<style  scoped>

</style>