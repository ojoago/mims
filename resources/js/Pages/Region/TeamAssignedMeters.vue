<script setup>

    import MainLayout from '@/Layouts/MainLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Inertia } from '@inertiajs/inertia';
    import { StreamBarcodeReader } from "vue-barcode-reader";
    // import { ImageBarcodeReader } from "vue-barcode-reader";
    import { ref } from 'vue';
    defineProps({
        data:Array
    })


   
const onDecode = (detectedCodes) => {
    scannedNumber.value.meter_number  = detectedCodes
    addNumber()
};

// const onLoaded = (detectedCodes) => {
//     alert('loaded')
//     console.log(detectedCodes);
//     detected.value = detectedCodes
// };


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
        // else if (data?.status == 201) {
           
        // }
        }).catch(e => {
            console.log(e);
        })
    }


// const onLoaded = (detectedCodes) => {
//     alert('loaded')
//     console.log(detectedCodes);
//     detected.value = detectedCodes
    
// };
const detected  = ref(null)
const changePage = (url) => {
    Inertia.get(url, {}, { preserveState: true, preserveScroll: true });
    // store.dispatch('getMethod', { url:url }).then((data) => {
    //     console.log(data);
    //     if (data?.status == 200) {
    //         props.data = data.data;
            
            
    //     }
    //     }).catch(e => {
    //         console.log(e);
    //     })
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
            <button  @click="scan = false" class=" bg-optimal text-white px-4 py-2 rounded mb-1" v-if="scan">Stop</button>
           
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
                        <tr class="bg-white" v-for="(item,loop) in data?.data" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.meter_number }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.phase }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.type }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.status }}</td>
                           <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button class="p-1 oy-1 text-sm bg-yellow-500 text-white me-2 inline-block" @click="editItem(item)">Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-4">
                     <!-- Render the pagination links -->
                    <nav v-if="data?.links.length">
                  

                    <button @click="changePage(data?.prev_page_url)" :disabled="!data?.prev_page_url" class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50">Previous</button>
                    <button @click="changePage(data?.next_page_url)" :disabled="!data?.next_page_url" class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50">Next</button>
                    </nav>
                </div>
                
        </div>
        </div>
    </MainLayout>
</template>



<style lang="scss" scoped>

</style>