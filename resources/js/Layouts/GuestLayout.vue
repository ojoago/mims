<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <Link href="/">
                <ApplicationLogo class="w-10 h-10 fill-current text-gray-500" />
            </Link>
             <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                   
                    <nav class="-mx-3 flex flex-1 justify-end">
                       

                     
                            <Link
                                :href="route('login')"
                                class=""
                            >
                              Log in
                            </Link>

                            <Link
                               
                                :href="route('register')"
                                class=""
                            >
                                Register
                            </Link>
                    </nav>
                </header>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
