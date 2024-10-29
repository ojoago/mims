<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import store from '@/store';
import { ref } from 'vue';
import ChartComponent from '@/Components/ChartComponent.vue';

const meterData = ref({options: {
    title: 'Meters',
    width: 700,
    height: 700,
}, data:[]})


const meterStatus = ['','In store','Taken out for Installation','Installed','Faulty'];

 const total = ref(0)
 const summary = ref({})
    function meterSummary(url = 'meter-summary'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            summary.value = data.data;
            meterData.value.data.push(['Status','total'])
            summary.value.forEach((element) => {
                total.value += element.count
                meterData.value.data.push([meterStatus[element?.status] , element.count])
            })
            meterData.value.options.title = 'Meters, Total: ' + total.value
        }
        }).catch(e => {
            console.log(e);
        })
    }
    meterSummary()
</script>

<template>
    <Head title="Dashboard" />

    <MainLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                    {{ summary }}
                    <ChartComponent :length="meterData?.data?.length" chart="PieChart" :data="meterData?.data" :options="meterData?.options" />

                </div>
            </div>
        </div>
    </MainLayout>
</template>
