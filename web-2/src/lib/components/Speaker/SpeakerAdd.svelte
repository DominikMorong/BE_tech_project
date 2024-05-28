<script lang="ts">
	import axios from 'axios';
	import { Card } from 'flowbite-svelte';
	import { API } from '../../../api';

	let isSponsorFormVisible = false;
	let fileInput: any;

	let sponsor: any = {
		name: '',
		url: '',
		image: new Blob()
	};

	const onFileSelected = (e: Event & { currentTarget: EventTarget & HTMLInputElement }) => {
		if (e.target == null) {
			return;
		}
		const htmlImg = e.currentTarget as HTMLInputElement;
		if (htmlImg.files == null) {
			return;
		}
		sponsor.image = htmlImg.files[0];
	};

	const postSponsor = () => {
		const formData = new FormData();
		formData.append('image', sponsor.image);
		formData.append('name', sponsor.name);
		formData.append('url', sponsor.url);

		const token = localStorage.getItem('token');

		axios
			.post(`${API.ENDPOINTS.SPONSOR}`, formData, {
				headers: {
					Authorization: `Bearer ${token}`,
					'Content-Type': 'multipart/form-data'
				}
			})
			.then((response) => {
				console.log(response);
				isSponsorFormVisible = false;
			})
			.catch(() => {});
	};
</script>

<Card>
	<div class="flex items-center justify-center w-full">
		{#if !isSponsorFormVisible}
			<button
				on:click={() => {
					isSponsorFormVisible = true;
				}}
				class="material-symbols-outlined mb-2 text-9xl font-bold tracking-tight text-gray-900 dark:text-white"
			>
				add_circle
			</button>
		{:else}
			<div>
				<div>
					<label for="company" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
						>Name</label
					>
					<input
						type="text"
						id="company"
						class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
						placeholder="Example"
						required
						bind:value={sponsor.name}
					/>
				</div>
				<div>
					<label for="website" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
						>Website URL</label
					>
					<input
						type="url"
						id="website"
						class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
						placeholder="example.com"
						required
						bind:value={sponsor.url}
					/>
				</div>
				<div>
					<label
						class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
						for="file_input">Sponsor Logo</label
					>
					<input
						class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
						id="file_input"
						type="file"
						accept=".jpg, .jpeg, .png"
						on:change={(e) => onFileSelected(e)}
						bind:this={fileInput}
					/>
				</div>
				<button
					type="submit"
					class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full mt-8"
					on:click={postSponsor}>Submit</button
				>
			</div>
		{/if}
	</div>
</Card>
