@extends('layouts.app')
        
<div class="container">
    <div class="content">
        <!-- <div class="title"><img src="{{-- url('images/logo/wiki_espirita_logo_420.png') --}}"></div> -->
        <div class="title"><img src="{{ url('images/wiki_espirita_logo_310x248.png') }}"></div>
        <br/>
        <div>
            <input class="searchBox" type="text" name="search" placeholder="Digite aqui o que procura" autofocus inline-block
                v-model='searchText'
                @keyup='changeView' 
                @keyup.enter='searchNow' 
                >
        </div>
        <br/>
        <div>
            <button class="er-btn" @click='searchNow' inline-block>Pesquisar Agora!</button>
            <!-- <button class="er-btn" inline-block>Modo Avançado</button> -->
        </div>
    </div>    
</div>