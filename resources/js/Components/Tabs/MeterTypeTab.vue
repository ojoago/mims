<script setup>
    import store from '@/store';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import { ref } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { formatError } from "@/composables/formatError";
    const { transformValidationErrors } = formatError()

   

    const showModal = ref(false)
    const closeModal = () =>{
        resetteamForm()
        showModal.value = false;
    }
    


// status
    const teamForm = ref({
        type: '',
        errors:{}
    });

    function createItemName() {
        teamForm.errors = {}
        store.dispatch('postMethod', { url: '/create-meter-type', param: teamForm.value }).then((data ) => {
        if (data?.status == 422) {
            teamForm.value.errors = transformValidationErrors(data.data)
        } else if (data?.status == 201) {
            closeModal()
            loadTeams()
        }
        }).catch(e => {
            console.log(e);
        })
    }

    const resetteamForm = () => {
      teamForm.value = {
        type: '',
        errors:{}
      }
    };

   const  editTeam = (team) => {
      teamForm.value = {
        type: team.type ,
        id: team.id ,
        errors:{}
      }
      showModal.value = true;
    };


    const types = ref({})
    function loadTeams(url = 'load-meter-types'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            types.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }
    loadTeams()

</script>

<template>
    <div>
        
        <Modal :show="showModal" @close="closeModal" max-width="sm" title="Add Item Name " @submit="createItemName">
           <form action="" class="px-4 py-2">
           
                     <div>
                        <InputLabel for="text" value="Team Name" />

                        <TextInput
                            id="text"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="teamForm.type"
                            placeholder="e.g 1 Q"
                            autocomplete="off"
                        />

                        <InputError class="mt-2" :message="teamForm.errors.type" />
                    </div>

                    
                    

           </form>
        </Modal>
        <button @click="showModal = true " class="bg-optimal text-white p-1 mb-2 rounded">Add Type</button>

        <div class="overflow-auto rounded-lg shadow">
                    
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Meter Type</th>
                            <th width ="10%"  class="p-3 text-sm font-semibold tracking-wide text-left table-bordered"> 
                                <font-awesome-icon icon="fa-solid fa fa-cog"/>
                            </th>
                       

                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr class="bg-white" v-for="(type,loop) in types" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ type.type }}</td>
                           <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button class="p-1 oy-1 text-sm bg-yellow-500 rounded-md text-white me-2 inline-block" @click="editTeam(type)">Edit</button>
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