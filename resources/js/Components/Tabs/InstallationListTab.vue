<script setup>
    import store from '@/store';
    import { ref } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectComponent from '@/Components/Select.vue';
    import { formatError } from "@/composables/formatError";
    const { transformValidationErrors } = formatError()
    const showModal = ref(false)
    const closeModal = () => {
        showModal.value = false;
    }

    
    const showForm = (data) => {
        showModal.value = true;
    }



    const schedules = ref({})
    function loadItem(url = 'schedule-list'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            schedules.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }
    loadItem()

</script>


<template>
    <div>
        
        <Modal :show="showModal" @close="closeModal" max-width="6xl" title="Record Data" @submit="createItemName">
           <form action="" class="px-4 py-2">
            

           </form>
        </Modal>
        <!--<button @click="showModal = true " class="bg-optimal text-white p-1 mb-2 rounded">Add Team</button> -->

        <div class="overflow-auto rounded-lg shadow">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Region</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Account Number</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Account Name</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Address</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">33Kv feeder</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">11kv Feeder</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">DT Name</th>
                            <!--<th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Band</th> -->
                            <!--<th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Expected Load (In Amps)</th> -->
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Meter Type</th>
                            <!--<th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Connection Status</th> -->
                            <!-- <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">contact information</th> -->
                            <th width ="5%"  class="p-3 text-sm font-semibold tracking-wide text-left table-bordered"> 
                                <font-awesome-icon class="fa-solid fas fa-cog"/>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white" v-for="(item,loop) in schedules" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.region }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.account_number }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.account_name }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.address }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.feeder_33 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.feeder_11 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.dt_name }}</td>
                            <!--<td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.band }}</td>-->
                            <!--<td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.load }}</td>-->
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.meter_type }}</td>
                            <!--<td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.connection_status }}</td>-->
                            <!--<td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.contact }}</td>-->
                           <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button class="p-1 oy-1 text-sm bg-optimal text-white me-2 inline-block rounded" @click="showForm(item)">Record</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                
        </div>
    </div>
</template>


<style scoped>

</style>