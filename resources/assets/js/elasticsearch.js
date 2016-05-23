var elasticsearch = require('elasticsearch');

var client = new elasticsearch.Client({
  host: 'wikinotes.com.br:9200'
  ,log: 'trace'
});

client.search({
  index: 'wikisearch',
  type: 'geral',
  body: {
  	fields: {},
    query: {
      match: {
        file_content: 'jesus'
      }
    }
    ,hightlight: {
      fields: {
        file_content: 'jesus'
      }
    }
  }
}).then(function (resp) {
    var hits = resp.hits.hits;
}, function (err) {
    console.trace(err.message);
});

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