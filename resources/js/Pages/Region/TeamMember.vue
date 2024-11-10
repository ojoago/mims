<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import { ref } from 'vue';
import store from '@/store';
const members = ref({})
    function loadTeams(url = 'load-teams'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            members.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }
    loadTeams()

</script>

<template>
     <Head title="Team Member" />
    <MainLayout>
        <div class="container mx-auto">
            <div class="overflow-auto rounded-lg shadow">
                   <h3>Team Member</h3>
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
    </MainLayout>
</template>


<style scoped>

</style>