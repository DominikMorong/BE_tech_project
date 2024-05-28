<script lang="ts">
	import axios from 'axios';
	import { Button, TableBodyCell, TableBodyRow } from 'flowbite-svelte';
	import { API } from '../../../api';
	import TalkEditor from './TalkEditor.svelte';

	export let talk: any;
	export let talks: any[] = [];

	let showEditor = false;
	let newTalk: any;

	const deleteTalk = async () => {
		const token = localStorage.getItem('token');
		try {
			await axios.delete(`${API.ENDPOINTS.TALK}/${talk.id}`, {
				headers: {
					Authorization: `Bearer ${token}`,
					'Content-Type': 'application/json'
				}
			});
			return true;
		} catch (error) {
			console.error(error);
			return false;
		}
	};

	const handleTalkDelete = async () => {
		let success = await deleteTalk();
		if (success) {
			removeLocalTalk(talk.id);
		}
	};

	const removeLocalTalk = (id: number) => {
		let itemIdx = talks.findIndex((x) => x.id == id);
		talks.splice(itemIdx, 1);
		talks = talks;
	};

	const updateTalk = () => {
		const token = localStorage.getItem('token');
		axios
			.put(
				`${API.ENDPOINTS.TALK}/${talk.id}`,
				{ ...newTalk },
				{
					headers: {
						Authorization: `Bearer ${token}`,
						'Content-Type': 'application/json'
					}
				}
			)
			.then((response) => {
				talk = response.data.data;
				newTalk = talk;
				showEditor = false;
			})
			.catch((error) => {
				console.log(error);
			});
	};

	const handleTalkUpdate = () => {
		updateTalk();
	};
</script>

<TableBodyRow>
	<TableBodyCell>{talk.id}</TableBodyCell>
	<TableBodyCell>{talk.description}</TableBodyCell>
	<TableBodyCell>{talk.descriptionShort}</TableBodyCell>
	<TableBodyCell>{talk?.time_period?.stage.name}</TableBodyCell>
	<TableBodyCell>{`${talk?.time_period?.start} to ${talk?.time_period?.end}`}</TableBodyCell>
	<TableBodyCell>{`${talk?.speaker?.firstName} ${talk?.speaker?.lastName}`}</TableBodyCell>

	<TableBodyCell><Button on:click={handleTalkDelete}>Remove</Button></TableBodyCell>
	<TableBodyCell
		><Button
			on:click={() => {
				showEditor = true;
			}}>Update</Button
		></TableBodyCell
	>
</TableBodyRow>

<TalkEditor
	buttonText="Update"
	bind:newTalk
	{talk}
	talkId
	bind:isFormModalVissible={showEditor}
	on:click={handleTalkUpdate}
/>
