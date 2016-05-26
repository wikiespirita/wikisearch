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
		initialMode: true,
		searchText: ''
	},

	methods: {

		searchNow: function() {
			var result = es_search('wikisearch', 'geral', this.searchText);
		},

		changeView: function() {
			if ( this.initialMode ) {
				this.initialMode = false;
				// Muda a visão para pesquisa (igual Google)
			}			
		}
	}
});
