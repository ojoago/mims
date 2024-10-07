<script setup>
    import store from '@/store';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import { reactive, ref } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectComponent from '@/Components/Select.vue';
    import { formatError } from "@/composables/formatError";
    const { transformValidationErrors } = formatError()

    const regions = ref({})
    function loadRegin(url){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            regions.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }
    loadRegin('load-all-regions')

    const showModal = ref(false)
    const closeModal = () =>{
        resetRegionForm()
        showModal.value = false;
    }
    
    
    const states = ref({})
    function loadState() {
        store.dispatch('loadDropdown', 'states').then(({ data }) => {
            states.value = data;
        }).catch(e => {
            console.log(e);
        })
    }

    loadState()

    const regionForm = ref({
        state: '',
        region: '',
        errors:{}
    });

    function createRegion() {
        regionForm.errors = {}
        store.dispatch('postMethod', { url: '/create-region', param: regionForm.value }).then((data ) => {
        if (data?.status == 422) {
            regionForm.value.errors = transformValidationErrors(data.data)
        } else if (data?.status == 201) {
            closeModal()
            loadRegin('load-regions')
        }
        }).catch(e => {
            console.log(e);
        })
    }

    const resetRegionForm = () => {
      regionForm.value = {
        state: '',
        region: '',
        errors:{}
      }
    };

   const  editRegion = (region) => {
      regionForm.value = {
        state: region.state,
        region: region.region,
        pid: region.pid,
        errors:{}
      }
      showModal.value = true;
    };


</script>

<template>
    <div>
        
        <Modal :show="showModal" @close="closeModal" title="Add Region " @submit="createRegion">
           <form action="" class="px-4 py-2">
            {{ regionForm }}
               <div class="grid grid-cols-2 gap-2">
                     <div>
                        
                        <SelectComponent v-model="regionForm.state" label="State" val = "text"  placeholder="Select State"
                                         :options="states" />

                        <InputError class="mt-2" :message="regionForm.errors.state" />
                    </div>
                     <div>
                        <InputLabel for="email" value="Email" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="regionForm.region"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="regionForm.errors.region" />
                    </div>

               </div>
           </form>
        </Modal>
        <button @click="showModal = true " class="bg-optimal text-white p-1 mb-2 rounded">Add Region</button>

         <div class="overflow-auto rounded-lg shadow">
                    
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Region</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">State</th>
                            <th width ="10%"  class="p-3 text-sm font-semibold tracking-wide text-left"> 
                                <font-awesome-icon class="fa-solid fa fa-cog"/>
                            </th>
                       

                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white" v-for="(region,loop) in regions" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ region.region }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ region.state }}</td>
                           <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button class="p-1 oy-1 text-sm bg-yellow-500 text-white me-2 inline-block" @click="editRegion(region)">Preview</button>
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