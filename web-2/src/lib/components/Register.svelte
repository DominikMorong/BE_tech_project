<script lang="ts">
	import axios from 'axios';
	import { API } from '../../api';
	import { isLoggedIn } from '$lib/stores';
	import { Register, Section } from 'flowbite-svelte-blocks';
	import { Button, Input, Label } from 'flowbite-svelte';

	let userRegister: any = {
		email: '',
		password: '',
		name: ''
	};

	const register = () => {
		axios
			.post(API.ENDPOINTS.REGISTER, {
				...userRegister
			})
			.then((res) => {
				if (res.status === 201) {
					localStorage.setItem('token', res.data.token);
					isLoggedIn.set(true);
					console.log('Token set');
				}
				console.log(res);
			})
			.catch((err) => {
				console.log(err);
			});
	};
</script>

<Section name="login">
	<Register>
		<div class="p-6 space-y-4 md:space-y-6 sm:p-8">
			<form class="flex flex-col space-y-6" action="/">
				<h3 class="text-xl font-medium text-gray-900 dark:text-white p-0">Register</h3>
				<Label class="space-y-2">
					<span>Your username</span>
					<Input
						type="text"
						name="text"
						placeholder="example"
						required
						bind:value={userRegister.name}
					/>
				</Label>
				<Label class="space-y-2">
					<span>Your email</span>
					<Input
						type="email"
						name="email"
						placeholder="name@company.com"
						required
						bind:value={userRegister.email}
					/>
				</Label>
				<Label class="space-y-2">
					<span>Your password</span>
					<Input
						type="password"
						name="password"
						placeholder="•••••"
						required
						bind:value={userRegister.password}
					/>
				</Label>
				<Button class="w-full1" on:click={register}>Register</Button>
			</form>
		</div>
	</Register>
</Section>
