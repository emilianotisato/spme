<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>

	<link href="{{ mix('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/vuetify.min.css') }}" rel="stylesheet">

	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="vue-container">
        <master></master>
    </div>
    <script src="{{mix('/js/app.js')}}"></script>
</body>
</html>