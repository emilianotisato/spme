@extends('layouts.master')

@section('container')
<div id="vue-container">
	<v-app v-cloak class="login-form">
		<v-dialog width="600px" :value='true' persistent=''>
			<v-card hover='' style='background:white'>
				<v-card class="blue darken-1">
					<v-card-title class="white--text text-xs-center">
						Ingrese su correo para recuperar la contraseña
					</v-card-title>
				</v-card>
				<v-card>
					<v-card-text class="pt-4">
						@if($errors->any())
						@foreach($errors->all() as $error)
						<h4 class="error--text">{{ $error }}</h4>
						@endforeach
						@endif
						@if (session('status'))
						<h4 class="success--text">
							{{ session('status') }}
						</h4>
						@endif
						<form class="flex pb-2" method="post" action="{{ route('password.email') }}">
							{!! csrf_field() !!}
							<v-layout row>
								<v-flex md10 offset-md1>
									<v-text-field type="email" name="email" label="Email" light></v-text-field>
								</v-flex>
							</v-layout>
							<div class="text-xs-right">
								<input type="hidden" name="remember" value="1">
								<v-btn type="submit" class="blue" dark>Enviar link de reinicio de contraseña</v-btn>
							</div>
						</form>
						<span>
							<a class="blue--text" href="{{ route('login') }}"><<< Volver al inicio</a>
						</span>
					</v-card-text>
				</v-dialog>
			</v-app>
</div>
@endsection

