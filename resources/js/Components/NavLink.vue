<template>
    <Link
        :href="href"
        :class="classes"
        aria-current="page"
    >
        <slot></slot>
    </Link>
</template>

<script setup>
    import {Link} from "@inertiajs/inertia-vue3"
    import {computed} from "vue"

    const props = defineProps({
        href: String,
        active: Boolean,
    });

    const classes = computed(() => {
        return props.active
            ? "border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium"
            : "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium";
    });
</script>
