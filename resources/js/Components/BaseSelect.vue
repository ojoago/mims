<template>
  <InputLabel :for="label" :value="label" />
  <select
    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    :value="selected"
    v-bind="{
      ...$attrs,
      onChange: ($event) => {
        $emit('update:modelValue', $event.target.value);
      },
    }"
  >
    <option value="" disabled>{{ defaultValue }}</option>
    <option
      v-for="(option,loop) in options"
      :key="loop"
      :value="option.id"
      :selected="option.id === selected"
    >
      {{ option.text }}
    </option>
  </select>
</template>


<script setup>
import InputLabel from '@/Components/InputLabel.vue';

defineProps({
    label: {
      type: String,
      default: ""
    },
    defaultValue: {
      type: String,
      default: "Select an Option",
      required: false
    },
    selected: {
      type: [String, Number],
      default: ""
    },
    options: {
      type: [Array,Object],
      required: true
    },
    val:{
        type:String,
        default: 'id'
    },
});

let emit = defineEmits(['update:model-value']);
</script>