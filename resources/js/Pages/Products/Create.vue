<template>
    <header>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight text-gray-900">
                Create product
            </h1>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
            <div>
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3
                                class="text-lg font-medium leading-6 text-gray-900"
                            >
                                Product
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Create a new product by filling necessary fields
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form @submit.prevent="saveProduct">
                            <div
                                class="shadow sm:rounded-md sm:overflow-hidden"
                            >
                                <div
                                    class="px-4 py-5 bg-white space-y-6 sm:p-6"
                                >
                                    <div>
                                        <label
                                            for="product-title"
                                            class="block text-sm font-medium text-gray-700"
                                            >Title</label
                                        >
                                        <div
                                            class="mt-1 flex rounded-md shadow-sm"
                                        >
                                            <input
                                                v-model="form.title"
                                                type="text"
                                                id="product-title"
                                                :class="{
                                                    'border-red-500':
                                                        form.errors.title,
                                                }"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                                placeholder="Title"
                                            />
                                        </div>
                                        <div
                                            class="mt-1 text-sm text-red-500"
                                            v-if="form.errors.title"
                                        >
                                            {{ form.errors.title }}
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            for="product-description"
                                            class="block text-sm font-medium text-gray-700"
                                            >Description</label
                                        >
                                        <div class="mt-1">
                                            <textarea
                                                v-model="form.description"
                                                id="product-description"
                                                rows="3"
                                                :class="{
                                                    'border-red-500':
                                                        form.errors.description,
                                                }"
                                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                                                placeholder="Description"
                                            ></textarea>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Brief description for the product.
                                        </p>
                                        <div
                                            class="mt-1 text-sm text-red-500"
                                            v-if="form.errors.description"
                                        >
                                            {{ form.errors.description }}
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700"
                                        >
                                            Image
                                        </label>
                                        <div class="mt-1 flex items-center">
                                            <component
                                                :is="photoPreview ? 'a' : 'span'"
                                                :href="photoPreview || '#'"
                                                target="_blank"
                                                class="inline-block h-20 w-20 rounded-full overflow-hidden bg-gray-100"
                                            >
                                                <img
                                                    :src="photoPreview || 'http://www.vvc.cl/wp-content/uploads/2016/09/ef3-placeholder-image.jpg'"
                                                    class="h-full w-full rounded-full object-cover object-center"
                                                    alt="product image"
                                                />
                                            </component>
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
                                            v-if="form.errors.image"
                                        >
                                            {{ form.errors.image }}
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            for="product-price"
                                            class="block text-sm font-medium text-gray-700"
                                            >Price</label
                                        >
                                        <div
                                            class="mt-1 flex rounded-md shadow-sm"
                                        >
                                            <input
                                                v-model="form.price"
                                                type="number"
                                                step="any"
                                                id="product-price"
                                                :class="{
                                                    'border-red-500':
                                                        form.errors.price,
                                                }"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                                                placeholder="Price"
                                            />
                                        </div>
                                        <div
                                            class="mt-1 text-sm text-red-500"
                                            v-if="form.errors.price"
                                        >
                                            {{ form.errors.price }}
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            for="product-stock"
                                            class="block text-sm font-medium text-gray-700"
                                            >In Stock</label
                                        >
                                        <div
                                            class="mt-1 flex rounded-md shadow-sm"
                                        >
                                            <select
                                                id="product-stock"
                                                class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                v-model="form.in_stock"
                                            >
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div
                                            class="mt-1 text-sm text-red-500"
                                            v-if="form.errors.in_stock"
                                        >
                                            {{ form.errors.in_stock }}
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            for="product-category"
                                            class="block text-sm font-medium text-gray-700"
                                            >Category</label
                                        >
                                        <div
                                            class="mt-1 flex rounded-md shadow-sm"
                                        >
                                            <select
                                                id="product-category"
                                                class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                v-model="form.category"
                                            >
                                                <option
                                                    value=""
                                                    selected
                                                    disabled
                                                >
                                                    -- select a category --
                                                </option>
                                                <option
                                                    v-for="(
                                                        title, id
                                                    ) in categories"
                                                    :key="id"
                                                    :value="id"
                                                >
                                                    {{ title }}
                                                </option>
                                            </select>
                                        </div>
                                        <div
                                            class="mt-1 text-sm text-red-500"
                                            v-if="form.errors.category"
                                        >
                                            {{ form.errors.category }}
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                                >
                                    <button
                                        type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
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
import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

defineProps({
    categories: Object,
});

const form = useForm({
    title: null,
    description: null,
    price: null,
    image: null,
    in_stock: "yes",
    category: "",
});

const photoPreview = ref(null);
const photoInput = ref(null);

function saveProduct() {
    if (photoInput.value) {
        form.image = photoInput.value.files[0];
    }

    form.post(route("products.store"), {
        onSuccess: () => (photoInput.value = ""),
    });
}

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (!photo) return;

    photoPreview.value = URL.createObjectURL(photo);
};
</script>
