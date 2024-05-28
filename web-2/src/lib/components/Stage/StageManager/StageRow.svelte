<script lang="ts">
	import axios from 'axios';
	import { Button, TableBodyCell, TableBodyRow } from 'flowbite-svelte';
	import { API } from '../../../../api';
	import StageEditor from './StageEditor.svelte';

	export let stage: any;
	export let stages: any[] = [];

	let showEditor = false;
	let newStage: any;

	let timePeriodsCopy = [...stage.time_periods];

	const addTimePeriod = async (timePeriod: any) => {
		const token = localStorage.getItem('token');
		axios
			.post(
				`${API.ENDPOINTS.STAGE}/${stage.id}/timePeriods`,
				{ ...timePeriod },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			)
			.then(() => {})
			.catch((err) => {
				console.log(err);
			});
	};

	const updateTimePeriod = (timePeriod: any, id: any) => {
		const token = localStorage.getItem('token');
		axios
			.put(
				`${API.ENDPOINTS.TIME_PERIOD}/${id}`,
				{ ...timePeriod },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			)
			.then(() => {})
			.catch((err) => {
				console.log(err);
			});
	};

	const deleteStage = async () => {
		const token = localStorage.getItem('token');
		try {
			await axios.delete(`${API.ENDPOINTS.STAGE}/${stage.id}`, {
				headers: {
					Authorization: `Bearer ${token}`,
					'Content-Type': 'application/json'
				}
			});
			return true;
		} catch (error) {
			console.error(error);
			return false;
		}
	};

	const handleStageDelete = async () => {
		let success = await deleteStage();
		if (success) {
			removeLocalStage(stage.id);
		}
	};

	const removeLocalStage = (id: number) => {
		let itemIdx = stages.findIndex((x) => x.id == id);
		stages.splice(itemIdx, 1);
		stages = stages;
	};

	const handleTimePeriods = (oldData: any[], newData: any[]) => {
		let toRemove = oldData.filter((item: any) => !newData.includes(item));
		toRemove.forEach((element: { id: number }) => {
			removeTimePeriod(element.id);
		});
		oldData = [...newData];
		newData.forEach((element) => {
			if (element.id) {
				updateTimePeriod(element, element.id);
			} else {
				addTimePeriod(element);
			}
		});
	};

	const removeTimePeriod = (id: number) => {
		const token = localStorage.getItem('token');
		axios
			.delete(`${API.ENDPOINTS.STAGE}/${stage.id}/${id}`, {
				headers: {
					Authorization: `Bearer ${token}`,
					'Content-Type': 'application/json'
				}
			})
			.then(() => {});
	};

	const updateStage = () => {
		const token = localStorage.getItem('token');
		console.log(stage.time_periods);
		axios
			.put(
				`${API.ENDPOINTS.STAGE}/${stage.id}`,
				{ ...newStage },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			)
			.then((response) => {
				stage = response.data.data;
				newStage = stage;
				showEditor = false;
			})
			.catch((error) => {
				console.log(error);
			});
	};

	const handleStageUpdate = () => {
		let oldTimePeriods = timePeriodsCopy;
		let newTimePeriods = newStage.time_periods;
		handleTimePeriods(oldTimePeriods, newTimePeriods);
		updateStage();
	};

	$: stage, console.log(stage);
</script>

<TableBodyRow>
	<TableBodyCell>{stage.id}</TableBodyCell>
	<TableBodyCell>{stage.name}</TableBodyCell>
	<TableBodyCell>{stage.date}</TableBodyCell>
	<TableBodyCell><Button on:click={handleStageDelete}>Remove</Button></TableBodyCell>
	<TableBodyCell
		><Button
			on:click={() => {
				showEditor = true;
			}}>Update</Button
		></TableBodyCell
	>
</TableBodyRow>
<StageEditor
	bind:isFormModalVissible={showEditor}
	buttonText="Update"
	bind:newStage
	{stage}
	on:click={handleStageUpdate}
	stageId={stage.id}
/>
