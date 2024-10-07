<script setup>
import AuthHeader from '@/Components/AuthHeader.vue';
import SideBar from '@/Components/SideBar.vue';


</script>
<template>
    <!-- component -->
    <div class="h-screen flex">
        <spinner-loader></spinner-loader>
    <!-- Sidebar -->
        <SideBar/>
            <main class="flex min-h-[90vh] flex-col w-full overflow-x-hidden overflow-y-auto mb-14">
            <!-- Header-->
            <AuthHeader/>
            <!--content-->
                <div class="flex w-full mx-auto px-6 py-1">
                    <div class="flex flex-col w-full h-full">
                        <slot/>
                    </div>
                </div>
                <!--- footer -->
                <!--- <Footer class="mt-auto"/> -->
        </main>
    </div>
</template>



<style scoped>
 ::-webkit-scrollbar {
     width: 5px;
     height: 5px;
 }

 ::-webkit-scrollbar-thumb {
     background: linear-gradient(13deg, #7bcfeb 14%, #e685d3 64%);
     border-radius: 10px;
 }

 ::-webkit-scrollbar-thumb:hover {
     background: linear-gradient(13deg, #c7ceff 14%, #f9d4ff 64%);
 }

 ::-webkit-scrollbar-track {
     background: #ffffff;
     border-radius: 10px;
     box-shadow: inset 7px 10px 12px #f0f0f0;
 }
</style>