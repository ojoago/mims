
<script setup>
    import store from '@/store';
    import { ref } from 'vue';

     const items = ref({})
    function loadItem(url = 'damaged-item-details'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            items.value = data.data;
        }
        }).catch(e => {
            console.log(e);
        })
    }
    loadItem()
</script>

<template>
    <div>
        
        <div class="overflow-auto rounded-lg shadow ">
                            <table class="w-full ">
                                <thead class="bg-gray-50 border-b-2 border-gray-200">
                                    <tr>
                                        <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                                      <!--  <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Region </th> -->
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Item</th>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Cause Of Damage</th>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Quantity</th>
                                        <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Date</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white" v-for="(list,loop) in items?.data" :key="loop">
                                        <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                                       <!-- <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.region?.name }}</td> -->
                                        <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.item?.name }}</td>
                                        <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.cause }}</td>
                                        <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.quantity }} {{ list.item?.unit }}</td>
                                        <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ list.date }}</td>
                                
                                    
                                    </tr>
                                </tbody>
                            </table>
                            <div >
                                <!-- Render the pagination links -->
                                <PaginationLink @action="changePage(items?.next_page_url)" :pages="items"/>
                            </div>
                        </div>
    </div>
</template>


<style scoped>

</style>