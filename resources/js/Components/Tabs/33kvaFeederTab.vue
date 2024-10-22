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
        reset33Form()
        showModal.value = false;
    }

    const feederForm = ref({
        state:'',
        region:'',
        feeder:[{
            name:''
        }],
        errors:{}
    })

    const addFeeder = () => {
    feederForm.value.feeder.push({
        name:'' ,
    })
}
const removeFeeder = (i) => {
    let len = feederForm.value.feeder.length;
    if (len === 1) {
        store.commit('notify', { message: 'One Feeder is required to proceed', type: 'warninig' })
        return;
    }
    feederForm.value.feeder.splice(i, 1);
}

    const reset33Form = () =>{
        feederForm.value = {
            state:'',
            region:'',
            feeder:[{
                name:''
            }],
            errors:{}
        }
    }

    const addFeeder33 = () =>{
        feederForm.errors = {}
        store.dispatch('postMethod', { url: '/create-33kv-feeder', param: feederForm.value }).then((data ) => {
        if (data?.status == 422) {
            feederForm.value.errors = transformValidationErrors(data.data)
        } else if (data?.status == 201) {
            closeModal()
            loadRegin()
        }
        }).catch(e => {
            console.log(e);
        })
    }


    const states = ref({})
    function loadState() {
        store.dispatch('loadDropdown', 'zone-state').then(({ data }) => {
            states.value = data;
        }).catch(e => {
            console.log(e);
        })
    }

    loadState()
    const regions = ref({})
    function loadRegions(id) {
        store.dispatch('loadDropdown', 'zone/'+id).then(({ data }) => {
            regions.value = data;
        }).catch(e => {
            console.log(e);
        })
    }

    const feeder33s = ref({})
    function loadRegin(url = 'load-feeder-33'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            feeder33s.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }
    loadRegin()


    
</script>

<template>
    <div>
         
        <Modal :show="showModal" @close="closeModal" title="Add Feeder " @submit="addFeeder33">
           <form action="" class="px-4 py-2">
            
               <div class="grid grid-cols-2 gap-2">
                     <div>
                        <InputLabel for="state" value="State" />

                            <select @change="loadRegions($event.target.value)" v-model="feederForm.state" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="" selected>Select State</option>
                                <option v-for="(state,loop) in states" :key="loop" :value="state.id" >{{ state.text }}</option>
                            </select>
                        

                        <InputError class="mt-2" :message="feederForm.errors.state" />
                    </div>
                     <div>

                       <SelectComponent v-model="feederForm.region" label="Trading Zone"  placeholder="Select Option"
                                         :options="regions" />

                        <InputError class="mt-2" :message="feederForm.errors.feeder" />
                    </div>

               </div>
               
               <div class="" v-for="(feeder,loop) in feederForm.feeder" :key="loop">
                         
                     <div>
                        <div class="flex justify-between mt-1">
                            <InputLabel for="feeder" value="33 kv feeder Name" />
                            <button class=" bg-yellow-500 text-white  btn-sm  " type="button"  @click="removeFeeder(loop)">
                                    <font-awesome-icon icon="fa-solid fa-minus-circle" />
                                </button>
                        </div>

                        <TextInput
                            id="feeder33"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="feeder.name"
                            required
                            placeholder="e.g Bauch 33"
                            
                        />

                        <InputError class="mt-2" :message="feederForm.errors.feeder" />
                    </div>

               </div>
               <button class="bg-blue-500 text-white btn-sm mt-1" type="button" @click="addFeeder">
                        <font-awesome-icon icon="fa-solid fa-plus-circle" />
                    </button>
           </form>
        </Modal>
        <button @click="showModal = true " class="bg-optimal text-white p-1 mb-2 rounded">Add Feeder</button>
        
        <div class="overflow-auto rounded-lg shadow">
                    
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Region</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Feeder </th>
                            <th width ="10%"  class="p-3 text-sm font-semibold tracking-wide text-left"> 
                                <font-awesome-icon icon="fa-solid fa fa-cog"/>
                            </th>
                       

                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white" v-for="(feeder,loop) in feeder33s" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ feeder?.zone?.zone }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ feeder.name }}</td>
                           <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button class="p-1 oy-1 text-sm bg-yellow-500 text-white me-2 inline-block" @click="editRegion(feeder)">Preview</button>
                            </td>
                            
                            
                        </tr>
                    </tbody>
                </table>
                
        </div>
    </div>
</template>