<script lang="ts">
	import axios from 'axios';
	import { API } from '../../api';
	import { Section, Register } from 'flowbite-svelte-blocks';
	import { Button, Label, Input } from 'flowbite-svelte';
	import { isLoggedIn } from '$lib/stores';

	let userLogin: any = {
		email: '',
		password: ''
	};

	const login = () => {
		axios
			.post(API.ENDPOINTS.LOGIN, {
				...userLogin
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
				<h3 class="text-xl font-medium text-gray-900 dark:text-white p-0">Login</h3>
				<Label class="space-y-2">
					<span>Your email</span>
					<Input
						type="email"
						name="email"
						placeholder="name@company.com"
						required
						bind:value={userLogin.email}
					/>
				</Label>
				<Label class="space-y-2">
					<span>Your password</span>
					<Input
						type="password"
						name="password"
						placeholder="•••••"
						required
						bind:value={userLogin.password}
					/>
				</Label>
				<Button class="w-full1" on:click={login}>Login</Button>
			</form>
		</div>
	</Register>
</Section>
