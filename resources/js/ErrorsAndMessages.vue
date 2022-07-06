<template>
    <ul class="alert alert-danger" v-if="errors && Object.keys(errors).length > 0">
        <li v-for="(error, index) in errors" :key="index">{{error}}</li>
    </ul>
    <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" v-if="$page.props.flash.success">
        {{$page.props.flash.success}}
    </div>
</template>

<script setup>
const props = defineProps({
    errors: {
        type: Array,
        required: false
    }
})
</script>