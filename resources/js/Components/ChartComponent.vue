<template>
    <div>
        <GChart v-if="length> 1" :type="chart" :data="data"
                        :options="options" />
                        <span v-else class="text-center p-4 mt-4"> {{ options?.title }}, No Data loaded</span>
    </div>
</template>

<script setup>

import { GChart } from 'vue-google-charts'

  defineProps({
        length:Number,
        chart:String,
        data:Array,
        options:Array
    })

</script>

