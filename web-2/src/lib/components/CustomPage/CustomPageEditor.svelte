<script lang="ts">
	import { Button, Modal, Label, Input } from 'flowbite-svelte';
	import TextEditor from '../TextEditor.svelte';

	export let isFormModalVissible = false;
	export let buttonText = '';

	export let pageId: number | null = null;
	export let content = '';

	export let addPage;

	let isCreate = !pageId;
</script>

<Modal bind:open={isFormModalVissible} size="xs" autoclose={false} class="w-full">
	<form class="flex flex-col space-y-6" action="#">
		<h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
			{isCreate ? 'Create New Page' : 'Update Current Page'}
		</h3>
		<Label class="space-y-2">
			<span>Name</span>
			<Input type="text" name="name" placeholder="example" required bind:value={addPage.pageName} />
		</Label>
		<TextEditor {content} bind:updatedContent={addPage.content} />
		<Button class="w-full1" on:click>{buttonText}</Button>
	</form>
</Modal>
