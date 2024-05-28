<script lang="ts">
	import axios from 'axios';
	import { Button, Input, Label } from 'flowbite-svelte';
	import { API } from '../../../../api';
	import GalleryEditor from './GalleryEditor.svelte';

	let categoryName = '';

	let showAddEditor = false;

	const addCateogry = () => {
		const token = localStorage.getItem('token');

		axios
			.post(
				`${API.ENDPOINTS.GALLER_CATEGORY}`,
				{
					name: categoryName
				},
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			)
			.then(() => {
				categoryName = '';
			})
			.catch((err) => {
				console.log(err);
				alert(err.response.data.message);
			});
	};
</script>

<Label class="space-y-2">
	<span>Add category</span>
	<Input type="text" name="newCategory" required bind:value={categoryName} />
</Label>
<Button pill={true} outline={true} color="green" class="!p-2 mt-4" size="xl" on:click={addCateogry}>
	Add category
</Button>
<Button
	pill={true}
	outline={true}
	color="green"
	class="!p-2 mt-4"
	size="xl"
	on:click={() => {
		showAddEditor = true;
	}}
>
	Add photo
</Button>
{#if showAddEditor}
	<GalleryEditor bind:isFormModalVissible={showAddEditor} />
{/if}
