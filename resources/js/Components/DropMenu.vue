<script setup>
import { ref,computed } from 'vue';


  const props = defineProps({
        title:{
            type:String,
            default:'Action'
        },
        align:{
            type:String,
            default:'right'
        }
    })

    const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'ltr:origin-top-left rtl:origin-top-right start-0';
    } else if (props.align === 'right') {
        return 'ltr:origin-top-right rtl:origin-top-left end-0';
    } else {
        return 'origin-top';
    }
});
const isOpen = ref(false);

</script>

<template>

  <section class="dropDownMenuWrapper">

    <button class="dropDownMenuButton" ref="menu" @click="isOpen = !isOpen">{{title}}</button>
<!--
    <div class="iconWrapper" @click="isOpen = !isOpen">
        <div class="bar1" :class="{ 'bar1--open' : isOpen }" />
        <div class="bar2" :class="{ 'bar2--open' : isOpen }" />
        <div class="bar3" :class="{ 'bar3--open' : isOpen }" />
    </div> -->

    <section class="dropdownMenu z-50" v-if="isOpen" @click="isOpen = !isOpen" :class="[ alignmentClasses]">
      <div class="menuArrow" />
      <slot @click="isOpen = !isOpen" />
    </section>

  </section>

</template>

<style scoped>

.dropDownMenuWrapper {
	 position: relative;
	 width: 100%;
	 height: 40px;
	 border-radius: 8px;
	 background: white;
	 border: 1px solid #eee;
	 box-shadow: 10px 10px 0 0 rgba(0, 0, 0, .03);
	 -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}
 .dropDownMenuWrapper * {
	 box-sizing: border-box;
	 text-align: left;
}
 .dropDownMenuWrapper .dropDownMenuButton {
	 border: none;
	 font-size: inherit;
	 background: none;
	 outline: none;
	 border-radius: 4px;
	 position: absolute;
	 top: 0;
	 left: 0;
	 display: flex;
	 align-items: center;
	 padding: 0 70px 0 20px;
	 margin: 0;
	 line-height: 1;
	 width: 100%;
	 height: 100%;
	 z-index: 2;
	 cursor: pointer;
}
 .dropDownMenuWrapper .dropDownMenuButton--dark {
	 color: #eee;
}
 .dropDownMenuWrapper .iconWrapper {
	 width: 25px;
	 height: 25px;
	 position: absolute;
	 right: 30px;
	 top: 50%;
	 transform: translate(0, -50%);
	 z-index: 1;
}
 
 .dropDownMenuWrapper .iconWrapper--noTitle {
	 left: 0;
	 top: 0;
	 bottom: 0;
	 right: 0;
	 width: auto;
	 height: auto;
	 transform: none;
}
 .dropDownMenuWrapper .dropdownMenu {
	 position: absolute;
	 top: 100%;
	 width: auto;
	 min-width: 200px;
	 min-height: 10px;
	 border-radius: 8px;
	 border: 1px solid #eee;
	 box-shadow: 10px 10px 0 0 rgba(0, 0, 0, .03);
	 background: white;
	 padding: 10px ;
	 animation: menu 0.3s ease forwards;
}
 .dropDownMenuWrapper .dropdownMenu .menuArrow {
	 width: 20px;
	 height: 20px;
	 position: absolute;
	 top: -10px;
	 left: 20px;
	 border-left: 1px solid #eee;
	 border-top: 1px solid #eee;
	 background: white;
	 transform: rotate(45deg);
	 border-radius: 4px 0 0 0;
}
 .dropDownMenuWrapper .dropdownMenu .menuArrow--dark {
	 background: #333;
	 border: none;
}
 .dropDownMenuWrapper .dropdownMenu .option {
	 width: 100%;
	 border-bottom: 1px solid #eee;
	 padding: 20px 0;
	 cursor: pointer;
	 position: relative;
	 z-index: 2;
}
 .dropDownMenuWrapper .dropdownMenu .option:last-child {
	 border-bottom: 0;
}
 .dropDownMenuWrapper .dropdownMenu .option * {
	 color: inherit;
	 text-decoration: none;
	 background: none;
	 border: 0;
	 padding: 0;
	 outline: none;
	 cursor: pointer;
}
 .dropDownMenuWrapper .dropdownMenu .desc {
	 opacity: 0.5;
	 display: block;
	 width: 100%;
	 font-size: 14px;
	 margin: 3px 0 0 0;
	 cursor: default;
}
 .dropDownMenuWrapper .dropdownMenu--dark {
	 background: #333;
	 border: none;
}
 .dropDownMenuWrapper .dropdownMenu--dark .option {
	 border-bottom: 1px solid #888;
}
 .dropDownMenuWrapper .dropdownMenu--dark * {
	 color: #eee;
}
 @keyframes menu {
	 from {
		 transform: translate3d(0, 30px, 0);
	}
	 to {
		 transform: translate3d(0, 20px, 0);
	}
}
 .dropDownMenuWrapper--noTitle {
	 padding: 0;
	 width: 60px;
	 height: 60px;
}
 .dropDownMenuWrapper--dark {
	 background: #333;
	 border: none;
}
 
</style>