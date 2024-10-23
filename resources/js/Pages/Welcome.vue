<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';


</script>

<template>
    <GuestLayout >
        <h1 class="font-poppins text-2xl"> MIMS: Meter Installation Management Software.</h1>
       <p class="font-poppins text-lg">
          

Manages installation, installers, staff and inventory. <br>
It automates installation processes starting from schedule, to requesting for meter by team lead to capturing which meter is install for a particular customer, when was it installed,
The modules are. <br>
1 inventory: this keeps track of every installation items in a particular region with the help of store manager. <br>
2 schedule: this module provide an interface through which we upload list of customers to be installed in a particular region as provided by Disco (JED) <br>
3 Request:
This module keep track of how many meters and it's accessories has been given to a particular installation teams. <br>
4 installation records:
This module is an interface through which we keep a digital copy of customers information in-line with the installation form provided my Disco (JED).
And also keep track of meter status (a. In store, b. Assigned to installation team for installation, c. installed, d. Faulty, e. Replaced. Etc) <br>
5. Customer complains:
Keep track of customers complain and resolutions. 
Report: comprehensive report interface that summarizes activities of each regions using charts and tables for management decisions
       </p>
        
    </GuestLayout>
    
      
       
          
       
</template>
