<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

// Storage
use Illuminate\Support\Facades\Storage;

// ElasticSearch
use Elasticsearch\ClientBuilder;
use Monolog\Logger;

class IndexingController extends Controller
{
    // ElasticSearch Settings
    protected $host = ['wikiespirita.com.br:8200'];
    protected $client;
    protected $logger;
    protected $index = 'wikisearch';
    protected $type = 'geral';
    protected $params = [];
    protected $curlParams = [];
    protected $handler;

    // ElasticSearch Files
    protected $disk = 'local';
    protected $log_path = 'elasticsearch/log/';
    protected $log_file = 'elastic.log';
    protected $file_path = 'elasticsearch/files/';

    public function __construct($host = null, $log = true, $logfile = null)
    {
        if ( ! empty($host) ) {
            $this->host = $host;
        }
        if ( empty($logfile) ) {
            $logfile = storage_path('app/' . $this->log_path . $this->log_file);
        } else {
            $logfile = storage_path('app/' . $this->log_path . $logfile);
        }
        if ( $log ){
            $this->disk = Storage::disk($this->disk);
            if ( ! $this->disk->exists($this->log_path) ) {
                $this->disk->put($this->log_path, '');
            }
//            $this->logger = ClientBuilder::defaultLogger($logfile, Logger::ERROR);
            $this->logger = ClientBuilder::defaultLogger($logfile);
        }
        $this->fixTimeout();
        // print_r($this->curlParams);
        echo '<br>';
//        $this->handler = ClientBuilder::multiHandler($this->curlParams);
//        $this->handler = ClientBuilder::singleHandler();
        $this->handler = ClientBuilder::defaultHandler($this->curlParams);
        $this->client = ClientBuilder::create()
                    ->setHosts($this->host)
                    ->setLogger($this->logger)
                    ->setHandler($this->handler)
                    ->build();
    }
    
    public function index()
    {
        echo 'Working! <br><br>';
        
        $this->index = 'geral';
        
//        $this->destroy();
//        $this->create();
        
        /**
         * Mapping
         */
//        $this->map();
//        die();
        /**
         * Indexing
         */
        // Manual
//        $this->indexFile('pdf2.pdf');
//        $this->indexFile('Emmanuel.pdf');
//        $this->indexFile('Sexo_e_Destino.pdf');
//        $this->indexFile('Paulo_e_Estevao.pdf');
//        $this->indexFile('Natal_Sabina.pdf');
//        $this->indexFile('Oficina.pdf');
//        $this->indexFile('biblia1_1.pdf');
//        $this->indexFile('biblia1_2.pdf');
//        $this->indexFile('biblia2.pdf');
//        $this->indexFile('biblia3.pdf');

// // Este arquivo é muito grande. Necessário corrigir o timeout do Curl
//        $this->indexFile('Biblia.pdf');

        // Todo o folder
        $pdf_folder = 'pdf100/';
        $dir = storage_path('app/' . $this->file_path . $pdf_folder);
        $pdf_files = scandir($dir);
        foreach ($pdf_files as $filename)
        {
            if ( $filename <> "." && $filename <> "..") {
//                $this->indexFile( $pdf_folder . $filename);
            }
        }
        
        /**
         * Searching
         */
        $results = $this->search('Jesus');
//        $results = $this->search('Divina');
//        $results = $this->search('aborrecimentos');
//        $results = $this->search('habituara');
//        $results = $this->search('alfaiates');
//        $results = $this->search('depressa');
//        $results = $this->search('cooperadores');
        $qtd = $results['hits']['total'];
        echo 'Quantidade de Livros: ' . $qtd . '<br><br>';
        
        $hightlights = $results['hits']['hits'];
        foreach ($hightlights as $value) {
            $hightlight = $value['highlight']['file.content'];
            foreach ($hightlight as $value) {
                echo $value;
                echo '<br>';
                echo '<hr>';
            }
        }
        
//        print_r($hightlights);

//        echo $results['hits']['hits'][0]['highlight']['file.content'][0];
//        $results['hits']['hits']);
        echo '<hr>';
//        print_r($results);
    }
    
    /**
     * Cria um índice
     * 
     * @param string $index
     */
    public function create($index = null)
    {
        if ( ! empty($index) ) {
            $this->index = $index;
        }
        $this->params = [
            'index' => $this->index
//            ,'client' => [
//                'timeout'           => 0,        // ten second timeout
//                'connect_timeout'   => 0
//            ],            
        ];
        if ( ! $this->client->indices()->exists($this->params) ) {
            try {
                $this->client->indices()->create($this->params);
                echo $this->index . ' criado. <br>';
            } catch (Exception $ex) {
                throw new Exception ('Ups! Tente novamente ou contate o suporte.');
            }
        }        
    }

    /**
     * Deleta um índice
     * 
     * @param string $index
     */
    public function destroy($index = null)
    {
        if ( ! empty($index) ) {
            $this->index = $index;
        }
        $this->params = [
            'index' => $this->index
        ];
        if ( $this->client->indices()->exists($this->params) ) {
            try {
                $this->client->indices()->delete($this->params);
                echo $this->index . ' deletado. <br>';
            } catch (Exception $ex) {
                throw new Exception ('Ups! Tente novamente ou contate o suporte.');
            }
        }        
    }

