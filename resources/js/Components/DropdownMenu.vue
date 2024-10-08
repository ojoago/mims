<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';


const open = ref(false)

const toggleDropdown = () => {
    open.value = !open.value;
}

const props = defineProps({
    align: {
        type: String,
        default: 'right',
    },
    width: {
        type: String,
        default: '78',
    },
    contentClasses: {
        type: String,
        default: 'py-1 bg-white',
    },
});


const closeOnEscape = () => {
    if (open.value ) {
        open.value = false;
    }
};
onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));
const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'ltr:origin-top-left rtl:origin-top-right start-0';
    } else if (props.align === 'right') {
        return 'ltr:origin-top-right rtl:origin-top-left end-0';
    } else {
        return 'origin-top';
    }
});

const widthClass = computed(() => {
    return {
        '66' :'w-88',
    }[props.width.toString()];
});

     
</script>
<template>
  <div class="relative inline-block text-left">
    <!-- Button to toggle dropdown -->
    <div>
      <button
        @click="toggleDropdown"
        type="button"
        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none"
        id="menu-button"
        aria-expanded="true"
        aria-haspopup="true"
      >
        Options
        <!-- Chevron Icon -->
        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.293l3.71-3.07a.75.75 0 111.06 1.036l-4 3.3a.75.75 0 01-1.06 0l-4-3.3a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
        </svg>
      </button>
    </div>

    <!-- Dropdown menu -->
   
    <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-show="open"
                class="absolute z-50 mt-1 rounded-md shadow-lg"
                :class="[widthClass, alignmentClasses]"
                style="display: none"
                @click="open = false"
            >
                <div class="rounded-md ring-1 ring-black ring-opacity-5" :class="contentClasses">
                    <slot name="content" />
                </div>
            </div>
        </Transition>
        
  </div>
</template>



<style scoped>
/* Add any scoped styling here if needed */
</style>
