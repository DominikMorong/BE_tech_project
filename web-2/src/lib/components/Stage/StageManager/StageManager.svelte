<script lang="ts">
	import axios from 'axios';
	import { Table, TableBody, TableHead, TableHeadCell } from 'flowbite-svelte';
	import { API } from '../../../../api';
	import { onMount } from 'svelte';
	import StageRow from './StageRow.svelte';
	import FloatingActionButton from '$lib/components/FloatingActionButton.svelte';
	import StageEditor from './StageEditor.svelte';

	let stages: any[] = [];
	let showAddEditor = false;

	let newStage = {
		name: '',
		date: '',
		time_periods: [] as any
	};

	onMount(() => getStages());

	const getStages = () => {
		axios
			.get(API.ENDPOINTS.STAGE, {})
			.then((res) => {
				stages = res.data.data;
			})
			.catch((err) => {
				console.log(err);
			});
	};

	$: newStage, console.log(newStage);

	const createStage = async () => {
		try {
			const token = localStorage.getItem('token');

			const response = await axios.post(
				`${API.ENDPOINTS.STAGE}`,
				{ ...newStage },
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

	const handleStageCreation = async () => {
		let createdStage = await createStage();
		console.log(createdStage);
		if (createdStage) {
			addNewStageLocal(createdStage);
		}
		newStage = {
			name: '',
			date: '',
			time_periods: [] as any
		};
	};

	const addNewStageLocal = (stage: any) => {
		console.log('add');
		stages = [...stages, stage];
	};
</script>

<Table>
	<TableHead>
		<TableHeadCell>Id</TableHeadCell>
		<TableHeadCell>Name</TableHeadCell>
		<TableHeadCell>Date</TableHeadCell>
		<TableHeadCell></TableHeadCell>
		<TableHeadCell></TableHeadCell>
	</TableHead>
	<TableBody tableBodyClass="divide-y">
		{#each stages as stage}
			<StageRow bind:stage bind:stages />
		{/each}
	</TableBody>
</Table>

<StageEditor
	bind:isFormModalVissible={showAddEditor}
	buttonText="Create"
	bind:newStage
	on:click={handleStageCreation}
	stageId={null}
/>

<FloatingActionButton
	text="Add"
	on:click={() => {
		showAddEditor = true;
	}}
/>
