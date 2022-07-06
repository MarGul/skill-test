<template>
    <div class="min-h-full">
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <img class="hidden lg:block h-8 w-auto"
                                 src="https://tailwindui.com/img/logos/workflow-logo-indigo-600-mark-gray-800-text.svg"
                                 alt="Workflow">
                        </div>
                        <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                            <NavLink :href="route('categories.index')" :active="route().current('categories.index')">
                                Categories
                            </NavLink>
                            <NavLink :href="route('products.index')" :active="route().current('products.index')">
                                Products
                            </NavLink>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <Notifications/>

        <div class="py-10">
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
    import {Link} from '@inertiajs/inertia-vue3'
    import NavLink from '@/Components/NavLink.vue'
    import Notifications from "@/Shared/Notifications"
</script>
