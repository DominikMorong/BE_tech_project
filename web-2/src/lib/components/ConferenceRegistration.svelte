<script>
	import axios from 'axios';
	import { Button, Input, Label } from 'flowbite-svelte';
	import { Section } from 'flowbite-svelte-blocks';
	import { API } from '../../api';

	let conferenceRegister = {
		email: ''
	};

	const register = () => {
		axios
			.post(API.ENDPOINTS.REGISTER_CONFERENCE, {
				...conferenceRegister
			})
			.then(() => {
				alert('Success');
				conferenceRegister = {
					email: ''
				};
			})
			.catch((err) => {
				alert('Fail');
				console.log(err);
			});
	};
</script>

<Section name="login">
	<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
		<form class="flex flex-col space-y-6" action="/">
			<h3 class="text-xl font-medium text-gray-900 dark:text-white p-0">
				Register to our conference
			</h3>
			<Label class="space-y-2">
				<span>Your email</span>
				<Input
					type="email"
					name="email"
					placeholder="name@company.com"
					required
					bind:value={conferenceRegister.email}
				/>
			</Label>
			<Button class="w-full1" on:click={register}>Register</Button>
		</form>
	</div>
</Section>
