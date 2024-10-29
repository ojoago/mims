
<script setup>
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectComponent from '@/Components/Select.vue';

    import store from '@/store';
    import { ref } from 'vue';

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


    const complainForm = ref({
        meter_pid:'' ,
        complain:'' ,
        status:'' ,
        resolution:'' ,
        errors:[]
    })
</script>

<template>
    <div>

            
        <Modal :show="showModal" max-width="sm" @close="closeModal" title="Add Feeder " @submit="addFeeder33">
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
                    <SelectComponent v-model="complainForm.status" label="Status"  placeholder="Select Option"
                                        :options="status" />
                    <InputError class="mt-2" :message="complainForm.errors.status" />
                </div>

                <div v-if="complainForm.status == 'replaced'">
                    <div>
                        <SelectComponent v-model="complainForm.status" label="Status"  placeholder="Select Option"
                                            :options="status" />
                        <InputError class="mt-2" :message="complainForm.errors.status" />
                    </div>
                    
                     <div>
                         <InputLabel for="new_meter_number" value="New Meter Number" />
                        <TextInput
                            id="new_meter_number"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="complainForm.new_meter_number"
                            required
                            placeholder="e.g Bauch 33"
                            
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
        <button @click="showModal = true " class="bg-optimal text-white p-1 mb-2 rounded">Add Complain</button>
        

    </div>
</template>

<style  scoped>

</style>