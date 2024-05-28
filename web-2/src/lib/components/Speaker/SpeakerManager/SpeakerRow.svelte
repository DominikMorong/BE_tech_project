<script lang="ts">
	import { Button, TableBodyCell, TableBodyRow } from 'flowbite-svelte';
	import axios from 'axios';
	import { API } from '../../../../api';
	import SpeakerEditor from './SpeakerEditor.svelte';

	export let speaker: any;
	let showEditor = false;

	let updatedSpeaker: any;

	updatedSpeaker = speaker;

	const updateSpeaker = () => {
		const token = localStorage.getItem('token');

		axios
			.put(
				`${API.ENDPOINTS.SPEAKER}/${speaker.id}`,
				{ ...speaker },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			)
			.then((response) => {
				speaker = response.data.speaker;
				updatedSpeaker = speaker;
				showEditor = false;
			})
			.catch((error) => {
				console.log(error);
			});
	};
</script>

<TableBodyRow>
	<TableBodyCell>{speaker.id}</TableBodyCell>
	<TableBodyCell>{speaker.firstName}</TableBodyCell>
	<TableBodyCell>{speaker.lastName}</TableBodyCell>
	<TableBodyCell>{speaker.description.slice(0, 10) + '...'}</TableBodyCell>
	<TableBodyCell>{speaker.descriptionShort.slice(0, 10) + '...'}</TableBodyCell>

	<TableBodyCell><Button on:click>Remove</Button></TableBodyCell>
	<TableBodyCell
		><Button
			on:click={() => {
				showEditor = true;
			}}>Update</Button
		></TableBodyCell
	>
</TableBodyRow>

<SpeakerEditor
	bind:isFormModalVissible={showEditor}
	speakerId={speaker.id}
	buttonText="Update"
	bind:speaker={updatedSpeaker}
	on:click={updateSpeaker}
/>

<!-- <SponsorEditor
	bind:isFormModalVissible={showEditor}
	bind:sponsor={updatedSponsor}
	sponsorId={sponsor.id}
	buttonText="Update"
	on:click={updateSponsor}
/> -->
