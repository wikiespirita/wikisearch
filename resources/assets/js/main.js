var Vue = require('vue');

Vue.use(require('vue-resource'));

// Importando ElasticSearch
// import elasticsearch from './elasticsearch.js';
import { es_search } from './elasticsearch.js';

new Vue({

	http: {
      root: '/root',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
      }
    },

	el: 'body',

	data: {
		welcome: 'Seja bem vindo ao WikiEspírita!',
		searchText: ''
	},

	methods: {

		search: function() {
			var result = es_search('wikisearch', 'geral', this.searchText);
		}
	}
});
