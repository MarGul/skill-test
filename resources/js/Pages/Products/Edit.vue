<template>
    <header>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight text-gray-900" v-text="`Edit ${product.title}`" />
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
            <div>
                <ErrorsAndMessages :errors="errors" />
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Product</h3>
                            <p class="mt-1 text-sm text-gray-600">Edit the product by updating the title and adescription</p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <!-- @submit.prevent="form.patch(route('products.update', props.product.id))" -->
                        <form enctype="multipart/form-data">
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                    <div class="">
                                        <label for="product-title" class="block text-sm font-medium text-gray-700">Title</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input v-model="form.title" type="text" id="product-title"
                                                :class="{ 'border-red-500': form.errors.title }"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                                placeholder="Title">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="product-description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <div class="mt-1">
                                            <textarea v-model="form.description" id="product-description" rows="3"
                                                :class="{ 'border-red-500': form.errors.description }"
                                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                                                placeholder="Description"></textarea>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">Brief description for the product.</p>
                                    </div>

                                    <div class="">
                                        <label for="product-title" class="block text-sm font-medium text-gray-700">Category</label>
                                        <select class="form-select appearance-none
                                        mt-1
                                        block
                                        w-full
                                        px-3
                                        py-1.5
                                        text-base
                                        font-normal
                                        text-gray-700
                                        bg-white bg-clip-padding bg-no-repeat
                                        border border-solid border-gray-300
                                        rounded
                                        transition
                                        ease-in-out
                                        m-0
                                        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" v-model="form.category" aria-label="Default select example">
                                            <option :value="category.id" v-for="category in props.category" :key="category.id">{{ category.title }}</option>
                                        </select>
                                    </div>

                                    <div class="">
                                        <label for="product-price" class="block text-sm font-medium text-gray-700">Price</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input v-model="form.price" type="number" id="product-price" :class="{'border-red-500': form.errors.price}" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300" placeholder="Price">
                                        </div>
                                    </div>

                                    <div>
                                        <label for="product-stock" class="block text-sm font-medium text-gray-700">In stock</label>
                                        <div class="form-check">
                                            <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="stock" id="stock1" :checked="product.stock == 1" @click="stock(1)" value="1">
                                            <label class="form-check-label inline-block text-gray-800" for="stock1">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="stock" id="stock2" :checked="product.stock == 0"  @click="stock(0)" value="0">
                                            <label class="form-check-label inline-block text-gray-800" for="stock2">
                                                No
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="product-image" class="block text-sm font-medium text-gray-700">Product image</label>
                                        <div class="mt-1 flex items-center">
                                            <label
                                                class="inline-block h-20 w-20 rounded-full overflow-hidden bg-gray-100">
                                                <div class="relative flex flex-col items-center justify-center pt-7">
                                                    <img v-show="imageUpdate" id="preview-new"  class="absolute inset-0 w-full h-32">
                                                    <img v-show="!imageUpdate" :src="'/uploads/'+form.image" id="preview"  class="absolute inset-0 w-full h-32">
                                                </div>
                                                <input type="file" class="opacity-0" @change="showPreview($event)" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 flex justify-between sm:px-6">
                                    <form @submit.prevent="form.post(route('products.destroy', {product: props.product.id}))">
                                    <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Delete</button>
                                    </form>
                                    <button type="submit" @click.prevent="update(form)"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update</button>
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
import { useForm } from '@inertiajs/inertia-vue3'
import {Inertia} from "@inertiajs/inertia";
import { defineComponent, ref } from '@vue/runtime-core';
import ErrorsAndMessages from '../../ErrorsAndMessages.vue'

const imageUpdate = ref(false);
const components = defineComponent({
    ErrorsAndMessages
})

const props = defineProps({
    product: {
        type: Object,
        required: true
    },
    category: {
        type: Array,
        required: true
    },
    errors: {
        type: Object,
        required: false
    }
})

const form = useForm({
    title: props.product.title,
    description: props.product.description,
    category: props.product.category,
    price: props.product.price,
    stock: props.product.stock,
    image: props.product.image
})
function showPreview(event) {
    if (event.target.files.length > 0) {
        this.imageUpdate = true;
        var src = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById("preview-new");
        this.form.image = event.target.files[0];
        preview.src = src;
        preview.style.display = "block";
    }
}
function update(data) {
    data._method = 'POST';
    Inertia.post(route('products.update', {'id': props.product.id}), data, {
        forceFormData: true
    });
}
function stock(value) {
    this.form.stock = value
}
</script>