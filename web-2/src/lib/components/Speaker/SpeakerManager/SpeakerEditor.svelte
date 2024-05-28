<script lang="ts">
	import ImageUpload from '$lib/components/ImageUpload.svelte';
	import { Label, Modal, Input, Button } from 'flowbite-svelte';

	export let speaker: any = {
		firstName: '',
		lastName: '',
		imgUrl: '',
		description: '',
		descriptionShort: '',
		xFormerlyKnownAsTwitterProfile: '',
		facebookProfile: '',
		personalPage: ''
	};

	export let isFormModalVissible = false;
	export let buttonText = '';

	export let speakerId: number | null = null;

	let isCreate = !speakerId;
</script>

<Modal bind:open={isFormModalVissible} size="xs" autoclose={false} class="w-full">
	<form class="flex flex-col space-y-6" action="#">
		<h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
			{isCreate ? 'Create New Speaker' : 'Update Current Speaker'}
		</h3>
		<Label class="space-y-2">
			<span>First name</span>
			<Input type="text" name="name" placeholder="Joe" required bind:value={speaker.firstName} />
		</Label>
		<Label class="space-y-2">
			<span>Last name</span>
			<Input type="text" name="name" placeholder="Biden" required bind:value={speaker.lastName} />
		</Label>
		<Label class="space-y-2">
			<span>Description</span>
			<Input type="text" name="name" placeholder="..." required bind:value={speaker.description} />
		</Label>
		<Label class="space-y-2">
			<span>Short Description</span>
			<Input
				type="text"
				name="name"
				placeholder="..."
				required
				bind:value={speaker.descriptionShort}
			/>
		</Label>
		<Label class="space-y-2">
			<span>Twitter</span>
			<Input
				type="text"
				name="name"
				placeholder="twitter.com/example"
				required
				bind:value={speaker.xFormerlyKnownAsTwitterProfile}
			/>
		</Label>
		<Label class="space-y-2">
			<span>Facebook</span>
			<Input
				type="text"
				name="name"
				placeholder="www.facebook.com/example"
				required
				bind:value={speaker.facebookProfile}
			/>
		</Label>
		<Label class="space-y-2">
			<span>Personal Site</span>
			<Input
				type="text"
				name="name"
				placeholder="www.example.com"
				required
				bind:value={speaker.personalPage}
			/>
		</Label>
		<ImageUpload bind:imageUrl={speaker.imgUrl} label="Picture" />
		<Button class="w-full1" disabled={speaker.imgUrl == ''} on:click>{buttonText}</Button>
	</form>
</Modal>
