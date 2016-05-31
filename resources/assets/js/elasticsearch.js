var elasticsearch = require('elasticsearch');

var client = new elasticsearch.Client({
  // host: 'wikinotes.com.br:9200'
  host: 'wikiespirita.com.br:8200'
  // ,log: 'trace'
});

function es_search (myIndex, myType, searchText) {
	// return client.search({
	client.search({
		index: myIndex,
		type: myType,
		// size: 5, //Quantidade de retorno...
		body: {

			// Versão danet que funciona tb
			// query: {
   //              //match: {_all: searchInput}
   //              "term": {
   //                  "_all" : searchText
   //              }
   //          },
   //          highlight: {
	  //           // "require_field_match": true,
	  //           fields: {
	  //               _all: {
	  //                   "pre_tags": [
	  //                       "<b>"
	  //                   ],
	  //                   "post_tags": [
	  //                       "</b>"
	  //                   ]
	  //               }
	  //           }
   //          }
   //          
   //          // Minha versão
			fields: {},
			query: {
				match: {
					file_content: searchText
				}
			},
			highlight: {
				// require_field_match: true,
				fields: {
					// _all: {}
					// file_content: []
					file_content: { force_source: true }
					// file_content: {
		   //              "_all": {
		   //                  "pre_tags": [
		   //                      "<b>"
		   //                  ],
		   //                  "post_tags": [
		   //                      "</b>"
		   //                  ]
		   //              }
	                // }
				}
			}
		}
	}).then(function (resp) {
	  // return hits = resp.hits.hits;
	  // return hits = resp.hits.total;
	  // return hits = resp.took;
	  // console.log(resp.hits.hits);
	  console.log(resp.hits.hits);
	}, function (err) {
	// console.trace(err.message);
	// console.log(err);
    console.log('erro');
});
}

export { es_search }

// client.search({
//   index: 'wikisearch',
//   type: 'geral',
//   body: {
//   	fields: {},
//     query: {
//       match: {
//         file_content: 'jesus'
//       }
//     }
//     ,hightlight: {
//       fields: {
//         file_content: 'jesus'
//       }
//     }
//   }
// }).then(function (resp) {
//     var hits = resp.hits.hits;
// }, function (err) {
//     console.trace(err.message);
// });

 // $this->params = [
 //            'index' => $this->index,
 //            'type'  => $this->type,
 //            'body'  => [
 //                'fields'    => [],
 //                'query'     => [
 //                    'match' => [
 //                        'file.content'      => $search_text
 //                    ]
 //                ],
 //                'highlight' => [
 //                    'fields'    => [
 //                        'file.content'  => new \stdClass()
 //                    ]
 //                ]
 //            ]

// client.ping({
//   requestTimeout: 30000

//   // undocumented params are appended to the query string
//   // hello: "wikisearch"
// }, function (error) {
//   if (error) {
//     console.error('elasticsearch cluster is down!');
//   } else {
//     console.log('All is well');
//   }
// });