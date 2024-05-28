<script lang="ts">
	import axios from 'axios';
	import FloatingActionButton from '../FloatingActionButton.svelte';
	import { Table, TableBody, TableHead, TableHeadCell } from 'flowbite-svelte';
	import { API } from '../../../api';
	import { onMount } from 'svelte';
	import TalkRow from './TalkRow.svelte';
	import TalkEditor from './TalkEditor.svelte';

	let talks: any[] = [];
	let showAddEditor = false;

	let newTalk: any = {
		description: '',
		descriptionShort: '',
		speaker_id: '',
		time_period_id: ''
	};

	onMount(() => getTalks());

	const getTalks = () => {
		axios
			.get(API.ENDPOINTS.TALK, {})
			.then((res) => {
				talks = res.data.data;
			})
			.catch((err) => {
				console.log(err);
			});
	};

	const createTalk = async () => {
		try {
			const token = localStorage.getItem('token');

			const response = await axios.post(
				`${API.ENDPOINTS.TALK}`,
				{ ...newTalk },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			);

			showAddEditor = false;
			return response.data.data;
		} catch (error) {
			console.error('Error creating stage:', error);
		}
	};

	const handleTalkCreation = async () => {
		let createdTalk = await createTalk();
		console.log(createdTalk);
		if (createdTalk) {
			addNewTalkLocal(createdTalk);
		}
		newTalk = {
			description: '',
			descriptionShort: '',
			speaker_id: '',
			time_period_id: ''
		};
	};

	const addNewTalkLocal = (talk: any) => {
		console.log('add');
		talks = [...talks, talk];
	};
</script>

<Table>
	<TableHead>
		<TableHeadCell>Id</TableHeadCell>
		<TableHeadCell>Description</TableHeadCell>
		<TableHeadCell>Short Description</TableHeadCell>
		<TableHeadCell>Stage</TableHeadCell>
		<TableHeadCell>Time</TableHeadCell>
		<TableHeadCell>Speaker</TableHeadCell>
		<TableHeadCell></TableHeadCell>
		<TableHeadCell></TableHeadCell>
	</TableHead>
	<TableBody tableBodyClass="divide-y">
		{#each talks as talk}
			<TalkRow bind:talk bind:talks />
		{/each}
	</TableBody>
</Table>

<FloatingActionButton
	text="Add"
	on:click={() => {
		showAddEditor = true;
	}}
/>
{#if showAddEditor}
	<TalkEditor
		bind:isFormModalVissible={showAddEditor}
		bind:newTalk
		buttonText="Create"
		talkId={null}
		on:click={handleTalkCreation}
	/>
{/if}
