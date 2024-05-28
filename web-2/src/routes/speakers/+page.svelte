<script>
	import Speaker from '$lib/components/Speaker/Speaker.svelte';

	export let data;
</script>

<div class="grid grid-cols-3 gap-1">
	{#await data.speakers}
		<p>...waiting</p>
	{:then speakersData}
		{#each speakersData as speaker}
			<div class="col-span-1">
				<Speaker {speaker} />
			</div>
		{/each}
	{:catch error}
		<p style="color: red">{error.message}</p>
	{/await}
</div>
