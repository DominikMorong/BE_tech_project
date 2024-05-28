<script lang="ts">
	import { Button, TableBodyCell, TableBodyRow } from 'flowbite-svelte';
	import SponsorEditor from './SponsorEditor.svelte';
	import axios from 'axios';
	import { API } from '../../../../api';

	export let sponsor: any;
	let showEditor = false;

	let updatedSponsor: any;

	updatedSponsor = sponsor;

	const updateSponsor = () => {
		const token = localStorage.getItem('token');

		axios
			.put(
				`${API.ENDPOINTS.SPONSOR}/${sponsor.id}`,
				{ ...sponsor },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			)
			.then((response) => {
				console.log(response);
				sponsor = response.data.sponsor;
				updatedSponsor = sponsor;
				showEditor = false;
			})
			.catch((error) => {
				console.log(error);
			});
	};
</script>

<TableBodyRow>
	<TableBodyCell>{sponsor.id}</TableBodyCell>
	<TableBodyCell>{sponsor.name}</TableBodyCell>
	<TableBodyCell><a href={sponsor.url}>{sponsor.url}</a></TableBodyCell>
	<TableBodyCell><Button on:click>Remove</Button></TableBodyCell>
	<TableBodyCell
		><Button
			on:click={() => {
				showEditor = true;
			}}>Update</Button
		></TableBodyCell
	>
</TableBodyRow>

<SponsorEditor
	bind:isFormModalVissible={showEditor}
	bind:sponsor={updatedSponsor}
	sponsorId={sponsor.id}
	buttonText="Update"
	on:click={updateSponsor}
/>
