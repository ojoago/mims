<script setup>
    import store from '@/store';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import { ref } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import SelectComponent from '@/Components/Select.vue';
    import { formatError } from "@/composables/formatError";
    const { transformValidationErrors } = formatError()

    const showModal = ref(false)
    const closeModal = () =>{
        resetTeamMember()
        showModal.value = false;
    }
    


// status
    const teamMember = ref({
        team: '',
        user_pid: '',
        errors:{}
    });

    function createItemName() {
        teamMember.errors = {}
        store.dispatch('postMethod', { url: '/add-team-member', param: teamMember.value }).then((data ) => {
        if (data?.status == 422) {
            teamMember.value.errors = transformValidationErrors(data.data)
        } else if (data?.status == 201) {
            closeModal()
            loadTeams()
        }
        }).catch(e => {
            console.log(e);
        })
    }

    const resetTeamMember = () => {
      teamMember.value = {
        team: '',
        user_pid: '',
        errors:{}
      }
    };

   const  editTeam = (team) => {
      teamMember.value = {
        team: team.team?.team.pid,
        user_pid: team?.user?.user_pid,
        errors:{}
      }
      showModal.value = true;
    };


    const members = ref({})
    const teams = ref({})
    const supervisors = ref({})
    function loadTeams(url = 'load-team-member'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            members.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }
    loadTeams()

    loadTeam()

    function loadTeam() {
        store.dispatch('loadDropdown', 'teams').then(({ data }) => {
            teams.value = data;
        }).catch(e => {
            console.log(e);
        })
    }

</script>

<template>
    <div>
        
        <Modal :show="showModal" @close="closeModal" max-width="sm" title="Add Item Name " @submit="createItemName">
           <form action="" class="px-4 py-2">
           
                     

                     <div>
                        <SelectComponent v-model="teamMember.team" label="Teams"  placeholder="Select Team"
                                         :options="teams" />

                        <InputError class="mt-2" :message="teamMember.errors.team" />
                    </div>

                     <div>
                        
                        <SelectComponent v-model="teamMember.user_pid" label="Supervisors"  placeholder="Select Supervisor"
                                         :options="supervisors" />

                        <InputError class="mt-2" :message="teamMember.errors.supervisor" />
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
                                <font-awesome-icon class="fa-solid fa fa-cog"/>
                            </th>
                       

                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr class="bg-white" v-for="(item,loop) in members" :key="loop">
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