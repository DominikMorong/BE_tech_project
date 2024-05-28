<script lang="ts">
	import axios from 'axios';
	import { API } from '../../api.js';
	import { onMount } from 'svelte';

	export let data;

	onMount(() => getCurrentPage());

	const getCurrentPage = () => {
		axios
			.get(`${API.ENDPOINTS.CUSTOM_PAGES}/${data.slug}`, {})
			.then(async (res: any) => {
				content = res.data.page.content;
				console.log(content);
			})
			.catch((e) => {
				console.log(e);
			});
	};

	$: data, getCurrentPage();

	let content = '<p></p>';
</script>

{@html content}
