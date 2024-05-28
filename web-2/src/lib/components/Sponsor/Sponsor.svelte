<script>
	import { Card } from 'flowbite-svelte';
	import { API } from '../../../api';

	export let sponsor;
</script>

<a href={sponsor.url} target="_blank">
	<div class="space-y-4 !h-48">
		<Card img={`${API.ENDPOINTS.BASE_IMG}${sponsor.img}`}>
			<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
				{sponsor.name}
			</h5>
		</Card>
	</div>
</a>
