
<script setup>
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import { Link } from '@inertiajs/vue3';

</script>

<template>
   <aside class="hidden md:flex h-full w-64 bg-gray-800 text-white flex-col ">
    <div class="flex h-full w-full flex-col overflow-y-auto  pb-5">
        <div class="mb-auto border-b px-4 py-2 bg-gray-900 flex">
            <div class="shrink-0 flex items-center mr-2">
                <Link :href="route('dashboard')">
                    <ApplicationLogo
                        class="block h-4 w-auto fill-current text-gray-100"
                    />
                </Link>
            </div>
            <h2 class="text-xl font-bold">MIMS</h2>
        </div>
      
        <div class="flex-1 p-4">
            <ul>
                <li class="mb-2"><a href="#" class="hover:underline">Link 1</a></li>
                <li class="mb-2"><a href="#" class="hover:underline">Link 2</a></li>
                <li class="mb-2"><a href="#" class="hover:underline">Link 3</a></li>
            </ul>
        </div>
      <div class="mt-auto border-t mb-4 p-2">
        <h3 class="text-xl font-bold">Optimal Soft</h3>

      </div>
    </div>
  </aside>
  
</template>


<style  scoped>

</style>