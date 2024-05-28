<script lang="ts">
	import ImageUpload from '$lib/components/ImageUpload.svelte';
	import { Button, Input, Label, Modal } from 'flowbite-svelte';

	export let review = {
		text: '',
		img: ''
	};
	export let newReview;
	export let buttonText = '';
	export let isFormModalVissible = false;
	export let reviewId;

	newReview = review;

	let isCreate = !reviewId;
</script>

<Modal bind:open={isFormModalVissible} size="xs" autoclose={false} class="w-full">
	<form class="flex flex-col space-y-6" action="#">
		<h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
			{isCreate ? 'Create New Review' : 'Update Current Review'}
		</h3>
		<Label class="space-y-2">
			<span>Text</span>
			<Input type="text" name="name" placeholder="example" required bind:value={newReview.text} />
		</Label>
		<ImageUpload bind:imageUrl={newReview.img} label="Logo image" />
		<Button type="submit" disabled={newReview.img == ''} class="w-full1" on:click
			>{buttonText}</Button
		>
	</form>
</Modal>
