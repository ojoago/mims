<script setup>

    import MainLayout from '@/Layouts/MainLayout.vue';
    import { Head,useForm } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
import { Inertia } from '@inertiajs/inertia';

    defineProps({
        data:Array
    })


    const form = useForm({
        region: '',
        file: '',
    });

const submit = () => {
    form.post(route('meter.list'), {
        onFinish: () => form.reset(),
    });
};
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
             <form @submit.prevent="submit">
                <div class="grid grid-col-3 gap-2">
                
                    <div class="flex">
                        <div class="flex flex-col">
                        <InputLabel for="email" value="Scan" />
                        <TextInput
                            id="email"
                            type="text"
                            class="mt-1 block w-full"
                            autofocus
                            autocomplete="off"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                    
                    </div>
                    
                    <div class="">
                        <button  @click="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class=" bg-optimal text-white px-4 py-2 rounded mr-2">Submit</button>
                    </div>
                </div>
        </form>
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
                                <font-awesome-icon class="fa-solid fas fa-cog"/>
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