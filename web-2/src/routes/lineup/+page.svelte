<script lang="ts">
	import axios from 'axios';
	import { TabItem, Tabs } from 'flowbite-svelte';
	import { onMount } from 'svelte';
	import { API } from '../../api';
	import LineupItem from '$lib/components/LineupItem.svelte';

	onMount(() => getStages());

	let stages: any[] = [];

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
</script>

<Tabs>
	{#each stages as stage, index}
		<TabItem open={index === 0} title={stage.name}>
			<LineupItem timePeriods={stage?.time_periods} />
		</TabItem>
	{/each}
</Tabs>
