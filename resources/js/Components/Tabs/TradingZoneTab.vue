<script setup>
    import store from '@/store';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import { ref } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectComponent from '@/Components/Select.vue';
    import { formatError } from "@/composables/formatError";
    const { transformValidationErrors } = formatError()

   

    const showModal = ref(false)
    const closeModal = () =>{
        resetitemForm()
        showModal.value = false;
    }
    


// status
    const zoneForm = ref({
        zone: '',
        state_id: '',
        errors:{}
    });

    function createTradingZone() {
        zoneForm.errors = {}
        store.dispatch('postMethod', { url: '/create-trading-zone', param: zoneForm.value }).then((data ) => {
        if (data?.status == 422) {
            zoneForm.value.errors = transformValidationErrors(data.data)
        } else if (data?.status == 201) {
            closeModal()
            loadItem()
        }
        }).catch(e => {
            console.log(e);
        })
    }

    const resetitemForm = () => {
      zoneForm.value = {
        state_id: '',
        zone: '',
        errors:{}
      }
    };

   const  editZone = (item) => {
      zoneForm.value = {
        zone: item.zone,
        state_id: item.state_id,
        id: item.id,
        errors:{}
      }
      showModal.value = true;
    };


    const zones = ref({})
    function loadItem(url = 'load-trading-zone'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            zones.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }
    loadItem()
    loadState()

    const states = ref({})

    function loadState() {
        store.dispatch('loadDropdown', 'states').then(({ data }) => {
            states.value = data;
        }).catch(e => {
            console.log(e);
        })
    }


</script>

<template>
    <div>
        
        <Modal :show="showModal" @close="closeModal" max-width="sm" title="Add Trading Zone" @submit="createTradingZone">
           <form action="" class="px-4 py-2">

                     <div>

                       <SelectComponent v-model="zoneForm.state_id" label="State"  placeholder="Select State"
                                         :options="states" />

                        <InputError class="mt-2" :message="zoneForm.errors.state_id" />
                    </div>

                     <div>
                        <InputLabel for="text" value="Zone Name" />

                        <TextInput
                            id="text"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="zoneForm.zone"
                            placeholder="e.g Bauchi"
                        />

                        <InputError class="mt-2" :message="zoneForm.errors.zone" />
                    </div>


           </form>
        </Modal>
        
        <button @click="showModal = true " class="bg-optimal text-white p-1 mb-2 rounded">Add Zone</button>

        <div class="overflow-auto rounded-lg shadow">
                    
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">State</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Trading Zone</th>
                            <th width ="10%"  class="p-3 text-sm font-semibold tracking-wide text-left  table-bordered"> 
                                <font-awesome-icon icon="fa-solid fa fa-cog"/>
                            </th>
                       

                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr class="bg-white" v-for="(zone,loop) in zones" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ zone?.state?.state }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ zone.zone }}</td>
                           <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button class="p-1 oy-1 text-sm bg-yellow-500 text-white me-2 inline-block" @click="editZone(zone)">Edit</button>
                            </td>
                            


                            
                        </tr>
                    </tbody>
                </table>
                
        </div>
    </div>
</template>



<style scoped>

/* border border-gray-300 px-4 py-2 */
</style>