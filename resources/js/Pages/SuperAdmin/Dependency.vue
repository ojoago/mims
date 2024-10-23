<script setup>

import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Region from '@/Components/Tabs/RegionTab.vue';
// import Feeders from '@/Components/Tabs/33kvaFeederTab.vue';
// import Feeder11kv from '@/Components/Tabs/11kvaFeederTab.vue';
import Items from '@/Components/Tabs/ItemsTab.vue';
import TradingZoneTab from '@/Components/Tabs/TradingZoneTab.vue';
import MeterBrandTab from '@/Components/Tabs/MeterBrandTab.vue';
import MeterTypeTab from '@/Components/Tabs/MeterTypeTab.vue';
import RegionAdminTab from '@/Components/Tabs/RegionAdminTab.vue';
const tab = ref(1);
const currentTab = (tabNumber) => (tab.value = tabNumber);



</script>
<template>
     <Head title="Dependency" />
    <MainLayout>
        <div class="container mx-auto">
            <fieldset class="m-4 pb-4 border bg-gray-100 rounded-lg">
                <nav class=" text-sm flex justify-center bg-gray-200">
                    <a @click="currentTab(1)" class="inline-block px-4 py-2 cursor-pointer" :class="tab  === 1 && `active`" >Regions</a>
                    <a @click="currentTab(7)" class="inline-block px-4 py-2 cursor-pointer" :class="tab  === 7 && `active`">Region Admin</a>
                    <a @click="currentTab(2)" class="inline-block px-4 py-2 cursor-pointer" :class="tab  === 2 && `active`">Store Items</a>
                    <a @click="currentTab(3)" class="inline-block px-4 py-2 cursor-pointer" :class="tab  === 3 && `active`">Trading Zone</a>
                    <a @click="currentTab(5)" class="inline-block px-4 py-2 cursor-pointer" :class="tab  === 5 && `active`">Meter Type </a>
                    <a @click="currentTab(6)" class="inline-block px-4 py-2 cursor-pointer" :class="tab  === 6 && `active`">Meter Brand</a>
                </nav>

            
            <div class="p-3  bg-gra-200 ">

                <div v-if="tab === 1">
                    <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-lg font-medium text-left px-2">Regions</legend>
                        <Region/>
    
                    </fieldset>
                </div>

               
               
                <div v-if="tab === 2">
                   <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-lg font-medium text-left px-2">Items</legend>
                       <Items/>

                   </fieldset>
                </div>
                
                <div v-if="tab === 3">
                   <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-lg font-medium text-left px-2">Trading Zone</legend>
                       <TradingZoneTab/>

                   </fieldset>
                </div>
                 <!-- step 2 education -->
               
                <div v-if="tab === 5">
                   <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-lg font-medium text-left px-2">Meter Type</legend>
                       <MeterTypeTab/>

                   </fieldset>
                </div>

                <div v-if="tab === 6">
                   <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-lg font-medium text-left px-2">Meter Brand</legend>
                       <MeterBrandTab/>

                   </fieldset>
                </div>
                <div v-if="tab === 7">
                   <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-lg font-medium text-left px-2">Region Admin</legend>
                       <RegionAdminTab/>

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