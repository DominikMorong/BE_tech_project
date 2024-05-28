<script lang="ts">
	import axios from 'axios';
	import { onMount } from 'svelte';
	import { API } from '../../../api';
	import { Gallery, Label, Select } from 'flowbite-svelte';

	onMount(() => {
		getCategories();
	});

	let images: any[] = [];

	const getImages = () => {
		axios
			.get(`${API.ENDPOINTS.GALLERY}/${selected}`, {})
			.then((res) => {
				const data = res.data.data;
				console.log(data);
				images = data.map((item: { imgUrl: any }) => ({
					src: `${API.ENDPOINTS.BASE_IMG}${item.imgUrl}`,
					alt: ''
				}));
			})
			.catch((err) => {
				images = [];
				console.log(err);
			});
	};

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
				if (categories.length >= 1) {
					selected = categories[0].value;
				}
			})
			.catch((err) => {
				console.log(err);
			});
	};

	let categories: any[] = [];

	$: selected, selected ? getImages() : {};

	let selected: any;
</script>

<Label>
	Select an category
	<Select class="mt-2" items={categories} bind:value={selected} />
</Label>
<div class="m-4"></div>
<Gallery items={images} class="gap-4 grid-cols-2 md:grid-cols-3" />
