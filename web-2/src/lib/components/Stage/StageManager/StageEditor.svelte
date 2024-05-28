<script lang="ts">
	import { Button, Hr, Input, Label, Modal } from 'flowbite-svelte';

	export let stage = {
		name: '',
		date: '',
		time_periods: [] as any
	};
	export let newStage;
	export let buttonText = '';
	export let isFormModalVissible = false;
	export let stageId;

	newStage = stage;

	let isCreate = !stageId;

	const addTimePeriod = () => {
		newStage.time_periods = [...newStage.time_periods, { start: '', end: '' }];
	};

	const removeTimePeriod = (index: number) => {
		newStage.time_periods.splice(index, 1);
		newStage.time_periods = [...newStage.time_periods];
	};
</script>

<Modal bind:open={isFormModalVissible} size="xs" autoclose={false} class="w-full">
	<form class="flex flex-col space-y-6" action="#">
		<h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
			{isCreate ? 'Create New Stage' : 'Update Current Stage'}
		</h3>
		<Label class="space-y-2">
			<span>Name</span>
			<Input type="text" name="name" placeholder="example" required bind:value={newStage.name} />
		</Label>
		<Label class="space-y-2">
			<span>Date</span>
			<Input type="date" name="date" required bind:value={newStage.date} />
		</Label>
		{#each newStage.time_periods as timePeriod, index}
			<Hr />
			<Label class="space-y-2">
				<span>Start time</span>
				<Input type="time" step="1" name="startTime" required bind:value={timePeriod.start} />
			</Label>
			<Label class="space-y-2">
				<span>end time</span>
				<Input type="time" step="1" name="endTime" required bind:value={timePeriod.end} />
			</Label>
			<Button
				pill={true}
				outline={true}
				color="red"
				class="!p-2"
				size="xl"
				on:click={() => removeTimePeriod(index)}
			>
				x
			</Button>
		{/each}
		<Button
			pill={true}
			outline={true}
			color="green"
			class="!p-2"
			size="xl"
			on:click={addTimePeriod}
		>
			+
		</Button>
		<Button type="submit" class="w-full1" on:click>{buttonText}</Button>
	</form>
</Modal>
