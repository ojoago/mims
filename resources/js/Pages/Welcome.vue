<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';


</script>

<template>
    <GuestLayout >
        <h1 class="font-poppins text-2xl"> MIMS: Meter Installation Management Software.</h1>
       <p class="font-poppins text-lg mb-8">
          
<ol>
    Manages installation, installers, staff and Inventory. <br>
It automates installation processes starting from schedule, to requesting for meter by team lead to capturing which meter is install for a particular customer, when was it installed,
The modules are.
<li><strong>Inventory</strong>: This keeps track of every installation item in a particular region with the help of the store manager.</li>
<li><strong>Schedule</strong>: This module provides an interface through which we upload a list of customers to be installed in a particular region as provided by Disco (JED).</li>
<li><strong>Request</strong>: This module keeps track of how many meters and their accessories have been given to particular installation teams.</li>
<li><strong>Installation Records</strong>: This module is an interface through which we keep a digital copy of customers' information in line with the installation form provided by Disco (JED). It also keeps track of meter status (a. In store, b. Assigned to installation team for installation, c. Installed, d. Faulty, e. Replaced, etc.).</li>
<li><strong>Customer Complaints</strong>: Keeps track of customers' complaints and resolutions.</li>
<li><strong>Report</strong>: A comprehensive report interface that summarizes activities of each region using charts and tables for management decisions.</li>
</ol>

       </p>
        
    </GuestLayout>
    
      
       
          
       
</template>
