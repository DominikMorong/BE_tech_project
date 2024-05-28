<script lang="ts">
	import axios from 'axios';
	import { API } from '../../../../api';
	import { onMount } from 'svelte';
	import FloatingActionButton from '$lib/components/FloatingActionButton.svelte';
	import SpeakerEditor from './SpeakerEditor.svelte';
	import { Table, TableBody, TableHead, TableHeadCell } from 'flowbite-svelte';
	import SpeakerRow from './SpeakerRow.svelte';

	let speakers: any[] = [];
	let showAddEditor = false;

	let addSpeaker: any = {
		firstName: '',
		lastName: '',
		imgUrl: '',
		description: '',
		descriptionShort: '',
		xFormerlyKnownAsTwitterProfile: '',
		facebookProfile: '',
		personalPage: ''
	};

	onMount(() => {
		getSpeakers();
	});

	const getSpeakers = async () => {
		const token = localStorage.getItem('token');

		axios
			.get(`${API.ENDPOINTS.SPEAKER}`, {
				headers: {
					Authorization: `Bearer ${token}`
				}
			})
			.then((res) => {
				speakers = res.data.speakers;
				console.log(res.data.speakers);
			});
	};

	const createSpeaker = async () => {
		try {
			const token = localStorage.getItem('token');

			const response = await axios.post(
				`${API.ENDPOINTS.SPEAKER}`,
				{ ...addSpeaker },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			);

			showAddEditor = false;
			return response.data.speaker;
		} catch (error) {
			console.error('Error creating custom page:', error);
		}
	};

	const handleSpeakerCreation = async () => {
		let newSpeaker = await createSpeaker();
		console.log(newSpeaker);
		if (newSpeaker) {
			addNewSpeakerLocal(newSpeaker);
		}
		addSpeaker = {
			firstName: '',
			lastName: '',
			imgUrl: '',
			description: '',
			descriptionShort: '',
			xFormerlyKnownAsTwitterProfile: '',
			facebookProfile: '',
			personalPage: ''
		};
	};

	const addNewSpeakerLocal = (speaker: any) => {
		console.log('add');
		speakers = [...speakers, speaker];
	};

	const removeSpeaker = async (id: number) => {
		const success = await deleteSpeaker(id);
		if (success) {
			removeLocalSpeaker(id);
		}
	};

	const deleteSpeaker = async (id: number) => {
		try {
			const token = localStorage.getItem('token');

			const res = await axios.delete(`${API.ENDPOINTS.SPEAKER}/${id}`, {
				headers: {
					Authorization: `Bearer ${token}`
				}
			});

			return res.status === 204;
		} catch (error) {
			console.error('Error deleting speaker:', error);
			return false;
		}
	};

	const removeLocalSpeaker = (id: number) => {
		let itemIdx = speakers.findIndex((x) => x.id == id);
		speakers.splice(itemIdx, 1);
		speakers = speakers;
	};
</script>

<!-- <CustomPageEditor
	buttonText="Create"
	isFormModalVissible={showAddEditor}
	on:click={handlePageCreatinon}
	bind:addPage
/> -->
<Table>
	<TableHead>
		<TableHeadCell>Id</TableHeadCell>
		<TableHeadCell>First Name</TableHeadCell>
		<TableHeadCell>LastName</TableHeadCell>
		<TableHeadCell>Description</TableHeadCell>
		<TableHeadCell>Short Description</TableHeadCell>
		<TableHeadCell></TableHeadCell>
		<TableHeadCell></TableHeadCell>
	</TableHead>
	<TableBody tableBodyClass="divide-y">
		{#each speakers as speaker}
			<SpeakerRow
				{speaker}
				on:click={() => {
					removeSpeaker(speaker.id);
				}}
			/>
			<!-- <SponsorRow bind:sponsor on:click={() => removeSponsor(sponsor.id)} /> -->
		{/each}
	</TableBody>
</Table>
<SpeakerEditor
	isFormModalVissible={showAddEditor}
	buttonText="Create"
	on:click={handleSpeakerCreation}
	bind:speaker={addSpeaker}
/>
<FloatingActionButton
	text="Add"
	on:click={() => {
		showAddEditor = true;
	}}
/>
