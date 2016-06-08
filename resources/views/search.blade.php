@extends('layouts.app')

    {{-- 
        - @TODO 
        -
        - 1. LEVAR FOCO PARA NOVA VISUALIZAÇÃO (MANTER DIGITAÇÃO)
        - 2. NÃO RENDERIZAR NO INÍCIO. COMO FAZER??
        - 
        --}}

    <div v-if="! initialMode">
        <we-searchheader logo="url('images/wiki_espirita_logo_teste.png')" lupa="url('images/lupa.png')" ></we-searchheader>
    </div>



<div class="container">
    <div class="content">
        <div v-show="initialMode">
            <div class="title"><img src="{{ url('images/wiki_espirita_logo_310x248.png') }}"></div>
            <br/>
            <div>
                <input class="searchBox" type="text" name="search" placeholder="Digite aqui o que procura" autofocus inline-block
                    v-model='searchText'                    
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
</div>