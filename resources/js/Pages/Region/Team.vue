<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';

 import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import Teams from '@/Components/Tabs/TeamsTab.vue';
import TeamMember from '@/Components/Tabs/TeamMemberTab.vue';

const tab = ref(1);
const currentTab = (tabNumber) => (tab.value = tabNumber);

</script>

<template>
     <Head title="Teams" />
    <MainLayout>
        <div class="container mx-auto">
            <fieldset class="m-4 pb-4 border bg-gray-100 rounded-lg">
                <nav class=" text-sm flex justify-center bg-gray-200">
                    <a @click="currentTab(1)" class="inline-block px-4 py-3 cursor-pointer" :class="tab  === 1 && `active`" >Team </a>
                    <a @click="currentTab(2)" class="inline-block px-4 py-3 cursor-pointer" :class="tab  === 2 && `active`">Team Member</a>
                </nav>

            
            <div class="p-3  bg-gra-200 ">

                <div v-if="tab === 1">
                    <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-lg font-medium text-left px-2">Team </legend>
                        <Teams/>
    
                    </fieldset>
                </div>

                <!-- step 2 education -->
                <div v-if="tab === 2">
                    
                    <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-lg font-medium text-left px-2">Team Member</legend>
                        <TeamMember/>
                    </fieldset>

                </div>
               
                
                </div>
           
            </fieldset>
            
        </div>
    </MainLayout>
</template>


<style scoped>

.active{
        @apply  border-optimal text-optimal font-bold border-b-2  bg-gray-100;    
    }
    .btn-sm{
        @apply   text-white font-bold py-1 px-2 rounded text-sm
    }

</style>