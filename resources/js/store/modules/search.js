import ApiCaller from '../../core/ApiCaller';

const expand = payload => {
	if (!payload) {
		return '';
	}

	if (payload[0] === '{' || payload[0] === '[') {
		payload = JSON.parse(payload);
	}
	return payload;
};

const compact = payload => {
	if (typeof payload === 'object') {
		payload = JSON.stringify(payload);
	}

	return payload;
};

export default {
	namespaced: true,

	state: {
		params: {},
		urls: {},
		records: {},
		meta: {}
	},

	getters: {
		total: state => group => {
			return (state.meta[group] || {}).total || 0;
		},

		currentPage: state => group => {
			return (state.params[group] || {}).page || 1;
		},

		prevPage: state => group => {
			return (state.meta[group] || {}).prev_page || null;
		},

		nextPage: state => group => {
			return (state.meta[group] || {}).next_page || null;
		},

		lastPage: state => group => {
			return (state.meta[group] || {}).last_page || 1;
		}
	},

	actions: {
		fetch({ state, commit }, group) {
			let { url, method } = state.urls[group];

			return ApiCaller.request(url, method, state.params[group]).then(
				response => {
					commit('SET_RECORDS', {
						group,
						response: response.data
					});

					if (response.data.params !== state.params[group]) {
						commit('STORE', {
							group,
							params: response.data.params
						});
					}
				}
			);
		},

		store({ commit, dispatch }, { group, params }) {
			commit('STORE', { group, params });
			return dispatch('fetch', group);
		},

		remove({ commit }, group) {
			commit('REMOVE', group);
		},

		reset({ state, dispatch }, payload) {
			return dispatch('store', payload).then(() => {
				return state.params[payload.group] || {};
			});
		},

		init({ state, dispatch, getters }, { group, url, method, params }) {
			state.urls = {
				...state.urls,
				...{ [group]: { url, method } }
			};

			let item = window.sessionStorage.getItem(group);

			if (item) {
				state.params = {
					...state.params,
					...{ [group]: expand(item) }
				};

				return dispatch('fetch', group).then(() => {
					return state.params[group] || {};
				});
			}

			return dispatch('store', { group, params }).then(() => {
				return state.params[group] || {};
			});
		}
	},

	mutations: {
		SET_RECORDS(state, { group, response }) {
			state.records = {
				...state.records,
				...{ [group]: response.records }
			};

			state.meta = {
				...state.meta,
				...{ [group]: response.meta }
			};
		},

		STORE(state, { group, params }) {
			state.params = {
				...state.params,
				...{ [group]: params }
			};

			window.sessionStorage.setItem(group, compact(params));
		},

		REMOVE(state, group) {
			delete state.params[group];
			window.sessionStorage.removeItem(group);
		}
	}
};
