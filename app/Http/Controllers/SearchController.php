<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Elasticsearch;
use Elasticsearch\ClientBuilder;
use Monolog\Logger;
use App\Http\Controllers\IndexingController;

class SearchController extends Controller
{

    // Variáveis
    protected $hosts = ['wikinotes.com.br:9200'];
    protected $client;
    protected $log_path = 'elasticsearch/log/elastic.txt';
    protected $file_path = 'elasticsearch/files/';
    protected $logger;
    protected $disk;
    protected $index = 'wikisearch';
    protected $type = 'geral';

    public function __construct()
    {
    	// Teste 001
        // $this->disk = Storage::disk('local');

        // if ( ! $this->disk->exists($this->log_path) ) {
        //     $this->disk->put($this->log_path, '');
        // }
        // $this->logger = ClientBuilder::defaultLogger(storage_path('app/' . $this->log_path));
        // $this->logger = ClientBuilder::defaultLogger(storage_path('app' . $this->log_path, Logger::WARNING));
        // $this->logger = ClientBuilder::defaultLogger(storage_path('app' . $this->log_path, Logger::INFO));;

        // $this->client = ClientBuilder::create()
        //             ->setHosts($this->hosts)
        //             ->setLogger($this->logger)
        //             ->build();
        
        // Teste 002
        // @ somente no index... (abaixo)
    }

    public function index()
    {
    	// Teste 001
    	// $this->create_index();
    
    	// Teste 002 - IndexingController (object)
        $criar_node = false;
        
        if ( $criar_node ) {
        	echo 'Criando índice! <br><br>';
			$this->client = new IndexingController();
            $this->client->destroy($this->index);
            $this->client->create($this->index);
            $this->client->map(null, $this->index, $this->type);
        }

        /**
         * Indexando os Arquivos PDF's
         */
        $indexa_documentos = false;
        if ( $indexa_documentos ) {
	        $pdf_folder = 'pdf/';
	        $dir = storage_path('app/' . $this->file_path . $pdf_folder);
	        $files = scandir($dir);
	        $arrFiles = [];
			
	        foreach ($files as $filename)
	        {
	            if ( $filename <> "." && $filename <> "..") {
	                $this->client = new IndexingController();
	                $this->client->indexFile($pdf_folder . $filename);
	                unset($this->client);
	//                sleep(10);
	            }
	        }
    	}

    	/**
    	 * Pesquisando nos arquivos indexados
    	 */
    	$pesquisa = true;
        $this->client = new IndexingController();
    	if ( $pesquisa ) {
	    	$results = $this->client->search('jesus');
			// $results = $this->search('Divina');
			// $results = $this->search('aborrecimentos');
			// $results = $this->search('habituara');
			// $results = $this->search('alfaiates');
			// $results = $this->search('depressa');
			// $results = $this->search('cooperadores');
	        $qtd = $results['hits']['total'];
	        echo 'Quantidade de Livros: ' . $qtd . '<br><br>';
	        
            dd($results);

	        $hightlights = $results['hits']['hits'];
	        foreach ($hightlights as $value) {
	            $hightlight = $value['highlight']['file.content'];
	            foreach ($hightlight as $value) {
	                echo $value;
	                echo '<br>';
	                echo '<hr>';
	            }
	        }
	    }
    }

    // Teste 001
    /**
     * Controles do ElasticSearch que deverá funcionar em um middleware
     */
    // public function create_index($index = null)
    // {
    // 	if ( $index ) {
    //         $this->index = $index;
    //     }
    //     echo 'Criando um Indice: <br />';
    //     $params = [
    //         'index' => $this->index
    //     ];
    //     // Delete the index
    //     $this->client->indices()->delete($params);
    //     // Create the index
    //     $response = $this->client->indices()->create($params);
    //     print_r($response);
        
    //     echo '<hr>';        
    // }
}
