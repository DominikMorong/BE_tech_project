<script lang="ts">
	import { Button } from 'flowbite-svelte';

	export let text: string;
</script>

<div class="fixed bottom-4 right-4">
	<Button on:click>{text}</Button>
</div>
