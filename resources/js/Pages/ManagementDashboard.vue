<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head,Link } from '@inertiajs/vue3';

defineProps({
    data:Array
})
</script>

<template>
    <Head title="Admin Dashboard" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>
 
        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 my-1 font-bold rounded-md text-gray-900 border">Admin Dashboard</div>
                   
                        <div class="grid grid-cols-1  md:grid-cols-4 gap-1 border p-2">

                            <div class="p-3 m-1 shadow-md rounded-md border " v-for="(row,loop) in data" :key="loop">
                                <h2 class="text-xl font-bold text-center text-gray-800">{{ row.region }}</h2>
                                <div class="mt-4 flex justify-between text-gray-600">
                                    <div class="flex flex-col">
                                        <h3 class="text-sm font-semibold text-gray-800">State: {{ row.state }}</h3>
                                        <!-- <strong class="text-lg font-bold text-gray-900"># {{ data.todayRRR }}</strong> -->
                                    </div>
                                   <div class="flex flex-col">
                                        <h3 class="text-sm font-semibold text-gray-800">Total Recorded</h3>
                                        <strong class="text-lg font-bold text-gray-900"># {{ row.total }}</strong>
                                        <!--<strong class="text-sm text-optimal font-bold">Amount: {{ data.paidTodayAmount }}</strong> -->
                                    </div> 
                                </div>

                           <div class="mt-4">
                             <Link :href="route('login.region',{ region: row.pid })">
                                <button class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-700">Detail</button>
                            </Link>
                               
                                </div> 
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
