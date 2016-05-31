<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('search');
});

Route::get('/search', 'SearchController@index');

/**
  * Rotas para teste do servidor
  *
  * http://wikiespirita.com.br:8200/_cat/health?v
  * http://wikiespirita.com.br:8200/_cat/nodes?v
  * http://wikiespirita.com.br:8200/_cat/indices?v
  * http://wikiespirita.com.br:8200/_nodes/stats/process?pretty
  *
  */