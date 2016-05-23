var Vue = require('vue');

Vue.use(require('vue-resource'));

import ES from './elasticsearch.js';

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
			alert('Alert')
		}
	}

});
