<template>
    <header>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                <div class="flex justify-between">
                    <h1 class="text-3xl font-bold leading-tight text-gray-900">
                        View categories
                    </h1>
                    <Link
                        v-if="categories.length"
                        :href="route('categories.create')"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Create
                    </Link>
                </div>
            </h1>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul
                    v-if="categories.length"
                    role="list"
                    class="divide-y divide-gray-200"
                >
                    <li v-for="category in categories" :key="category.id">
                        <Link
                            :href="
                                route('categories.edit', {
                                    category: category.id,
                                })
                            "
                            class="block hover:bg-gray-50"
                        >
                            <div class="px-4 py-4 flex items-center sm:px-6">
                                <div
                                    class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between"
                                >
                                    <div class="truncate">
                                        <div class="flex text-sm">
                                            <p
                                                class="font-medium text-indigo-600 truncate"
                                                v-text="category.title"
                                            />
                                        </div>
                                        <div class="mt-2 flex">
                                            <div
                                                class="flex items-center text-sm text-gray-500"
                                            >
                                                <!-- Heroicon name: solid/calendar -->
                                                <svg
                                                    class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                                <p>
                                                    Created on
                                                    <time
                                                        :datetime="
                                                            category.created_at
                                                        "
                                                        v-text="
                                                            category.created_at
                                                        "
                                                    />
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-5 flex-shrink-0">
                                    <!-- Heroicon name: solid/chevron-right -->
                                    <svg
                                        class="h-5 w-5 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </Link>
                    </li>
                </ul>

                <Link
                    :href="route('categories.create')"
                    v-else
                    class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <svg
                        class="mx-auto h-12 w-12 text-gray-400"
                        xmlns="http://www.w3.org/2000/svg"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 48 48"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6"
                        />
                    </svg>
                    <span class="mt-2 block text-sm font-medium text-gray-900">
                        Create a new category
                    </span>
                </Link>
            </div>
        </div>
    </main>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
});
</script>
