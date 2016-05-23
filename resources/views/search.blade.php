@extends('layouts.app')
        
<div class="container">
    <div class="content">
        <div class="title"><img src="{{ url('images/logo/wiki_espirita_logo_420.png') }}"></div>
        <br/>
    	<input @keyup.enter='search' class="searchBox" type="text" name="search" placeholder="Digite aqui o que procura" autofocus>
    </div>
</div>