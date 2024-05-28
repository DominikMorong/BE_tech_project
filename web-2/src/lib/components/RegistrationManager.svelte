<script lang="ts">
	import axios from 'axios';
	import {
		Table,
		TableBody,
		TableBodyCell,
		TableBodyRow,
		TableHead,
		TableHeadCell
	} from 'flowbite-svelte';
	import { API } from '../../api';
	import { onMount } from 'svelte';

	let registered: any[] = [];

	onMount(() => {
		getRegistered();
	});

	const getRegistered = () => {
		const token = localStorage.getItem('token');

		axios
			.get(API.ENDPOINTS.REGISTER_CONFERENCE, {
				headers: {
					Authorization: `Bearer ${token}`,
					'Content-Type': 'application/json'
				}
			})
			.then((res) => {
				registered = res.data.data;
			})
			.catch((err) => {
				console.log(err);
			});
	};
</script>

<Table>
	<TableHead>
		<TableHeadCell>Id</TableHeadCell>
		<TableHeadCell>Email</TableHeadCell>
	</TableHead>
	<TableBody tableBodyClass="divide-y">
		{#each registered as item}
			<TableBodyRow>
				<TableBodyCell>{item.id}</TableBodyCell>
				<TableBodyCell>{item.email}</TableBodyCell>
			</TableBodyRow>
		{/each}
	</TableBody>
</Table>
