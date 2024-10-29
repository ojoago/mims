<script setup>
    import { ref } from 'vue';
    // import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
    import NavLink from '@/Components/NavLink.vue';
    // import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
    import { Link,Head } from '@inertiajs/vue3';
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import Modal from '@/Components/Modal.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { formatError } from "@/composables/formatError";
import store from '@/store';
    const { transformValidationErrors } = formatError()
    const showModal = ref(false)
    const closeModal = () =>{
        showModal.value = false;
    }

    
    const form = ref({
        current_password:'',
        password:'',
        password_confirmation:'',
        errors:{}
    });

     function updatePassword() {
        form.value.errors = {}
        store.dispatch('postMethod', { url: '/update-passord', param: form.value }).then((data ) => {
        if (data?.status == 422) {
            form.value.errors = transformValidationErrors(data.data)
        } else if (data?.status == 201) {
            closeModal()
        }
        }).catch(e => {
            console.log(e);
        })
    }

</script>

<template>
    <div>
        <Head>
            <link rel="icon" type="image/png" href="/files/images/title.png" />
        </Head>
         
        <Modal :show="showModal" @close="closeModal" max-width="sm" title="Update Password " @submit="updatePassword">
           <form action="" class="px-4 py-2">
                    <div>
                <InputLabel for="current_password" value="Current Password" />

                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="off"
                    placeholder="current password"
                />

                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>
            <div>
                <InputLabel for="password" value="New Password" />
                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="off"
                    placeholder=" password"
                />
                <InputError :message="form.errors.password" class="mt-2" />
            </div>
            <div>
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                    placeholder="password confirmation"

                />

                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

           </form>
        </Modal>
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
                                    Triple Seventh, <small class="ml-2 region-name">[{{ $page?.props?.auth?.region }}]</small>
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
                                                {{$page?.props?.auth?.user?.email }}

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
                                        <button class="bg-red-200 text-white w-full hover:bg-red-200 py-1" @click="showModal = true" type="button" as="button"> Update Password </button>
                                        <DropdownLink class="bg-red-400 text-white text-center  hover:bg-red-400" :href="route('logout.region')" method="get" as="button" v-if="$page.props.auth.role.includes('super admin') || $page.props.auth.role.includes('management')">
                                            Log Out Region
                                        </DropdownLink>
                                        <DropdownLink class="bg-red-600 text-white text-center  hover:bg-red-600" :href="route('logout')" method="post" as="button">
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