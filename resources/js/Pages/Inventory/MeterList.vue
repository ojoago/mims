<script setup>

    import MainLayout from '@/Layouts/MainLayout.vue';
    import { Head,useForm } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';
import store from '@/store';
    import PaginationLinks from '@/Components/PaginationLinks.vue';

    // defineProps({
    //     data:Array
    // })


    const form = useForm({
        region: '',
        file: '',
    });

const submit = () => {
    form.post(route('upload.list'), {
        onFinish: () => form.reset(),
    });
};
const changePage = (link) => {
    if (!link.url || link.active) {
        return;
    }
    loadMeterLists(link.url)
};
const handleKeyup = (event) => {
    if(event.target.value.trim() == ''){
                return
            }
            store.dispatch('getMethod', { url:'search-meter-list/'+event.target.value }).then((data) => {
            if (data?.status == 200) {
                lists.value = data.data;
            }else{
                lists.value = []
            }
            }).catch(e => {
                console.log(e);
            })
};

 const lists = ref({})
    function loadMeterLists(url = 'load-meter-list'){
        store.dispatch('getMethod', { url:url }).then((data) => {
        if (data?.status == 200) {
            lists.value = data.data;
        }
        }).catch(e => {
            lists.value = [];
            console.log(e);
        })
    }
    loadMeterLists()


</script>

<template>
     <Head title="Meter List" />

    <MainLayout>
        <div class="px-4 py-5">
             <form @submit.prevent="submit">
                <div class="grid grid-col-2 gap-2">
                    <div>
                        
                <div class="flex justify-between">
                    <InputLabel for="file" value="Excel File" />
                    <a href="/files/images/meter list.xlsx" class="text-optimal font-bold">Download File</a>
                </div>

                <TextInput
                    id="file"
                    type="file"
                    class="mt-1 block w-full"
                    @input="form.file = $event.target.files[0]"
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.file" />
            </div>
            
            
            <div class="justify-end mb-1 ">
                <button  @click="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class=" bg-optimal text-white px-4 py-2 rounded mr-2">Submit</button>
               
            </div>
                </div>
        </form>
            <div class="overflow-auto rounded-lg shadow">
                    <TextInput
                                            id="longitude"
                                            type="text"
                                            class="mt-1 block w-full"
                                           @keyup="handleKeyup" 
                                            placeholder="Enter Meter Number"
                                            
                                        />
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th width ="5%" class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">S/N</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Meter Number</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Phase</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Type</th>
                            <th class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">Status</th>
                            <!--<th width ="5%"  class="p-3 text-sm font-semibold tracking-wide text-left table-bordered"> 
                                <font-awesome-icon icon="fa-solid fas fa-cog"/>
                            </th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white" v-for="(item,loop) in lists?.data" :key="loop">
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ loop+1 }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.meter_number }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.phase }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.type }}</td>
                            <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered">{{ item.meter_status }}</td>
                          <!--  <td class="p-3 text-sm font-semibold tracking-wide text-left table-bordered" >
                                <button class="p-1 oy-1 text-sm bg-yellow-500 text-white me-2 inline-block" @click="editItem(item)">Edit</button>
                            </td> -->
                        </tr>
                    </tbody>
                </table>
                <div class="mt-4">
                    <div class="flex space-x-1">
                        <pagination-links v-for="(link, i) of lists.links" :link="link" :key="i"
                            @next="changePage($event,link)"></pagination-links>
                    </div>
                </div>
        </div>
        </div>
    </MainLayout>
</template>



<style lang="scss" scoped>

</style>