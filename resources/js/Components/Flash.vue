<template>
    <div >
        <div class="alert" v-if="$page.props.flash.message">
            {{ $page.props.flash.message }}
        </div>
        <div class="alert" v-if="$page.props.flash.error">
            {{ $page.props.flash.error }}
        </div>
        <div class="alert" v-if="$page.props.flash.warning">
            {{ $page.props.flash.warning }}
        </div>
        <div class="alert" v-if="$page.props.flash.error">
            {{ $page.props.flash.error }}
        </div>
    </div>
</template>

<script setup>

</script>