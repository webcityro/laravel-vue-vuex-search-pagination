import axios from 'axios';

let headers = {
	'X-Requested-with': 'XMLhttpRequest',
	'Content-type': 'application/json',
	Accept: 'application/json'
};

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
	headers['X-CSRF-TOKEN'] = token.content;
}

const client = axios.create({ headers });

export default {
	request(url, method = 'get', payload = {}, config = {}) {
		let data = {
			url,
			method: method.toLowerCase(),
			params: {},
			data: {}
		};
		data[
			['post', 'put', 'patch'].includes(data.method) ? 'data' : 'params'
		] = payload;

		return client.request({ ...data, ...config });
	}
};
