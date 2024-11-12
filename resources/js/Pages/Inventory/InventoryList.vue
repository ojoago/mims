<script setup>
import PaginationLinks from '@/Components/PaginationLinks.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Inertia } from '@inertiajs/inertia';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectComponent from '@/Components/Select.vue';
    import store from '@/store';
    import { ref } from 'vue';

    import DropMenu from '@/Components/DropMenu.vue';
     import { formatError } from "@/composables/formatError";
    const { transformValidationErrors } = formatError()
    const showModal = ref(false)
    const showDamageModal = ref(false)

    const closeModal = () =>{
        resetItemForm()
        showModal.value = false;
        showDamageModal.value =false
    }
    const moveDamage = (list) =>{
        
        damageItem.value.item_pid = list.item_pid
        damageItem.value.qnt = list.quantity
        showDamageModal.value = true
    }

    const items = ref({})
    const damageItem = ref({
        item_pid:'',
        cause:'',
        date:'',
        qnt:0,
        quantity:0,
        errors:[],
    })
    loadItem()
    function loadItem() {
        store.dispatch('loadDropdown', 'item-names').then(({ data }) => {
            items.value = data;
        }).catch(e => {
            console.log(e);
        })
    }

    

defineProps({
    lists:Array
})
 
 const changePage = (url) => {
    Inertia.get(url, {}, { preserveState: true, preserveScroll: true });
 
};

        const itemForm = ref({
                    items:[
                        {item_pid:'',
                        quantity:'',}
                    ],
                    errors:{}
            })
    

    
        const resetItemForm = () => {
             itemForm.value = {
                items:[
                    {
                        item_pid:'',
                        quantity:'',
                    }
                ],
                errors:{}
            }
        }
        const addItem = () => {
            itemForm.value.items.push({item_pid:'',
                 quantity:'',})
        }
        const removeItem = (i) => {
            let len = itemForm.value.items.length;
            if (len === 1) {
                store.commit('notify', { message: 'One Item is required to proceed', type: 'warning' })
                return;
            }
            itemForm.value.items.splice(i, 1);
        }


          
    const addItemQuantity = () =>{
        itemForm.errors = {}
        store.dispatch('postMethod', { url: '/add-inventory-item', param: itemForm.value }).then((data ) => {
        if (data?.status == 422) {
            itemForm.value.errors = transformValidationErrors(data.data)
        } else if (data?.status == 201) {
            closeModal()
        }
        }).catch(e => {
            console.log(e);
        })
    }

    const removeDamagedItem = () =>{
        damageItem.errors = {}
        store.dispatch('postMethod', { url: '/remove-damage-item', param: damageItem.value }).then((data ) => {
        if (data?.status == 422) {
            damageItem.value.errors = transformValidationErrors(data.data)
        } else if (data?.status == 201) {
            closeModal()
        }
        }).catch(e => {
            console.log(e);
        })
    }

    
</script>

<template>
    <MainLayout>
    <div class="p-3">
        <Modal :show="showModal" @close="closeModal" title="Add Item Quantity " @submit="addItemQuantity">
           <form action="" class="px-4 py-2">
            
               
               
               <div class="" v-for="(item,loop) in itemForm.items" :key="loop">
                       
                <div class="grid grid-cols-2 gap-2">
                    
                     <div>

                       <SelectComponent v-model="item.item_pid" label="Item name"  placeholder="Select item"
                                         :options="items" />

                        <InputError class="mt-2" :message="itemForm.errors.feeder" />
                    </div>
                    <div>
                        <InputLabel for="feeder" value="Item Quantity" />
                        <div class="flex justify-between mt-1">

                            <TextInput
                            id="feeder33"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="item.quantity"
                            required
                            placeholder="e.g 120"
                            
                        />
                            
                            <div class="item-center place-items-center pt-3">
                                <button class=" bg-yellow-500 text-white  btn-sm  " type="button"  @click="removeItem(loop)">
                                    <font-awesome-icon icon="fa-solid fa-minus-circle" />
                                </button>
                            </div>
                        </div>

                        

                        <InputError class="mt-2" :message="itemForm.errors.feeder" />
                    </div>

               </div>
                     

               </div>
               <button class="bg-blue-500 text-white btn-sm mt-1" type="button" @click="addItem">
                        <font-awesome-icon icon="fa-solid fa-plus-circle" />
                    </button>
           </form>
        </Modal>

        <Modal :show="showDamageModal" @close="closeModal" max-width="sm" title="Remove Damage Item " @submit="removeDamagedItem">
           <form action="" class="px-4 py-2">
            
               <div>
                    <InputLabel for="feeder" value="Item Quantity" />
                    <div class="flex justify-between mt-1">

                        <TextInput
                        id="feeder33"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="damageItem.quantity"
                        required
                        placeholder="e.g 120"
                        
                    />
                    </div>
                    <InputError class="mt-2" :message="damageItem.errors.quantity" />
                </div>
               <div>
                    <InputLabel for="feeder" value="Item Quantity" />
                    <div class="flex justify-between mt-1">

                        <TextInput
                        id="feeder33"
                        type="date"
                        class="mt-1 block w-full"
                        v-model="damageItem.date"
                        
                        
                    />
                    </div>
                    <InputError class="mt-2" :message="damageItem.errors.date" />
                </div>
               <div>
                    <InputLabel for="feeder" value="Cause of Damage" />
                    <div class="flex justify-between mt-1">

                        <textarea
                        id="feeder33"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="damageItem.cause"
                        required
                        placeholder="e.g tamper"
                        
                    ></textarea>
                    </div>
                    <InputError class="mt-2" :message="damageItem.errors.feeder" />
                </div>
              
           </form>
        </Modal>


        <button @click="showModal = true " class="bg-optimal text-white p-1 mb-2 rounded">Add Item</button>

    </div>
        
         <div class="overflow-auto rounded-lg shadow  ">
                <table class="w-full ">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                           <!--- <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Region </th> -->
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Item</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">description</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Quantity</th>
                            <th  class="p-3 text-sm font-semibold tracking-wide text-left table-bordered"> 
                                <font-awesome-icon icon="fa-solid fas fa-cog"/>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white" v-for="(list,loop) in lists?.data" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <!---<td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.region?.name }}</td> -->
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.item?.name }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.item?.description }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.quantity }} {{ list.item?.unit }}</td>
                      
                           <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered " >

                                <DropMenu >

                                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" @click="moveDamage(list)">Mark Damage</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Edit</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Deduction</a>
                                    </div>

                                </DropMenu>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <div >
                     <!-- Render the pagination links -->
                    <div class="mt-4">
                        <div class="flex space-x-1">
                            <pagination-links v-for="(link, i) of lists.links" :link="link" :key="i"
                                @next="changePage($event,link)"></pagination-links>
                        </div>
                    </div>
                </div>
                
        </div>
    </MainLayout>
</template>



<style scoped>

</style>