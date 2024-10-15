<script setup>
    import { ref } from 'vue';
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
    import NavLink from '@/Components/NavLink.vue';
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
    import { Link,Head } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

    const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <Head>
            <link rel="icon" type="image/png" href="/files/images/title.png" />
        </Head>
         <nav class="bg-[#f1f1f1] border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-11">
                        <div class="flex">
                            <button class="mt-3 block md:hidden">
                                <font-awesome-icon icon="fa-solid fa-bars items-center" />
                            </button>
                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('dashboard')">
                                   <div class="shrink-0 flex items-center brand-name">
                                    Optimal, <small class="ml-2 region-name">[Region]</small>
                                </div>
                                </NavLink>
                            </div>
                        </div>

                        <div class=" sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{'dhasmom01@gmail.com' }}

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink class="bg-red-300 text-white hover:bg-red-300" :href="route('profile.edit')"> Update Password </DropdownLink>
                                        <DropdownLink class="bg-red-600 text-white  hover:bg-red-600" :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                        </div>
                        </div>


            </nav>
    </div>
</template>

<style scoped>

 .brand-name {
    font-size: 22px;
    color: #000;
    font-weight: 600;
    transition: .3s ease;
    transition-delay: .1s;
    text-transform: uppercase;
}
 .region-name {
    font-size: 16px;
    color: #000;
    font-weight: 600;
    transition: .3s ease;
    transition-delay: .1s;
    text-transform: uppercase;
}

</style>