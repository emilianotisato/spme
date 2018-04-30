<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Spme!') }}</title>

	<link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vuetify.min.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ config('app.favicon', '/img/favicon.png') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.SpmeAPI = {!! getJsonApi() !!};
    </script>

</head>
<body>
    <div id="vue-container">
		@yield('container')
    </div>
    <script src="{{mix('/js/app.js')}}"></script>
</body>
</html>
