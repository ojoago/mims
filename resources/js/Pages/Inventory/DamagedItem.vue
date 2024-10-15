<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import PaginationLink from '@/Components/PaginationLink.vue';
import DamagedItemDetail from '@/Components/Tabs/DamagedItemDetailTab.vue';



    defineProps({
        lists:Array
    })

    const tab = ref(1);
    const currentTab = (tabNumber) => (tab.value = tabNumber);

</script>

<template>
    
     <Head title="Damaged Items" />
    <MainLayout>
        <div class="container mx-auto">
            <fieldset class="m-4 pb-4 border bg-gray-100 rounded-lg">
                <nav class=" text-sm flex justify-center bg-gray-200">
                    <a @click="currentTab(1)" class="inline-block px-4 py-2 cursor-pointer" :class="tab  === 1 && `active`" >Damaged Items</a>
                    <a @click="currentTab(2)" class="inline-block px-4 py-2 cursor-pointer" :class="tab  === 2 && `active`">Damaged Items Details</a>
                </nav>

            
            <div class="p-3  bg-gra-200 ">

                <div v-if="tab === 1">
                    <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-lg font-medium text-left px-2">Damaged Items List</legend>
                         <div class="overflow-auto rounded-lg shadow ">
                            <table class="w-full ">
                                <thead class="bg-gray-50 border-b-2 border-gray-200">
                                    <tr>
                                        <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Region </th>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Item</th>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">description</th>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Quantity</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white" v-for="(list,loop) in lists?.data" :key="loop">
                                        <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                                        <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.region?.name }}</td>
                                        <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.item?.name }}</td>
                                        <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.item?.description }}</td>
                                        <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.quantity }} {{ list.item?.unit }}</td>
                                
                                    
                                    </tr>
                                </tbody>
                            </table>
                            <div >
                                <!-- Render the pagination links -->
                                <PaginationLink @action="changePage(lists?.next_page_url)" :pages="links"/>
                            </div>
                        </div>
    
                    </fieldset>
                </div>

                <!-- step 2 education -->
                <div v-if="tab === 2">
                    
                    <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-lg font-medium text-left px-2">Damaged Items Details</legend>
                        <DamagedItemDetail/>
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