import axios from 'axios';
import type { PageLoad } from './$types';
import { API } from '../../api';

export const load: PageLoad = async () => {
	const getSpeakers = async () => {
		try {
			const res = await axios.get(`${API.ENDPOINTS.SPEAKER}`);

			return res.data.speakers;
		} catch (error) {
			console.error('Error getting speakers:', error);
			return [];
		}
	};
	return {
		speakers: await getSpeakers()
	};
};
