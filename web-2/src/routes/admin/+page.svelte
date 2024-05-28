<script lang="ts">
	import SponsorManager from '$lib/components/Sponsor/SponsorManager/SponsorManager.svelte';
	import CustomPageManager from '$lib/components/CustomPage/CustomPageManager.svelte';
	import { Tabs, TabItem } from 'flowbite-svelte';
	import { isLoggedIn } from '$lib/stores';
	import SpeakerManager from '$lib/components/Speaker/SpeakerManager/SpeakerManager.svelte';
	import Login from '$lib/components/Login.svelte';
	import StageManager from '$lib/components/Stage/StageManager/StageManager.svelte';
	import Register from '$lib/components/Register.svelte';
	import TalkManager from '$lib/components/Talk/TalkManager.svelte';
	import GalleryManager from '$lib/components/Gallery/GalleryManager/GalleryManager.svelte';
	import ReviewManager from '$lib/components/Review/ReviewManager/ReviewManager.svelte';
	import RegistrationManager from '$lib/components/RegistrationManager.svelte';
</script>

{#if $isLoggedIn}
	<Tabs>
		<TabItem open title="Speakers">
			<SpeakerManager />
		</TabItem>
		<TabItem title="Stages">
			<StageManager />
		</TabItem>
		<TabItem title="Talks">
			<TalkManager />
		</TabItem>
		<TabItem title="Sponsors">
			<SponsorManager />
		</TabItem>
		<TabItem title="Custom Pages">
			<CustomPageManager />
		</TabItem>
		<TabItem title="Gallery">
			<GalleryManager />
		</TabItem>
		<TabItem title="Review">
			<ReviewManager />
		</TabItem>
		<TabItem title="Attendee">
			<RegistrationManager />
		</TabItem>
	</Tabs>
{:else}
	<Login />
	<div class="mt-8"></div>
	<Register />
{/if}
