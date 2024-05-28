<script lang="ts">
	import { Table, TableBody, TableHead, TableHeadCell } from 'flowbite-svelte';
	import FloatingActionButton from '$lib/components/FloatingActionButton.svelte';
	import CustomPageEditor from './CustomPageEditor.svelte';
	import { onMount } from 'svelte';
	import CustomPageRow from './CustomPageRow.svelte';
	import axios from 'axios';
	import { API } from '../../../api';

	let showAddEditor = false;
	let addPage = {
		pageName: '',
		content: ''
	};

	let customPages: any[] = [];

	onMount(() => getCustomPages());

	const getCustomPages = () => {
		const token = localStorage.getItem('token');

		axios
			.get(`${API.ENDPOINTS.CUSTOM_PAGES}`, {
				headers: {
					Authorization: `Bearer ${token}`
				}
			})
			.then((res) => {
				console.log(res.data.pages);
				customPages = res.data.pages;
				console.log(res);
			});
	};

	const createPage = async () => {
		try {
			const token = localStorage.getItem('token');

			const response = await axios.post(
				`${API.ENDPOINTS.CUSTOM_PAGES}`,
				{ ...addPage },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			);

			showAddEditor = false;
			return response.data.customPage;
		} catch (error) {
			console.error('Error creating custom page:', error);
		}
	};

	const handlePageCreatinon = async () => {
		let newPage = await createPage();
		console.log(newPage);
		if (newPage) {
			addNewPageLocal(newPage);
		}
		addPage = {
			pageName: '',
			content: ''
		};
	};

	const addNewPageLocal = (page: any) => {
		console.log('add');
		customPages = [...customPages, page];
	};

	const removePage = async (id: number) => {
		const success = await deletePage(id);
		if (success) {
			removeLocalPage(id);
		}
	};

	const deletePage = async (id: number) => {
		try {
			const token = localStorage.getItem('token');

			const res = await axios.delete(`${API.ENDPOINTS.CUSTOM_PAGES}/${id}`, {
				headers: {
					Authorization: `Bearer ${token}`
				}
			});

			return res.status === 204;
		} catch (error) {
			console.error('Error deleting custom page:', error);
			return false;
		}
	};

	const removeLocalPage = (id: number) => {
		let itemIdx = customPages.findIndex((x) => x.id == id);
		customPages.splice(itemIdx, 1);
		customPages = customPages;
	};
</script>

<Table>
	<TableHead>
		<TableHeadCell>Id</TableHeadCell>
		<TableHeadCell>Name</TableHeadCell>
		<TableHeadCell></TableHeadCell>
		<TableHeadCell></TableHeadCell>
	</TableHead>
	<TableBody tableBodyClass="divide-y">
		{#each customPages as customPage}
			<CustomPageRow
				bind:customPage
				on:click={() => {
					removePage(customPage.id);
				}}
			/>
		{/each}
	</TableBody>
</Table>
<CustomPageEditor
	buttonText="Create"
	isFormModalVissible={showAddEditor}
	on:click={handlePageCreatinon}
	bind:addPage
/>
<FloatingActionButton
	text="Add"
	on:click={() => {
		showAddEditor = true;
	}}
/>
