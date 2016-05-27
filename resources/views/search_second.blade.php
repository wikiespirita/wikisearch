@extends('layouts.app')

    <nav class="nav">
        <img class="nav-logo" src="{{ url('images/wiki_espirita_logo_teste.png') }}">
        <form class="nav-form">
            <input class="searchBox-nav" type="text" name="search" placeholder="Digite aqui o que procura" autofocus
                v-model='searchText'
                @keyup='changeView' 
                @keyup.enter='searchNow' 
                >
            <button class="nav-button" type="submit"><img src="{{ url('images/lupa.png') }}" alt=""></button>
        </form>
    </nav>
        
<div class="container">


    <div class="content">
        <div><p><h1>Resultado da pesquisa vem aqui!</h1></p></div>
    </div>    
</div>