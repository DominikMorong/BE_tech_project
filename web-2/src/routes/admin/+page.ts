import axios from 'axios';
import type { PageLoad } from './$types';
import { API } from '../../api';

export const ssr = false;

export const load: PageLoad = async () => {
	const getSponsors = async () => {
		try {
			const res = await axios.get(`${API.ENDPOINTS.SPONSOR}`);

			return res.data.sponsors;
		} catch (error) {
			console.error('Error getting sponsors:', error);
			return [];
		}
	};
	return {
		sponsors: await getSponsors()
	};
};
