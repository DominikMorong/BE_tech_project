<script lang="ts">
	import axios from 'axios';
	import { A, Avatar, Modal, TableBodyCell, TableBodyRow } from 'flowbite-svelte';
	import { API } from '../../api';
	import { onMount } from 'svelte';

	export let talkId;

	let talk: any;

	onMount(() => getTalk());

	let clickOutsideModal = false;

	const getTalk = () => {
		axios
			.get(`${API.ENDPOINTS.TALK}/${talkId}`, {})
			.then((res) => {
				talk = res.data.data;
			})
			.catch((err) => {
				console.log(err);
			});
	};
</script>

{#if talk}
	<TableBodyRow>
		<TableBodyCell>{talk.descriptionShort}</TableBodyCell>
		<TableBodyCell>{`${talk.time_period.start} to ${talk.time_period.end}`}</TableBodyCell>
		<TableBodyCell>{`${talk.speaker.firstName} to ${talk.speaker.lastName}`}</TableBodyCell>
		<TableBodyCell>
			<A
				on:click={() => {
					clickOutsideModal = true;
				}}>Show more</A
			>
		</TableBodyCell>
	</TableBodyRow>
	<Modal bind:open={clickOutsideModal} autoclose outsideclose title={talk.descriptionShort}>
		<div class="flex">
			<Avatar
				src={`${API.ENDPOINTS.BASE_IMG}${talk.speaker.imgUrl}`}
				size="xl"
				rounded
				class="mr-4"
			/>
			<div>
				<p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
					{talk.description}
				</p>
				<p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
					{`${talk.time_period.start} to ${talk.time_period.end}`}
				</p>
			</div>
		</div>
		<p>{`${talk.speaker.firstName} ${talk.speaker.lastName}`}</p>
		<div class="flex !mt-4">
			<a href={talk.speaker.xFormerlyKnownAsTwitterProfile}
				><div class="h-4 w-4 !mt-2 mr-2">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-30 w-30" viewBox="0 0 512 512"
						><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path
							d="M459.4 151.7c.3 4.5 .3 9.1 .3 13.6 0 138.7-105.6 298.6-298.6 298.6-59.5 0-114.7-17.2-161.1-47.1 8.4 1 16.6 1.3 25.3 1.3 49.1 0 94.2-16.6 130.3-44.8-46.1-1-84.8-31.2-98.1-72.8 6.5 1 13 1.6 19.8 1.6 9.4 0 18.8-1.3 27.6-3.6-48.1-9.7-84.1-52-84.1-103v-1.3c14 7.8 30.2 12.7 47.4 13.3-28.3-18.8-46.8-51-46.8-87.4 0-19.5 5.2-37.4 14.3-53 51.7 63.7 129.3 105.3 216.4 109.8-1.6-7.8-2.6-15.9-2.6-24 0-57.8 46.8-104.9 104.9-104.9 30.2 0 57.5 12.7 76.7 33.1 23.7-4.5 46.5-13.3 66.6-25.3-7.8 24.4-24.4 44.8-46.1 57.8 21.1-2.3 41.6-8.1 60.4-16.2-14.3 20.8-32.2 39.3-52.6 54.3z"
						/></svg
					>
				</div></a
			>
			<a href={talk.speaker.facebookProfile}
				><div class="h-4 w-4 !mt-2 mr-2">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
						><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path
							d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"
						/></svg
					>
				</div></a
			>
			<a href={talk.speaker.personalPage}
				><div class="h-4 w-4 !mt-2 mr-2">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
						><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path
							d="M130.2 127.5C130.4 127.6 130.3 127.6 130.2 127.5V127.5zM481.6 172.9C471 147.4 449.6 119.9 432.7 111.2C446.4 138.1 454.4 165 457.4 185.2C457.4 185.3 457.4 185.4 457.5 185.6C429.9 116.8 383.1 89.1 344.9 28.7C329.9 5.1 334 3.5 331.8 4.1L331.7 4.2C285 30.1 256.4 82.5 249.1 126.9C232.5 127.8 216.2 131.9 201.2 139C199.8 139.6 198.7 140.7 198.1 142C197.4 143.4 197.2 144.9 197.5 146.3C197.7 147.2 198.1 148 198.6 148.6C199.1 149.3 199.8 149.9 200.5 150.3C201.3 150.7 202.1 151 203 151.1C203.8 151.1 204.7 151 205.5 150.8L206 150.6C221.5 143.3 238.4 139.4 255.5 139.2C318.4 138.7 352.7 183.3 363.2 201.5C350.2 192.4 326.8 183.3 304.3 187.2C392.1 231.1 368.5 381.8 247 376.4C187.5 373.8 149.9 325.5 146.4 285.6C146.4 285.6 157.7 243.7 227 243.7C234.5 243.7 256 222.8 256.4 216.7C256.3 214.7 213.8 197.8 197.3 181.5C188.4 172.8 184.2 168.6 180.5 165.5C178.5 163.8 176.4 162.2 174.2 160.7C168.6 141.2 168.4 120.6 173.5 101.1C148.5 112.5 129 130.5 114.8 146.4H114.7C105 134.2 105.7 93.8 106.3 85.3C106.1 84.8 99 89 98.1 89.7C89.5 95.7 81.6 102.6 74.3 110.1C58 126.7 30.1 160.2 18.8 211.3C14.2 231.7 12 255.7 12 263.6C12 398.3 121.2 507.5 255.9 507.5C376.6 507.5 478.9 420.3 496.4 304.9C507.9 228.2 481.6 173.8 481.6 172.9z"
						/></svg
					>
				</div></a
			>
		</div>
	</Modal>
{/if}
