<script lang="ts">
	import axios from 'axios';
	import { Button, TableBodyCell, TableBodyRow } from 'flowbite-svelte';
	import { API } from '../../../api';
	import CustomPageEditor from './CustomPageEditor.svelte';

	export let customPage: any;
	let showEditor = false;
	let updatedPage: any;

	updatedPage = customPage;

	const updatePage = () => {
		const token = localStorage.getItem('token');

		axios
			.put(
				`${API.ENDPOINTS.CUSTOM_PAGES}/${customPage.id}`,
				{ ...customPage },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			)
			.then((response) => {
				console.log(response);
				customPage = response.data.customPage;
				updatedPage = customPage;
				showEditor = false;
			})
			.catch((error) => {
				console.log(error);
			});
	};
</script>

<TableBodyRow>
	<TableBodyCell>{customPage.id}</TableBodyCell>
	<TableBodyCell>{customPage.pageName}</TableBodyCell>
	<TableBodyCell><Button on:click>Remove</Button></TableBodyCell>
	<TableBodyCell
		><Button
			on:click={() => {
				showEditor = true;
			}}>Update</Button
		></TableBodyCell
	>
</TableBodyRow>

<CustomPageEditor
	bind:isFormModalVissible={showEditor}
	bind:addPage={updatedPage}
	pageId={customPage.id}
	content={customPage.content}
	buttonText="Update"
	on:click={updatePage}
/>
