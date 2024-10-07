<template>
        <InputLabel :for="label" :value="label" />
        <select :name="label" :id="label" @change="emit('update:model-value', $event.target.value);" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" >
            <option value="" selected>{{ placeholder }}</option>
            <option v-for="(option,loop) in options" :key="loop" :value="val == 'id' ? option.id : option.text" :v-if="option.id === modelValue && val == 'id' ? 'selected' : '' || option.text === modelValue ? 'selected' : ''" >{{
                    option.text
                }}
            </option>
        </select>
</template>

<script setup>
import InputLabel from '@/Components/InputLabel.vue';

defineProps({
    label: String,
    placeholder: String,
    options: Object,
    error: String,
    modelValue: String,
    val:{
        type:String,
        default: 'id'
    },
});

let emit = defineEmits(['update:model-value']);
</script>