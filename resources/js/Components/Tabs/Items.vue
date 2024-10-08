<script setup>
    import store from '@/store';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import { ref } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
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
    const itemForm = ref({
        name: '',
        description: '',
        unit: '',
        errors:{}
    });

    function createItemName() {
        itemForm.errors = {}
        store.dispatch('postMethod', { url: '/create-item-name', param: itemForm.value }).then((data ) => {
        if (data?.status == 422) {
            itemForm.value.errors = transformValidationErrors(data.data)
        } else if (data?.status == 201) {
            closeModal()
            loadItem()
        }
        }).catch(e => {
            console.log(e);
        })
    }

    const resetitemForm = () => {
      itemForm.value = {
        state: '',
        region: '',
        errors:{}
      }
    };

   const  editItem = (item) => {
      itemForm.value = {
        name: item.name,
        unit: item.unit,
        description: item.description,
        pid: item.pid,
        errors:{}
      }
      showModal.value = true;
    };


    const items = ref({})
    function loadItem(url = 'item-names'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            items.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }
    loadItem()

</script>

<template>
    <div>
        
        <Modal :show="showModal" @close="closeModal" max-width="sm" title="Add Item Name " @submit="createItemName">
           <form action="" class="px-4 py-2">
           
                     

                     <div>
                        <InputLabel for="text" value="Item Name" />

                        <TextInput
                            id="text"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="itemForm.name"
                            placeholder="e.g Meter box"
                        />

                        <InputError class="mt-2" :message="itemForm.errors.name" />
                    </div>

                     <div>
                        <InputLabel for="email" value="Unit " />

                        <TextInput
                            id="text"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="itemForm.unit"
                            placeholder="e.g packet"
                            required
                        />

                        <InputError class="mt-2" :message="itemForm.errors.unit" />
                    </div>
                     <div>
                        <InputLabel for="email" value="Item Description " />

                        <textarea  v-model="itemForm.description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>

                        <InputError class="mt-2" :message="itemForm.errors.description" />
                    </div>

           </form>
        </Modal>
        <button @click="showModal = true " class="bg-optimal text-white p-1 mb-2 rounded">Add Item</button>

        <div class="overflow-auto rounded-lg shadow">
                    
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Name</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Unit</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">description</th>
                            <th width ="10%"  class="p-3 text-sm font-semibold tracking-wide text-left"> 
                                <font-awesome-icon class="fa-solid fa fa-cog"/>
                            </th>
                       

                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr class="bg-white" v-for="(item,loop) in items" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.name }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.unit }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.description }}</td>
                           <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button class="p-1 oy-1 text-sm bg-yellow-500 text-white me-2 inline-block" @click="editItem(item)">Edit</button>
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