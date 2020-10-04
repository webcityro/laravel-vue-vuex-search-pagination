import Vue from 'vue';
import store from './store/index';

import SearchForm from './components/Search/SearchForm';
import SearchResults from './components/Search/SearchResults';
import SearchPagination from './components/Search/SearchPagination';

import TimesCircle from './components/Icons/TimesCircle';
import SelectAngle from './components/Form/SelectAngle';

const app = new Vue({
	store,
	el: '#app',
	components: {
		SearchForm,
		SearchResults,
		SearchPagination,
		TimesCircle,
		SelectAngle
	}
});
