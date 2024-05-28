<script lang="ts">
	import axios from 'axios';
	import { Button, Input, Label, Modal, Select } from 'flowbite-svelte';
	import { API } from '../../../api';
	import { onMount } from 'svelte';

	export let talk = {
		description: '',
		descriptionShort: '',
		speaker_id: '',
		time_period_id: ''
	};
	export let newTalk;
	export let buttonText = '';
	export let isFormModalVissible = false;
	export let talkId;

	newTalk = talk;
	// newTalk.time_period_id = talk.time_period.id != null ? talk.time_period.id : talk.time_period_id;

	let isCreate = !talkId;

	let speakers: any[] = [];

	let stageTimePeriods: any[] = [];

	onMount(() => {
		getSpeakers();
		getStages();
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
				const data = res.data.speakers;
				speakers = data.map((item: { id: number; firstName: string; lastName: string }) => ({
					value: item.id,
					name: `${item.lastName} ${item.firstName}`
				}));
			});
	};

	const getStages = () => {
		axios
			.get(`${API.ENDPOINTS.STAGE}?filter=true`, {})
			.then((res) => {
				const data = res.data.data;
				data.forEach((element: any) => {
					element.time_periods.forEach((inner: any) => {
						stageTimePeriods.push({
							value: inner.id,
							name: `${element.name} - ${inner.start} to ${inner.end}`
						});
					});
				});
				if (talkId) {
					stageTimePeriods.push({
						// @ts-ignore
						value: talk?.time_period.id,
						// @ts-ignore
						name: `${talk?.time_period?.stage.name} - ${talk?.time_period?.start} to ${talk?.time_period?.end}`
					});
				}
				stageTimePeriods = stageTimePeriods;
				console.log(data);
			})
			.catch((err) => {
				console.log(err);
			});
	};
	$: stageTimePeriods, console.log(stageTimePeriods);
</script>

<Modal bind:open={isFormModalVissible} size="xs" autoclose={false} class="w-full">
	<form class="flex flex-col space-y-6" action="#">
		<h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
			{isCreate ? 'Create New Talk' : 'Update Current Talk'}
		</h3>
		<Label class="space-y-2">
			<span>Description</span>
			<Input type="text" name="name" placeholder="..." required bind:value={newTalk.description} />
		</Label>
		<Label class="space-y-2">
			<span>Short Description</span>
			<Input
				type="text"
				name="name"
				placeholder="..."
				required
				bind:value={newTalk.descriptionShort}
			/>
		</Label>
		<Label>
			Select a speaker
			<Select class="mt-2" items={speakers} bind:value={newTalk.speaker_id} />
		</Label>
		<Label>
			Select a time period
			<Select class="mt-2" items={stageTimePeriods} bind:value={newTalk.time_period_id} />
		</Label>
		<Button type="submit" class="w-full1" on:click>{buttonText}</Button>
	</form>
</Modal>
