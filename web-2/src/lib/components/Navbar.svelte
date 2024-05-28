<script lang="ts">
	import { page } from '$app/stores';
	import { Navbar, NavBrand, NavLi, NavUl, NavHamburger } from 'flowbite-svelte';
	$: activeUrl = $page.url.pathname;
	import { onMount } from 'svelte';
	import axios from 'axios';
	import { API } from '../../api';

	onMount(() => getCustomPages());

	let customPages: any[] = [];

	const getCustomPages = () => {
		const token = localStorage.getItem('token');

		axios
			.get(`${API.ENDPOINTS.CUSTOM_PAGES}`, {
				headers: {
					Authorization: `Bearer ${token}`
				}
			})
			.then((res) => {
				console.log(res.data.pages);
				customPages = res.data.pages;
				console.log(res);
			});
	};
</script>

<Navbar>
	<NavBrand href="/">
		<span class="self-center whitespace-nowrap text-xl font-semibold dark:text-white">CMS</span>
	</NavBrand>
	<NavHamburger />
	<NavUl {activeUrl}>
		<NavLi href="/">Home</NavLi>
		<NavLi href="/speakers">Speakers</NavLi>
		<NavLi href="/lineup">Lineup</NavLi>
		<NavLi href="/sponsors">Sponsors</NavLi>
		{#await customPages}
			<p>...waiting</p>
		{:then customPagesData}
			{#each customPagesData as page}
				<NavLi href={`/${page.pageName.toLowerCase()}`}>{page.pageName}</NavLi>
			{/each}
		{/await}
		<NavLi href="/register">Register</NavLi>
		<NavLi href="/admin">Admin</NavLi>
	</NavUl>
</Navbar>
