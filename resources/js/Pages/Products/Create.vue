<template>
	<header>
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h1 class="text-3xl font-bold leading-tight text-gray-900">Create product</h1>
		</div>
	</header>
	<main>
		<div class="max-w-7xl mx-auto mt-8 sm:px-6 lg:px-8">
			<div>
				<div class="md:grid md:grid-cols-3 md:gap-6">
					<div class="md:col-span-1">
						<div class="px-4 sm:px-0">
							<h3 class="text-lg font-medium leading-6 text-gray-900">Category</h3>
							<p class="mt-1 text-sm text-gray-600">Create a new cateogry by adding a title and a description</p>
						</div>
					</div>
					<div class="mt-5 md:mt-0 md:col-span-2">
						<form @submit.prevent="form.post(route('products.store'))">
							<div class="shadow sm:rounded-md sm:overflow-hidden">
								<div class="px-4 py-5 bg-white space-y-6 sm:p-6">
									<div class="">
										<label for="product-title" class="block text-sm font-medium text-gray-700">Title</label>
										<div class="mt-1 flex rounded-md shadow-sm">
											<input v-model="form.title" type="text" id="product-title"
											       class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm"
											       :class="{'border-red-500': errors?.title, 'border-gray-300': !errors?.title}"
											       placeholder="Title">
										</div>

									</div>

									<div>
										<label for="product-description"
										       class="block text-sm font-medium text-gray-700">Description</label>
										<div class="mt-1">
											<textarea v-model="form.description" id="product-description" rows="3"
											          :class="{'border-red-500': errors?.description, 'border-gray-300': !errors?.description}"
											          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border rounded-md"
											          placeholder="Description"></textarea>
										</div>
										<p class="mt-2 text-sm text-gray-500">Brief description for the product.</p>
									</div>

									<div>
										<label for="product-category"
										       class="block text-sm font-medium text-gray-700">Category</label>
										<div class="mt-1">
											<select id="product-category" v-model="form.categoryId"
											        :class="{'border-red-500': errors?.categoryId, 'border-gray-300': !errors?.categoryId}"
											        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border rounded-md">
												<option v-for="(category, key) in props.categories" :value="key">{{ category }}</option>
											</select>
										</div>
										<p class="mt-2 text-sm text-gray-500">Brief in category for the product.</p>
									</div>

									<div>
										<label for="product-price"
										       class="block text-sm font-medium text-gray-700">Price</label>
										<div class="mt-1">
											<input type="number" v-model="form.price" id="product-price"
											       :class="{'border-red-500': errors?.price, 'border-gray-300': !errors?.price}"
											       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border rounded-md"
											       placeholder="Price">
										</div>
										<p class="mt-2 text-sm text-gray-500">Brief price for the product.</p>
									</div>

									<div>
										<label for="product-in-stock" class="inline-flex relative items-center cursor-pointer">
											<input type="checkbox" v-model="form.inStock" id="product-in-stock" class="sr-only peer focus:outline-none">
											<div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
											<span class="ml-3 text-sm font-medium text-gray-700">In stock</span>
										</label>
									</div>

									<div>
										<label for="product-image"
										       class="block text-sm font-medium text-gray-700">Image</label>
										<div class="mt-1">
											<input type="file" ref="image" accept="image/*" @change="uploadImage" id="product-image"
											       :class="{'border-red-500': errors?.image, 'border-gray-300': !errors?.image}"
											       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border rounded-md"
											       placeholder="Price" alt="product image">
										</div>
										<p class="mt-2 text-sm text-gray-500">Brief in image for the product.</p>
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
import {useForm} from '@inertiajs/inertia-vue3';
import {ref, onMounted} from 'vue';

const image = ref(null)

const props = defineProps({
	categories: {
		type: Array,
		required: true
	},
	errors: {
		type: Object
	}
})

const form = useForm({
	title: '',
	description: '',
	price: null,
	categoryId: null,
	inStock: 0,
	image: null,
})

const uploadImage = (e) => {
	const imageFile = e.target.files[0];
	const reader = new FileReader();
	reader.readAsDataURL(imageFile);
	// reader.onload = e => {
	// 	form.image = e.target.result;
	// };
	if (image) {
		form.image = image.value.files[0];
	}
}
</script>