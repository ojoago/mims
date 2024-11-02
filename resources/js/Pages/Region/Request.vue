<script setup>
    import MainLayout from '@/Layouts/MainLayout.vue';
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
        resetForm()
        showModal.value = false;
    }
    


// status
    const requestForm = ref({
        date: '',
        receiver: '',
        note: '',
        team: '',
        items:[{
            item_pid:'',
            quantity:''
        }],
        errors:{}
    });

    function createItemName() {
        requestForm.errors = {}
        store.dispatch('postMethod', { url: '/request-item', param: requestForm.value }).then((data ) => {
        if (data?.status == 422) {
            requestForm.value.errors = transformValidationErrors(data.data)
        } else if (data?.status == 201) {
            closeModal()
            loadItem()
        }
        }).catch(e => {
            console.log(e);
        })
    }

    const resetForm = () => {
      requestForm.value = {
        state: '',
        region: '',
        errors:{}
      }
    };

   const  editRequest = (item) => {
      requestForm.value = {
        date: item.date ,
        receiver: item.receiver ,
        team: item.team_pid ,
        items:item.items,
        note:item.note,
        pid:item.pid,
        errors:{}
      }
      showModal.value = true;
    };


    const requests = ref({})
    function loadItem(url = 'load-request'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            requests.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }
    loadItem()

    
    const teams = ref({})
    function loadTeams() {
        store.dispatch('loadDropdown', 'teams/').then(({ data }) => {
            teams.value = data;
        }).catch(e => {
            console.log(e);
        })
    }

    loadTeams()
    const users = ref({})
    function loadUsers() {
        store.dispatch('loadDropdown', 'users/').then(({ data }) => {
            users.value = data;
        }).catch(e => {
            console.log(e);
        })
    }

    loadUsers()
    const items = ref({})
    function loadItems() {
        store.dispatch('loadDropdown', 'item-quantity').then(({ data }) => {
            items.value = data;
        }).catch(e => {
            console.log(e);
        })
    }

    loadItems()


    
    const addItem = () => {
        requestForm.value.items.push({
            item_pid:'' ,
            quantity:'' ,
        })
    }

    const removeItem = (i) => {
        let len = requestForm.value.items.length;
        if (len === 1) {
            store.commit('notify', { message: 'One Item is required to proceed', type: 'warning' })
            return;
        }
        requestForm.value.items.splice(i, 1);
    }


</script>

<template>
    <Head title="Item Request"/>
    <MainLayout>
        
         <Modal :show="showModal" @close="closeModal" title="Request Item" @submit="createItemName">
           <form action="" class="px-4 py-2">
           
                     <div>
                        <InputLabel for="email" value="Request Note" />

                        <textarea  v-model="requestForm.note" placeholder="Enter Note" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>

                        <InputError class="mt-2" :message="requestForm.errors.note" />
                    </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">

                    <div class="flex flex-col ">
                            <InputLabel for="gsm" value="Date" />
                            <TextInput
                                id="date"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="requestForm.date"
                                placeholder="Phone Number"
                                required
                            />
                            <InputError class="mt-2" :message="requestForm.errors.date" />       
                    </div>

                    <div class="flex flex-col ">
                                <SelectComponent v-model="requestForm.team" label="Team" placeholder="Select Team"
                                :options="teams"/>
                            <InputError class="mt-2" :message="requestForm.errors.team" />   
                    </div>
                    <div class="flex flex-col ">
                                <SelectComponent v-model="requestForm.receiver" label="Team" placeholder="Select Receiver"
                                :options="users"/>
                            <InputError class="mt-2" :message="requestForm.errors.receiver" />   
                    </div>
                </div>
                <hr class="mt-2">
                
               <div class="" v-for="(item,loop) in requestForm.items" :key="loop">
                         <div class="flex justify-end mt-1">
                            <button class=" bg-yellow-500 text-white  btn-sm  " type="button"  @click="removeItem(loop)">
                                    <font-awesome-icon icon="fa-solid fa-minus-circle" />
                                </button>
                        </div>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                        <div class="flex flex-col ">
                                    <SelectComponent v-model="item.item_pid" label="Items" placeholder="Select Item"
                                    :options="items"/>
                                <InputError class="mt-2" :message="requestForm.errors.team" />   
                        </div>
                        <div class="flex flex-col ">
                                <InputLabel for="quantity" value="Quantity" />
                                <TextInput
                                    id="date"
                                    type="number" step="0.5"
                                    class="mt-1 block w-full"
                                    v-model="item.quantity"
                                    placeholder="Enter Quantity"
                                    required
                                />
                                <InputError class="mt-2" :message="requestForm.errors.quantity" />       
                        </div>
                    </div>

               </div>
               <button class="bg-blue-500 text-white btn-sm mt-1" type="button" @click="addItem">
                        <font-awesome-icon icon="fa-solid fa-plus-circle" />
                    </button>
                

           </form>
        </Modal>
        <div>
            
        <button @click="showModal = true " class="bg-optimal text-white p-1 mb-2 rounded">Add Item</button>
        </div>

        <div class="overflow-auto rounded-lg shadow">
                    
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Date</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Items</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Team</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Status</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Receiver</th>
                            <th width ="10%"  class="p-3 text-sm font-semibold tracking-wide text-left table-bordered"> 
                                <font-awesome-icon icon="fa-solid fa fa-cog"/>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr class="bg-white" v-for="(item,loop) in requests" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.date_requested }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.items_count }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.team?.team }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.request_status }}</td>
                            <!--<td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.initiator }}</td> -->
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.collector?.username }}</td>
                            <!--<td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.description }}</td> -->
                           <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button class="p-1 oy-1 text-sm rounded-md bg-yellow-500 text-white me-2 inline-block" @click="editRequest(item)">Edit</button>
                            </td>
                            


                            
                        </tr>
                    </tbody>
                </table>
                
        </div>
    </MainLayout>
</template>


<style scoped>

</style>