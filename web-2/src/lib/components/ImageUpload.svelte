<script lang="ts">
	import axios from 'axios';
	import { API } from '../../api';

	export let label = '';
	export let imageUrl;

	let image: Blob;

	const onFileSelected = (e: Event & { currentTarget: EventTarget & HTMLInputElement }) => {
		if (e.target == null) {
			return;
		}
		const htmlImg = e.currentTarget as HTMLInputElement;
		if (htmlImg.files == null) {
			return;
		}
		image = htmlImg.files[0];
	};

	const uploadImage = () => {
		const token = localStorage.getItem('token');

		const formData = new FormData();
		formData.append('image', image);

		axios
			.post(`${API.ENDPOINTS.UPLOAD}`, formData, {
				headers: {
					Authorization: `Bearer ${token}`,
					'Content-Type': 'multipart/form-data'
				}
			})
			.then((response) => {
				console.log(response);
				imageUrl = response.data.imgUrl;
			})
			.catch(() => {});
	};

	const handleChange = (e: Event & { currentTarget: EventTarget & HTMLInputElement }) => {
		onFileSelected(e);
		uploadImage();
	};
</script>

<div>
	<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input"
		>{label}</label
	>
	<input
		class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
		id="file_input"
		type="file"
		accept=".jpg, .jpeg, .png"
		on:change={(e) => handleChange(e)}
	/>
</div>
