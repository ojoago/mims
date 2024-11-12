<script setup>

    import MainLayout from '@/Layouts/MainLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Inertia } from '@inertiajs/inertia';
    import { StreamBarcodeReader } from "vue-barcode-reader";
    // import { ImageBarcodeReader } from "vue-barcode-reader";
    import { ref } from 'vue';
import store from '@/store';
   
const onDecode = (detectedCodes) => {
    scannedNumber.value.meter_number  = detectedCodes
    addNumber()
};

// status
    const scannedNumber = ref({
        meter_number: '',
        errors:{}
    });
    const scan = ref(false);

    function addNumber() {
        scan.value = false
        store.dispatch('postMethod', { url: '/add-meter-number', param: scannedNumber.value }).then((data ) => {
        if (data?.status == 422) {
            scannedNumber.value.errors = transformValidationErrors(data.data)
        } 
        else if (data?.status == 201) {
           loadMeters()
        }
        }).catch(e => {
            console.log(e);
        })
    }

    const meters  = ref({})
    function loadMeters( url = '/load-team-assigned-meters') {
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            meters.value = data.data;
        }else{
            meters.value = data.data;
        }
        }).catch(e => {
            meters.value = [];
            console.log(e);
        })
    }

    loadMeters()


// const onLoaded = (detectedCodes) => {
//     alert('loaded')
//     console.log(detectedCodes);
//     detected.value = detectedCodes
    
// };


const changePage = (link) => {
    if (!link.url || link.active) {
        return;
    }
    loadMeters(link.url)
};

</script>

<template>
     <Head title="Meter List" />

    <MainLayout>
        <div class="px-4 py-5">
            <button  @click="scan = true" class=" bg-optimal text-white px-4 py-2 rounded mb-2" v-if="!scan">Scan</button>
            
            <div class="w-full md:w-1/4">
                <StreamBarcodeReader @decode="onDecode" v-if="scan"></StreamBarcodeReader>
            </div>
            <button  @click="scan = false" class=" bg-optimal text-white px-4 py-2 rounded mt-2 mb-1" v-if="scan">Stop</button>
           
            <div class="overflow-auto rounded-lg shadow">
                    
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Meter Number</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Phase</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Type</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Status</th>
                            <th width ="5%"  class="p-3 text-sm font-semibold tracking-wide text-left"> 
                                <font-awesome-icon icon="fa-solid fas fa-cog"/>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white" v-for="(item,loop) in meters?.data" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.meter_number }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.phase }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.type }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.status }}</td>
                           <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button class="p-1 oy-1 text-sm bg-yellow-500 rounded-md text-white me-2 inline-block" @click="editItem(item)">Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-4">
                    <div class="flex space-x-1">
                        <pagination-links v-for="(link, i) of meters.links" :link="link" :key="i"
                            @next="changePage($event,link)"></pagination-links>
                    </div>
                </div>
                
        </div>
        </div>
    </MainLayout>
</template>



<style lang="scss" scoped>

</style>