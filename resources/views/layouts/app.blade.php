<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="token" id="token" value="{{ csrf_token() }}">
    
    <link rel="icon" 
      type="image/png" 
      href="{{ url('images/favicon.png') }}">

	<title>WikiEspírita</title>

	{{-- Fontes --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ url('assets/css/app.css') }}">

<!--    <style>
        html, body {
            height: 80%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
            background: #f7f7f7;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }

        .searchBox {
        	height: auto;
        	width: 100%;
        	font-size: large;
        	padding: 10px;
/*        	border: 1px;
        	padding: 0px;
        	margin: 1px;
        	height: auto;
        	width: 40%;
        	position: absolute;
        	z-index: 6;
        	left: 0px;
        	outline: none;

*/        }
    </style> -->

</head>

<body>

	{{-- Menu --}}
	@yield('menu')

	{{-- Conteúdo --}}
	@yield('content')

	{{-- Rodapé --}}
	@yield('footer')


	{{-- Scripts --}}
    <script type="text/javascript" src="http://cdn.jsdelivr.net/vue/1.0.21/vue.js"></script>
    <!-- <script type="text/javascript" src="http://cdn.jsdelivr.net/vue/1.0.21/vue.min.js"></script> -->
	<script src="{{ url('assets/js/main.js') }}"></script>
</body>
</html>