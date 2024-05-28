<script lang="ts">
	import { Table, TableBody, TableHead, TableHeadCell } from 'flowbite-svelte';
	import SponsorRow from './SponsorRow.svelte';
	import axios from 'axios';
	import { API } from '../../../../api';
	import FloatingActionButton from '$lib/components/FloatingActionButton.svelte';
	import SponsorEditor from './SponsorEditor.svelte';
	import { onMount } from 'svelte';

	export let sponsors: any[] = [];

	let addSponsor: any = {
		name: '',
		url: '',
		imageUrl: ''
	};

	let showAddEditor = false;

	onMount(() => getSponsors());

	const getSponsors = () => {
		const token = localStorage.getItem('token');

		axios
			.get(`${API.ENDPOINTS.SPONSOR}`, {
				headers: {
					Authorization: `Bearer ${token}`
				}
			})
			.then((res) => {
				sponsors = res.data.sponsors;
				console.log(res);
			});
	};

	const removeSponsor = async (id: number) => {
		const success = await deleteSponsor(id);
		if (success) {
			removeLocalSponsor(id);
		}
	};

	const deleteSponsor = async (id: number) => {
		try {
			const token = localStorage.getItem('token');

			const res = await axios.delete(`${API.ENDPOINTS.SPONSOR}/${id}`, {
				headers: {
					Authorization: `Bearer ${token}`
				}
			});

			return res.status === 204;
		} catch (error) {
			console.error('Error deleting sponsor:', error);
			return false;
		}
	};

	const removeLocalSponsor = (id: number) => {
		let itemIdx = sponsors.findIndex((x) => x.id == id);
		sponsors.splice(itemIdx, 1);
		sponsors = sponsors;
	};

	const createSponsor = async () => {
		try {
			const token = localStorage.getItem('token');

			const response = await axios.post(
				`${API.ENDPOINTS.SPONSOR}`,
				{ ...addSponsor },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			);

			showAddEditor = false;
			return response.data.sponsor;
		} catch (error) {
			console.error('Error creating sponsor:', error);
		}
	};

	const handleSponsorCreation = async () => {
		let newSponsor = await createSponsor();
		console.log(newSponsor);
		if (newSponsor) {
			addNewSponsorLocal(newSponsor);
		}
		addSponsor = {
			name: '',
			url: '',
			imageUrl: ''
		};
	};

	const addNewSponsorLocal = (sponsor: any) => {
		console.log('add');
		sponsors = [...sponsors, sponsor];
	};
</script>

<Table>
	<TableHead>
		<TableHeadCell>Id</TableHeadCell>
		<TableHeadCell>Name</TableHeadCell>
		<TableHeadCell>URL</TableHeadCell>
		<TableHeadCell></TableHeadCell>
		<TableHeadCell></TableHeadCell>
	</TableHead>
	<TableBody tableBodyClass="divide-y">
		{#each sponsors as sponsor}
			<SponsorRow bind:sponsor on:click={() => removeSponsor(sponsor.id)} />
		{/each}
	</TableBody>
</Table>
<SponsorEditor
	bind:isFormModalVissible={showAddEditor}
	bind:sponsor={addSponsor}
	on:click={handleSponsorCreation}
	buttonText="Create"
/>
<FloatingActionButton
	text="Add"
	on:click={() => {
		showAddEditor = true;
	}}
/>