    public function map($params = null, $index = null, $type = null)
    {
        if ( ! empty($params) ) {
            $this->params = $params;
        } else {
            if ( $index ) {
                $this->index = $index;
            }
            $this->params = [
                'index' => $this->index,
                'type'  => $this->type,
                'body'  => [
                    $this->type => [
                        'properties'    => [
                            'file'      => [
                                'type'      => 'attachment',
                                'fields'    => [
                                    'content'   => [
                                        'type'          => 'string',
                                        'term_vector'   => 'with_positions_offsets',
                                        'store'         => true
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }
        try {
            $this->client->indices()->putMapping($this->params);
            echo 'Mapa enviado. <br>';
        } catch (Exception $ex) {
            throw new Exception ('Ups! Tente novamente ou contate o suporte.');
        }        
    }
    
    public function indexFile($file = null, $type = null)
    {
        if ( ! empty($file) ){
            $file = storage_path('app/' . $this->file_path . $file);
        } else {
            $file = storage_path('app/' . $this->file_path . 'pdf2.pdf');
        }
        if ( is_file($file) ) {
            $this->params = [
                'index' => $this->index,
                'type'  => $this->type,
                'timeout' => '5m',
                'client' => [
                    'timeout'           => 0,        // ten second timeout
                    'connect_timeout'   => 0
                ],            
                'body'  => [
                    'file'    => [
                        '_content_type'     => 'application/pdf',
                        '_name'             => $file,
                        '_language'         => 'en',
                        '_indexed_chars'    => -1,
                        '_content'          => base64_encode(file_get_contents($file))
                    ]
                ]
            ];
            try {
                $this->client->index($this->params);
                echo 'O arquivo "' . $file . '" foi indexado. <br>';
            } catch (Exception $ex) {
                throw new Exception ('Ups! Tente novamente ou contate o suporte.');
            }
        } else {
            return false;
        }
    }

    public function search($text)
    {
        if ( empty($text) ){
            return false;
        }
        $search_text = $text;
        $this->params = [
            'index' => $this->index,
            'type'  => $this->type,
            'body'  => [
                'fields'    => [],
                'query'     => [
                    'match' => [
                        'file.content'      => $search_text
                    ]
                ],
                'highlight' => [
                    'fields'    => [
                        'file.content'  => new \stdClass()
                    ]
                ]
            ]
        ];
        return $this->client->search($this->params);
    }
    
    /**
     * Função desativada... @TODO - DELETAR?
     * 
     * @param type $key
     * @param type $value
     * @param type $sub
     * @param type $new
     */
    private function makeParams($key, $value, $sub = false, $new = false)
    {
        if ( $new ) {
            $this->params = [];
        }
        switch ($sub) {
            case true :
                array_push($this->params[$key], $value);
                break;
            default:
                $this->params[$key] = $value;
                break;
        }
    }
    
    private function fixTimeout($timeout = null)
    {
        if ( ! $timeout ) {
            $timeout = 0;
        }

        /**
         * Testse 003
         */
//        $this->params = [
//            'index' => $this->index,
//            'client' => [
//                'timeout'           => 10,        // ten second timeout
//                'connect_timeout'   => 10
//            ]
////            ,'body' => [
////                'settings' => [
////                    'number_of_replicas' => 0,
////                    'refresh_interval' => -1
////                ]
////            ]
//        ];
//
////        $response = $this->client->indices()->putSettings($this->params);
//        return;
        


// CURLOPT_FTP_RESPONSE_TIMEOUT: Indefinite
// CURLOPT_TIMEOUT: Indefinite
// CURLOPT_TIMEOUT_MS: Indefinite
// CURLOPT_CONNECTTIMEOUT: 300 seconds
// CURLOPT_CONNECTTIMEOUT_MS: Indefinite
// CURLOPT_ACCEPTTIMEOUT_MS: 60 seconds

        /**
         * Teste 002
         */
//        $this->curlParams['guzzleOptions']['command.request_options'] = [
//            'connect_timeout' => $timeout,
//            'timeout' => $timeout
//        ];
        $this->curlParams['guzzleOptions'] = [
            'curl.options'=> [
                CURLOPT_TIMEOUT => 10,
                // CURLOPT_TIMEOUT_MS => 10,
                // CURLOPT_CONNECTTIMEOUT => 10,
                // CURLOPT_CONNECTTIMEOUT_MS => 10,
                // CURLOPT_ACCEPTTIMEOUT_MS => 10,
                // CURLE_OPERATION_TIMEOUTED => 10,

            ]
        ];
        
        return;
        // Or we could use this option
        /**
        $params['guzzleOptions'] = [
            'curl.options'=> [
                CURLOPT_CONNECTTIMEOUT => 2.0
            ]
        ];
         * 
         */
        
        /**
         * Teste de configuração do timeout do Curl
         */
//        $this->params['guzzleOptions']['command.request_options'] = [
//            'connect_timeout' => $timeout,
//            'timeout' => $timeout
//        ];

        $this->params = [
            'hosts' => ['wikinotes.com.br:9200'],
            'guzzleOptions' => [
                'command.request_options'   => [
                    'connect_timeout' => 10,
                    'timeout' => 10
                ]
            ],
            'handler' => ClientBuilder::singleHandler()
        ];
        
//        $this->params = [
//            'guzzleOptions' => [
//                'command.request_options'   => [
//                    'connect_timeout' => 10,
//                    'timeout' => 10
//                ]
//            ],
//            'hosts' => [
//                'wikinotes.com.br:9200'
//            ],
//            'retries' => 2,
//            'handler' => ClientBuilder::singleHandler()
//        ];
//        $this->params = [
//            'hosts' => [
//                'wikinotes.com.br:9200'
//            ],
//            'retries' => 2,
//            'handler' => ClientBuilder::singleHandler()
//        ];
//        $this->client = new \Elasticsearch\Client($params);
    }
}
