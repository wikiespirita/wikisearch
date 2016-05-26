@extends('layouts.app')
        
<div class="container">
    <div class="content">
        <div class="title"><img src="{{ url('images/logo/wiki_espirita_logo_420.png') }}"></div>
        <br/>
    	<div><input @keyup='changeView' @keyup.enter='searchNow' class="searchBox" type="text" name="search" placeholder="Digite aqui o que procura" v-model='searchText' autofocus></div>
        <br/>
    	<br/>
    	<div>
    		<button class="er-btn" @click='searchNow' inline-block>Pesquisar Agora!</button>
    		<!-- <button class="er-btn" inline-block>Modo Avançado</button> -->
    	</div>
    </div>    
</div>