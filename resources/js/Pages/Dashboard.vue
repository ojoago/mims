<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import store from '@/store';
import { ref } from 'vue';
import ChartComponent from '@/Components/ChartComponent.vue';

const meterData = ref({options: {
    // theme: 'maximized',
    // chartArea:{width:"60%",height:"auto",} ,
    legend: { position: 'bottom', alignment: 'start' },
    backgroundColor: {
        fill: '#f1f1f1',
        fillOpacity: 0.8
      },
    title: 'Meters',
    vAxis: {minValue: 0}
}, data:[]})

const dailyData = ref({options: {
    // chartArea:{top:0,width:"80%",height:"100%"} ,
    legend: { position: 'bottom', alignment: 'start' },
    backgroundColor: {
        fill: '#f1f1f1',
        fillOpacity: 0.8
      },
    title: 'Daily Installations',
    // width: window.innerWidth,
    // height: 300,
}, data:[]})

const monthlyData = ref({options: {
    // chartArea:{width:"60%",height:"auto"} ,
    legend: { position: 'bottom', alignment: 'start' },
    backgroundColor: {
        fill: '#f1f1f1',
        fillOpacity: 0.8
      },
    title: 'Monthly Installations',
     vAxis: {minValue: 0}
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
    
//  const total = ref(0)
 const installation = ref({})
    function meterInstallation(url = 'meter-installation'){
        store.dispatch('getMethod', { url:url }).then((data) => {

        if (data?.status == 200) {
            installation.value = data.data;
            monthlyData.value.data.push(['Month','total'])
            // monthlyData.value.data.push(data?.data?.monthly)
            data?.data?.monthly.forEach((element) => {
                monthlyData.value.data.push([element?.month , element.count])
            })
            
            dailyData.value.data.push(['Day','total'])
            // dailyData.value.data.push(data?.data?.daily)
            data?.data?.daily.forEach((element) => {
                dailyData.value.data.push([element?.doi , element.count])
            })
            // meterData.value.options.title = 'Meters, Total: ' + total.value
        }
        }).catch(e => {
            console.log(e);
        })
    }

    meterSummary()
    meterInstallation()

</script>

<template>
    <Head title="Dashboard" />

    <MainLayout>

        <div class="py-1 ">
            <div class="px-2 ">
                <div class="bg-[#f1f1f1] overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex flex-col md:flex-row">
                        <ChartComponent :length="monthlyData?.data?.length" chart="PieChart" :data="monthlyData?.data" :options="monthlyData?.options" />
                        <ChartComponent :length="meterData?.data?.length" chart="PieChart" :data="meterData?.data" :options="meterData?.options" />
                    </div>
                    <ChartComponent :length="dailyData?.data?.length" chart="ColumnChart" :data="dailyData?.data" :options="dailyData?.options" />
                </div>
            </div>
        </div>
    </MainLayout>
</template>
