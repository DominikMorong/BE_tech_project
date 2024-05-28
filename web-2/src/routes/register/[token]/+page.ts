import axios from 'axios';
import type { PageLoad } from './$types';
import { API } from '../../../api';

export const ssr = false;

export const load: PageLoad = async ({ params }) => {
	const getCustomPages = async () => {
		const slug = params.token;
		const res = await axios.delete(`${API.ENDPOINTS.REGISTER_CONFERENCE}/${slug}`);
		return res.data;
	};
	return {
		data: await getCustomPages()
	};
};
