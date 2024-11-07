<script setup>
    import store from '@/store';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import { ref } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import BaseSelect from '@/Components/BaseSelect.vue';
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

    function addTeamMember() {
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
        // user_pid: '',
        members:[{
            user_pid: '',
        }],
        errors:{}
      }
    };

   const  editTeam = (team) => {
      teamMember.value = {
        team: team.team_pid ,
        members:[{
            user_pid: '',
        }],
        user_pid: team.user_pid,
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

    dropDownTeam()

    function dropDownTeam() {
        store.dispatch('loadDropdown', 'teams').then(({ data }) => {
            teams.value = data;
        }).catch(e => {
            console.log(e);
        })
    }
    dropDownUsers()

    const users = ref({})

    function dropDownUsers() {
        store.dispatch('loadDropdown', 'installers').then(({ data }) => {
            users.value = data;
        }).catch(e => {
            console.log(e);
        })
    }

</script>

<template>
    <div>
        
        <Modal :show="showModal" @close="closeModal" max-width="sm" title="Add Team Member " @submit="addTeamMember">
           <form action="" class="px-4 py-2">
           
                     

                     <div>
                        <BaseSelect v-model="teamMember.team" label="Teams"  :selected="teamMember.team"
                                         :options="teams" />

                        <InputError class="mt-2" :message="teamMember.errors.team" />
                    </div>

                     <div>
                        
                        <BaseSelect v-model="teamMember.user_pid" label="Team Member"  :selected="teamMember.user_pid"
                                         :options="users" />

                        <InputError class="mt-2" :message="teamMember.errors.user_pid" />
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
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Member</th>
                            <th width ="10%"  class="p-3 text-sm font-semibold tracking-wide text-left table-bordered"> 
                                <font-awesome-icon icon="fa-solid fa fa-cog"/>
                            </th>
                       

                        </tr>
                    </thead>
                    <tbody>
                      
                        <tr class="bg-white" v-for="(item,loop) in members" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.team?.team }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item?.user?.username }}</td>
                           <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button class="p-1 oy-1 text-sm bg-yellow-500 rounded-md text-white me-2 inline-block" @click="editTeam(item)">Edit</button>
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