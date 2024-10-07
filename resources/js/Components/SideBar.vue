
<script setup>
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import { Link,usePage } from '@inertiajs/vue3';

    const { url } = usePage();
    
    const activeRoute = (routeName) => {
        const furl = `${window.location.origin}${url}`;
        return furl === route(routeName);
    };


</script>

<template>
   <aside class="hidden md:flex h-full w-64 bg-gray-800 text-white flex-col ">
    <div class="flex h-full w-full flex-col overflow-y-auto  pb-5">
        <div class="mb-auto border-b px-4 py-2 bg-gray-900 flex">

            <h2 class="text-xl font-bold brand-name">MIMS</h2>
            <div class="shrink-0 flex items-center ml-2">
                <Link :href="route('dashboard')">
                    <ApplicationLogo
                        class="block h-4 w-auto fill-current text-gray-100"
                    />
                </Link>
            </div>
        </div>
      
        <div class="flex-1 p-4">
            <ul>
                <Link :href="route('dashboard')" class="flex link" :class="'active-link' && activeRoute('dashboard') ">
                    <font-awesome-icon icon="fa-solid fa-house " class="facon pt-1" />
                    <span class="nav-name">Dashboard </span>
                </Link>
                <Link :href="route('dependency')" class="flex link " :class="'active-link' && activeRoute('dependency') ">
                    <font-awesome-icon icon="fa-solid fa-keyboard " class="facon pt-1" />
                    <span class="nav-name">Dependency </span>
                </Link>
                
            </ul>
        </div>
      <div class="mt-auto border-t mb-1 p-2 items-center side-bottom">
        <!--<h3 class="text-xl font-bold">POWERED BY</h3> -->
        <div class="mx-auto">
            <img src="/files/images/optimal.png" alt="Optimal Soft Logo" />
        </div>
      </div>
    </div>
  </aside>
  
</template>


<style  scoped>

body {
    font-family: "Open Sans", sans-serif;
    position: relative;
}

.link{
    gap: 10px;
    padding: 12px 8px;
    border-radius: 8px;
    color: #000;
    background-color: #8c8888;
    margin-bottom: 2px;
}
.link:hover{
    background-color: #f1f1f1;
}
.active-link{
    background-color: #f1f1f1;
}


.facon {
    font-size: 12px !important;
}


.side-bottom img {
    height: auto;
    width: 100px;
    object-fit: cover;
    border-radius: 16px;
    /* margin: 0 20px 0 20px; */
    background: #f1f1f1;
    transition: all .5s ease;
    padding: 10px;
    border: solid #3bb3c2 2.5px;
}
</style>