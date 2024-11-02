<script setup>

    import store from '@/store';
    import { ref } from 'vue';
    import TextInput from '../TextInput.vue';
    import { formatError } from "@/composables/formatError";
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import SelectComponent from '@/Components/Select.vue';

    const { transformValidationErrors } = formatError()

    const showModal = ref(false)
    const closeModal = () =>{
        showModal.value = false;
    }
    const status = [
        {id: 'pending', text: 'pending'},
        {id: 'resolved', text: 'resolved'},
        {id: 'unresolved', text: 'unresolved'},
        {id: 'replaced', text: 'replaced'},
    ]


    const schedules = ref({})
    function loadItem(url = 'complain-list'){
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
            if(event.target.value.trim() == ''){
                return
            }
            store.dispatch('getMethod', { url:'search-complain-list/'+event.target.value }).then((data) => {
            if (data?.status == 200) {
                schedules.value = data.data;
            }else{
                
                schedules.value = []
            }
            }).catch(e => {
                console.log(e);
            })
    }


       const complainForm = ref({
            meter_number:'' ,
            meter_pid:'' ,
            // complain:'' ,
            status:'' ,
            resolution:'' ,
            new_meter_number:'' ,
            new_seal:'' ,
            errors:[]
        })


     const updateStatus = (data) =>{
        complainForm.value.meter_number = data.meter_number
        complainForm.value.meter_pid = data.pid
        showModal.value  = true
    }

</script>


<template>
    <div>
         
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
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Meter Number</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Complain </th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Resolution</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Status</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">New Meter Number</th>
                            <th width ="3%"  class=" text-sm font-semibold tracking-wide text-left table-bordered"> 
                               <font-awesome-icon icon="fa-solid fas fa-cog"/>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white" v-for="(item,loop) in schedules.data" :key="loop">
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.meter?.meter_number }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.complain }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.resolution }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.status }}</td>
                            <td class="p-2 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.new_meter_number }}</td>
                           <td class="p-1 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button  class=" bg-optimal text-white px-4 py-1 rounded mr-2" @click="updateStatus(item)">Update</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                
        </div>

             
        <Modal :show="showModal" max-width="sm" @close="closeModal" title="Add Complains " @submit="addComplain">
           <form action="" class="px-4 py-2">
            
            <!--
                <div>
                    <InputLabel for="complain" value="Customer Complain" />
                    <textarea class="w-full border-gray-300 focus:border-optimal focus:ring-optimal rounded-md shadow-sm"  v-model="complainForm.complain" placeholder="Enter Complain"></textarea>
                    <InputError class="mt-2" :message="complainForm.errors.complain" />
                </div> -->
                <div>
                    <InputLabel for="complain" value=" Resolution" />
                    <textarea class="w-full border-gray-300 focus:border-optimal focus:ring-optimal rounded-md shadow-sm"  v-model="complainForm.resolution" placeholder="Enter resolution"></textarea>
                    <InputError class="mt-2" :message="complainForm.errors.complain" />
                </div>
                   

                <div>
                    <SelectComponent v-model="complainForm.status" label="Status"  placeholder="Select Option"
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
        

    </div>
</template>


<style scoped>

</style>