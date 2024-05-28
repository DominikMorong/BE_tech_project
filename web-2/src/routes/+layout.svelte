<script lang="ts">
	import '../app.css';
	import Navbar from '$lib/components/Navbar.svelte';
	import { onMount } from 'svelte';
	import axios from 'axios';
	import { API } from '../api';
	import { isLoggedIn } from '$lib/stores';

	onMount(() => getSelf());

	const getSelf = () => {
		const token = localStorage.getItem('token');
		axios
			.get(API.ENDPOINTS.SELF, {
				headers: {
					Authorization: `Bearer ${token}`
				}
			})
			.then((res: any) => {
				console.log(res.data);
				isLoggedIn.set(true);
			})
			.catch((e) => {
				isLoggedIn.set(false);
			});
	};
</script>

<Navbar />
<div class="p-8 ...">
	<slot />
</div>
