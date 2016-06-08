<script>

    export default {


        props: [
            'logo',
            'lupa',
            'searchText'
        ]
    }

</script>

<template>
    <nav class="nav">
        <img class="nav-logo" src="{{ logo }}">
        <form class="nav-form">
            <input class="searchBox-nav" type="text" name="search_" placeholder="Digite aqui o que procura"
                v-model='searchText'                    
                @keyup.enter='searchNow' 
                >
            <button class="nav-button" type="submit"><img src="{{ lupa }}" alt=""></button>
        </form>
    </nav>
</template>
