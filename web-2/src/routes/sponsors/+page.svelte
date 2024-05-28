<script lang="ts">
	import Sponsor from '$lib/components/Sponsor/Sponsor.svelte';

	export let data;
</script>

<div class="grid grid-cols-3 gap-1">
	{#await data.sponsors}
		<p>...waiting</p>
	{:then sponsorsData}
		{#each sponsorsData as sponsor}
			<div class="col-span-1">
				<Sponsor {sponsor} />
			</div>
		{/each}
	{:catch error}
		<p style="color: red">{error.message}</p>
	{/await}
</div>
