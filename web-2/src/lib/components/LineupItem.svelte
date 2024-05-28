<script lang="ts">
	import { Table, TableBody, TableHead, TableHeadCell } from 'flowbite-svelte';
	import LineupRow from './LineupRow.svelte';

	export let timePeriods: any[] = [];
</script>

<Table>
	<TableHead>
		<TableHeadCell>Short Description</TableHeadCell>
		<TableHeadCell>Time</TableHeadCell>
		<TableHeadCell>Speaker</TableHeadCell>
	</TableHead>
	<TableBody tableBodyClass="divide-y">
		{#each timePeriods as timePeriod}
			{#if timePeriod.talk_id != null}
				<LineupRow talkId={timePeriod.talk_id} />
			{/if}
		{/each}
	</TableBody>
</Table>
