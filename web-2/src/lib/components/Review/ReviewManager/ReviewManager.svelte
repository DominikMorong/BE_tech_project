<script lang="ts">
	import axios from 'axios';
	import { Table, TableBody, TableHead, TableHeadCell } from 'flowbite-svelte';
	import { onMount } from 'svelte';
	import { API } from '../../../../api';
	import ReviewRow from './ReviewRow.svelte';
	import FloatingActionButton from '$lib/components/FloatingActionButton.svelte';
	import ReviewEditor from './ReviewEditor.svelte';

	let reviews: any[] = [];
	let showAddEditor = false;

	let newReview = {
		text: '',
		img: '',
		time_periods: [] as any
	};

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

	$: newReview, console.log(newReview);

	const createReview = async () => {
		try {
			const token = localStorage.getItem('token');

			const response = await axios.post(
				`${API.ENDPOINTS.REVIEW}`,
				{ ...newReview },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			);

			showAddEditor = false;
			return response.data.data;
		} catch (error) {
			console.error('Error creating review:', error);
		}
	};

	const handleReviewCreation = async () => {
		let createdReview = await createReview();
		console.log(createdReview);
		if (createdReview) {
			addNewReviewLocal(createdReview);
		}
		newReview = {
			text: '',
			img: '',
			time_periods: [] as any
		};
	};

	const addNewReviewLocal = (review: any) => {
		console.log('add');
		reviews = [...reviews, review];
	};
</script>

<Table>
	<TableHead>
		<TableHeadCell>Id</TableHeadCell>
		<TableHeadCell>Text</TableHeadCell>
		<TableHeadCell></TableHeadCell>
		<TableHeadCell></TableHeadCell>
	</TableHead>
	<TableBody tableBodyClass="divide-y">
		{#each reviews as review}
			<ReviewRow bind:review bind:reviews />
		{/each}
	</TableBody>
</Table>

<FloatingActionButton
	text="Add"
	on:click={() => {
		showAddEditor = true;
	}}
/>

<ReviewEditor
	bind:isFormModalVissible={showAddEditor}
	reviewId={null}
	bind:newReview
	buttonText="Create"
	on:click={handleReviewCreation}
/>
