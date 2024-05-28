<script lang="ts">
	import axios from 'axios';
	import { Button, TableBodyCell, TableBodyRow } from 'flowbite-svelte';
	import { API } from '../../../../api';
	import ReviewEditor from './ReviewEditor.svelte';

	export let review: any;
	export let reviews: any[];
	let newReview: any;

	let showEditor = false;

	const deleteReview = async () => {
		const token = localStorage.getItem('token');
		try {
			await axios.delete(`${API.ENDPOINTS.REVIEW}/${review.id}`, {
				headers: {
					Authorization: `Bearer ${token}`,
					'Content-Type': 'application/json'
				}
			});
			return true;
		} catch (error) {
			console.error(error);
			return false;
		}
	};

	const handleReviewDelete = async () => {
		let success = await deleteReview();
		if (success) {
			removeLocalReview(review.id);
		}
	};

	const removeLocalReview = (id: number) => {
		let itemIdx = reviews.findIndex((x) => x.id == id);
		reviews.splice(itemIdx, 1);
		reviews = reviews;
	};

	const updateReview = () => {
		const token = localStorage.getItem('token');
		axios
			.put(
				`${API.ENDPOINTS.REVIEW}/${review.id}`,
				{ ...newReview },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			)
			.then((response) => {
				review = response.data.data;
				newReview = review;
				showEditor = false;
			})
			.catch((error) => {
				console.log(error);
			});
	};

	const handleReviewUpdate = () => {
		updateReview();
	};

	$: review, console.log(review);
</script>

<TableBodyRow>
	<TableBodyCell>{review.id}</TableBodyCell>
	<TableBodyCell>{review.text}</TableBodyCell>
	<TableBodyCell><Button on:click={handleReviewDelete}>Remove</Button></TableBodyCell>
	<TableBodyCell
		><Button
			on:click={() => {
				showEditor = true;
			}}>Update</Button
		></TableBodyCell
	>
</TableBodyRow>

<ReviewEditor
	bind:isFormModalVissible={showEditor}
	reviewId={review.id}
	bind:newReview
	{review}
	buttonText="Update"
	on:click={handleReviewUpdate}
/>
