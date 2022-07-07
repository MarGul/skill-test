<template>
    <header>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">Create Product</h1>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
            <div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Product</h3>
                            <p class="mt-1 text-sm text-gray-600">Create a new Product by adding a title and a
                                description</p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form @submit.prevent="saveProduct">
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                    <div class="">
                                        <label for="product-title"
                                               class="block text-sm font-medium text-gray-700">Title</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input v-model="form.title" type="text" id="product-title"
                                                   :class="{'border-red-500': errors.title}"
                                                   class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                                   placeholder="Title">
                                        </div>
                                        <div
                                            class="mt-1 text-sm text-red-500"
                                            v-if="errors.title"
                                        >
                                            {{ errors.title[0] }}
                                        </div>
                                    </div>

                                    <div>
                                        <label for="product-description"
                                               class="block text-sm font-medium text-gray-700">Description</label>
                                        <div class="mt-1">
                                            <textarea v-model="form.description" id="product-description" rows="3"
                                                      :class="{'border-red-500': errors.description}"
                                                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                                                      placeholder="Description"></textarea>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">Brief description for the product.</p>
                                        <div
                                            class="mt-1 text-sm text-red-500"
                                            v-if="errors.description"
                                        >
                                            {{ errors.description[0] }}
                                        </div>
                                    </div>

                                    <div class="">
                                        <label for="product-price"
                                               class="block text-sm font-medium text-gray-700">Price</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input v-model="form.price" type="text" id="product-price"
                                                   :class="{'border-red-500': errors.price}"
                                                   class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                                   placeholder="Price">
                                        </div>
                                        <div
                                            class="mt-1 text-sm text-red-500"
                                            v-if="errors.price"
                                        >
                                            {{ errors.price[0] }}
                                        </div>
                                    </div>

                                    <div>
                                        <div class="flex items-center mb-4">
                                            <input id="default-radio-1" type="radio" v-model="form.in_stock"
                                                   v-bind:value="false" name="default-radio"
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="default-radio-1"
                                                   class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Not
                                                in stock</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input checked id="default-radio-2" type="radio" v-model="form.in_stock"
                                                   v-bind:value="true" name="default-radio"
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="default-radio-2"
                                                   class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">In
                                                stock</label>
                                        </div>

                                        <div
                                            class="mt-1 text-sm text-red-500"
                                            v-if="errors.in_stock"
                                        >
                                            {{ errors.in_stock[0] }}
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                            Image
                                        </label>
                                        <div class="mt-1 flex items-center">
                                            <span
                                                class="inline-block h-20 w-20 rounded-full overflow-hidden bg-gray-100"
                                            >
                                                <img
                                                    :src="photoPreview"
                                                    class="h-full w-full rounded-full object-cover object-center"
                                                    alt="product image"
                                                />
                                            </span>
                                            <input
                                                type="file"
                                                accept="image/*"
                                                ref="photoInput"
                                                @change="updatePhotoPreview"
                                                hidden
                                            />
                                            <button
                                                type="button"
                                                class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                @click="selectNewPhoto"
                                            >
                                                Change
                                            </button>
                                        </div>
                                        <div
                                            class="mt-1 text-sm text-red-500"
                                            v-if="errors.image"
                                        >
                                            {{ errors.image[0] }}
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700">
                                            Category
                                        </label>
                                        <div
                                            class="mt-1 flex rounded-md shadow-sm"
                                        >
                                            <div class="flex justify-center">
                                                <div class="form-check form-check-inline"
                                                     v-for="(
                                                        title, id
                                                    ) in categories"
                                                     :key="id"
                                                     :value="id"
                                                >
                                                    <input
                                                        class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                                                        type="checkbox"
                                                        id="inlineCheckbox1"
                                                        v-model="form.category"
                                                        v-bind:value="id">
                                                    <label class="form-check-label inline-block text-gray-800"
                                                           for="inlineCheckbox1"> {{ title }}</label>
                                                </div>

                                            </div>
                                        </div>
                                        <div
                                            class="mt-1 text-sm text-red-500"
                                            v-if="errors.category"
                                        >
                                            {{ errors.category[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button type="submit"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Create
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup>
    import {useForm} from "@inertiajs/inertia-vue3"
    import {ref} from "vue"

    const props = defineProps({
        categories: Object,
        errors: Object
    })

    const form = useForm({
        title: null,
        description: null,
        price: null,
        image: null,
        in_stock: true,
        category: [],
    });
    const photoPreview = ref(
        "/images/placeholder-image.jpg"
    );
    const photoInput = ref(null);

    function saveProduct() {
        if (photoInput.value) {
            form.image = photoInput.value.files[0];
        }
        form.post(route("products.store"), {
            onError: (data) => {
            },
        });
    }

    const selectNewPhoto = () => {
        photoInput.value.click();
    };
    const updatePhotoPreview = () => {
        const photo = photoInput.value.files[0];
        if (!photo) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreview.value = e.target.result;
        };
        reader.readAsDataURL(photo);
    };
</script>

