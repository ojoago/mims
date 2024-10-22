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
        resetteamForm()
        showModal.value = false;
    }
    


// status
    const teamForm = ref({
        team: '',
        supervisor: '',
        errors:{}
    });

    function createTeam() {
        teamForm.errors = {}
        store.dispatch('postMethod', { url: '/create-team', param: teamForm.value }).then((data ) => {
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
        team: '',
        supervisor: '',
        errors:{}
      }
    };

   const  editTeam = (team) => {
      teamForm.value = {
        team: team.team,
        supervisor: team?.supervisor?.pid,
        pid: team.pid,
        errors:{}
      }
      showModal.value = true;
    };


    // supervisors

    const teams = ref({})
    function loadTeams(url = 'load-teams'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            teams.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }
    loadTeams()

    supervisor()
    const supervisors = ref({})

     function supervisor() {
        store.dispatch('loadDropdown', 'supervisors').then(({ data }) => {
            supervisors.value = data;
        }).catch(e => {
            console.log(e);
        })
    }

</script>

<template>
    <div>
        
        <Modal :show="showModal" @close="closeModal" max-width="sm" title="Add Team " @submit="createTeam">
           <form action="" class="px-4 py-2">
           
                     

                     <div>
                        <InputLabel for="text" value="Team Name" />

                        <TextInput
                            id="text"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="teamForm.team"
                            placeholder="e.g Team Abdulkareem"
                            autocomplete="off"
                        />

                        <InputError class="mt-2" :message="teamForm.errors.team" />
                    </div>

                     <div>
                       
                        <SelectComponent v-model="teamForm.supervisor" label="Supervisor"  placeholder="Select supervisor"
                                         :options="supervisors" />

                        <InputError class="mt-2" :message="teamForm.errors.supervisor" />
                    </div>
                    

           </form>
        </Modal>
        <button @click="showModal = true " class="bg-optimal text-white p-1 mb-2 rounded">Add Team</button>

        <div class="overflow-auto rounded-lg shadow">
                    
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Team</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Supervisor</th>
                            <th width ="10%"  class="p-3 text-sm font-semibold tracking-wide text-left table-bordered"> 
                                <font-awesome-icon icon="fa-solid fa fa-cog"/>
                            </th>
                       

                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr class="bg-white" v-for="(item,loop) in teams" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.team }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.supervisor?.email }}</td>
                           <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button class="p-1 oy-1 text-sm bg-yellow-500 text-white me-2 inline-block" @click="editTeam(item)">Edit</button>
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