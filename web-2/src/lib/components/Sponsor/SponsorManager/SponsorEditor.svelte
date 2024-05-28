<script lang="ts">
	import { Button, Modal, Label, Input } from 'flowbite-svelte';
	import ImageUpload from '$lib/components/ImageUpload.svelte';

	export let sponsor: any = {
		name: '',
		url: '',
		imageUrl: ''
	};

	export let isFormModalVissible = false;
	export let buttonText = '';

	export let sponsorId: number | null = null;

	let isCreate = !sponsorId;
</script>

<Modal bind:open={isFormModalVissible} size="xs" autoclose={false} class="w-full">
	<form class="flex flex-col space-y-6" action="#">
		<h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
			{isCreate ? 'Create New Sponsor' : 'Update Current Sponsor'}
		</h3>
		<Label class="space-y-2">
			<span>Name</span>
			<Input type="text" name="name" placeholder="example" required bind:value={sponsor.name} />
		</Label>
		<Label class="space-y-2">
			<span>Website</span>
			<Input
				type="text"
				name="website"
				placeholder="www.example.com"
				required
				bind:value={sponsor.url}
			/>
		</Label>
		<ImageUpload bind:imageUrl={sponsor.imageUrl} label="Logo image" />
		<Button class="w-full1" on:click disabled={sponsor.imageUrl == ''}>{buttonText}</Button>
	</form>
</Modal>
