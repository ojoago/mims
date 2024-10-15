
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
   <aside class="hidden md:flex h-full w-64  bg-[#f1f1f1] text-white flex-col ">
    <div class="flex h-full w-full flex-col overflow-y-auto  pb-5">
        <div class="mb-auto border-b px-4 py-2  flex">

            <h2 class="text-xl font-bold text-optimal brand-name">MIMS</h2>
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
                <Link :href="route('dashboard')" class="flex link hover:bg-gray-300 " :class="activeRoute('dashboard') ? 'bg-gray-200 text-optimal font-bold' : 'bg-gray-400'">
                    <font-awesome-icon icon="fa-solid fa-house " class="facon pt-1" />
                    <span class="nav-name">Dashboard </span>
                </Link>
                <Link :href="route('dependency')" class="flex link hover:bg-gray-300" :class="activeRoute('dependency') ? 'bg-gray-200 text-optimal font-bold' : 'bg-gray-400'">
                    <font-awesome-icon icon="fa-solid fa-keyboard " class="facon pt-1" />
                    <span class="nav-name">Dependency </span>
                </Link>
                <Link :href="route('feeders')" class="flex link hover:bg-gray-300" :class="activeRoute('feeders') ? 'bg-gray-200 text-optimal font-bold' : 'bg-gray-400'">
                    <font-awesome-icon icon="fa-solid fa-keyboard " class="facon pt-1" />
                    <span class="nav-name">Feeders </span>
                </Link>
                <Link :href="route('create.staff')" class="flex link hover:bg-gray-300" :class="activeRoute('create.staff') ? 'bg-gray-200 text-optimal font-bold' : 'bg-gray-400'">
                    <font-awesome-icon icon="fa-solid fa-keyboard " class="facon pt-1" />
                    <span class="nav-name">Staff </span>
                </Link>
                <Link :href="route('schedules')" class="flex link hover:bg-gray-300" :class="activeRoute('schedules') ? 'bg-gray-200 text-optimal font-bold' : 'bg-gray-400'">
                    <font-awesome-icon icon="fa-solid fa-keyboard " class="facon pt-1" />
                    <span class="nav-name">Schedules </span>
                </Link>
                <Link :href="route('meter.list')" class="flex link hover:bg-gray-300" :class="activeRoute('meter.list') ? 'bg-gray-200 text-optimal font-bold' : 'bg-gray-400'">
                    <font-awesome-icon icon="fa-solid fa-keyboard " class="facon pt-1" />
                    <span class="nav-name">Meter List </span>
                </Link>
                <Link :href="route('inventory.list')" class="flex link hover:bg-gray-300" :class="activeRoute('inventory.list') ? 'bg-gray-200 text-optimal font-bold' : 'bg-gray-400'">
                    <font-awesome-icon icon="fa-solid fa-keyboard " class="facon pt-1" />
                    <span class="nav-name">Inventory Item </span>
                </Link>
                <Link :href="route('damage.item')" class="flex link hover:bg-gray-300" :class="activeRoute('damage.item') ? 'bg-gray-200 text-optimal font-bold' : 'bg-gray-400'">
                    <font-awesome-icon icon="fa-solid fa-keyboard " class="facon pt-1" />
                    <span class="nav-name">Damaged Item </span>
                </Link>

                <Link :href="route('teams')" class="flex link hover:bg-gray-300" :class="activeRoute('teams') ? 'bg-gray-200 text-optimal font-bold' : 'bg-gray-400'">
                    <font-awesome-icon icon="fa-solid fa-keyboard " class="facon pt-1" />
                   
                    <span class="nav-name">Teams </span>
                </Link>
                <Link :href="route('assigned.meters')" class="flex link hover:bg-gray-300" :class="activeRoute('assigned.meters') ? 'bg-gray-200 text-optimal font-bold' : 'bg-gray-400'">
                    <font-awesome-icon icon="fa-solid fa-keyboard " class="facon pt-1" />
                   
                    <span class="nav-name">Assigned Meter </span>
                </Link>
                <Link :href="route('installations')" class="flex link hover:bg-gray-300 " :class="activeRoute('installations') ? 'bg-gray-200 text-optimal font-bold' : 'bg-gray-400'">
                    <font-awesome-icon icon="fa-solid fa-keyboard " class="facon pt-1" />
                   
                    <span class="nav-name">Installations </span>
                </Link>
                <Link :href="route('request')" class="flex link hover:bg-gray-300" :class="activeRoute('request') ? 'bg-gray-200 text-optimal font-bold' : 'bg-gray-400'">
                    <font-awesome-icon icon="fa-solid fa-keyboard " class="facon pt-1" />
                   
                    <span class="nav-name">Request </span>
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
    padding: 8px ;
    border-radius: 8px;
    /* color: #000; */
    /* background-color: #8c8888; */
    margin-bottom: 2px;
}
/* .link:hover{
    background-color: #f1f1f1;
} */

/* link:active{
    background-color: #f1f1f1 !important;
} */


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