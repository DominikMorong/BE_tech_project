<script lang="ts">
	import ImageUpload from '$lib/components/ImageUpload.svelte';
	import axios from 'axios';
	import { Button, Label, Modal, Select } from 'flowbite-svelte';
	import { API } from '../../../../api';
	import { onMount } from 'svelte';

	export let isFormModalVissible = false;

	let gallery = {
		imgUrl: '',
		gallery_category_id: '-1'
	};

	onMount(() => {
		getCategories();
	});

	const getCategories = () => {
		axios
			.get(API.ENDPOINTS.GALLER_CATEGORY, {})
			.then((res) => {
				const data = res.data.data;
				categories = data.map((item: { id: any; name: any }) => ({
					value: item.id,
					name: item.name
				}));
				console.log(data);
			})
			.catch((err) => {
				console.log(err);
			});
	};

	const addPhoto = () => {
		const token = localStorage.getItem('token');

		axios
			.post(
				API.ENDPOINTS.GALLERY,
				{
					...gallery
				},
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			)
			.then(() => {
				isFormModalVissible = false;
			})
			.catch((err) => {
				console.log(err);
			});
	};

	let selected: any;

	let categories: any[] = [];

	$: selected, console.log(selected);
</script>

<Modal bind:open={isFormModalVissible} size="xs" autoclose={false} class="w-full">
	<form class="flex flex-col space-y-6" action="#">
		<h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
			Add new picture to gallery
		</h3>
		<Label>
			Select an category
			<Select class="mt-2" items={categories} bind:value={gallery.gallery_category_id} />
		</Label>
		<ImageUpload bind:imageUrl={gallery.imgUrl} label="Picture" />

		<Button type="submit" disabled={gallery.imgUrl == ''} class="w-full1" on:click={addPhoto}
			>Add</Button
		>
	</form>
</Modal>
