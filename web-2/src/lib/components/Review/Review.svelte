<script lang="ts">
	import axios from 'axios';
	import { Avatar, Card } from 'flowbite-svelte';
	import { onMount } from 'svelte';
	import { API } from '../../../api';

	let reviews: any[] = [];

	onMount(() => getReviews());

	const getReviews = () => {
		axios
			.get(API.ENDPOINTS.REVIEW, {})
			.then((res) => {
				reviews = res.data.data;
			})
			.catch((err) => {
				console.log(err);
			});
	};
</script>

<div class="grid grid-cols-3 gap-1">
	{#each reviews as review}
		<Card padding="md">
			<div class="flex flex-col items-center pb-4">
				<Avatar size="lg" src={`${API.ENDPOINTS.BASE_IMG}${review.img}`} />
				<span class="text-sm text-gray-500 dark:text-gray-400">{review.text}</span>
			</div>
		</Card>
	{/each}
</div>
