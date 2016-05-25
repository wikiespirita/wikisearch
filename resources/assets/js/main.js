var Vue = require('vue');

Vue.use(require('vue-resource'));

// import ES from './elasticsearch.js';

import { search } from './elasticsearch.js';

new Vue({

	http: {
      root: '/root',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
      }
    },

	el: 'body',

	data: {
		welcome: 'Seja bem vindo ao WikiEspírita!'
	},

	methods: {

		search: function() {
			var result = search('wikisearch', 'geral', 'Jesus');
		}

		// search: function() {
		// 	// alert('Alert');
		// 	var self = this;
		// 	// client.search(function(resp){
   //          	self.searchResults = resp.hits.hits
   //         	});
            // self.client.search({
			// 	index: 'wikisearch',
			// 	type: 'geral',
			// 	body: {
			// 		fields: {},
			// 		query: {
			// 			match: {
			// 			file_content: 'jesus'
			// 			}
			// 		}
			// 	}
			// }).then(function (resp) {
			// 	var hits = resp.hits.hits;
			// }, function (err) {
			// 	console.trace(err.message);
			// });
	}
});
