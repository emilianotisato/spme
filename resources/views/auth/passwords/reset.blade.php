@extends('layouts.master')

@section('container')
<div id="vue-container">
	<v-app v-cloak class="login-form">
		<v-dialog width="600px" :value='true' persistent=''>
			<v-card hover='' style='background:white'>
				<v-card class="blue darken-1">
					<v-card-title class="white--text text-xs-center">
						Recuperar la contraseña
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
						<form class="flex pb-2" method="post" action="{{ route('password.reset') }}">
							{!! csrf_field() !!}
							<input type="hidden" name="token" value="{{ request()->query('token') }}">

							<v-layout row>
								<v-flex md10 offset-md1>
									<v-text-field type="email" name="email" label="Email" value="{{ $email or old('email') }}" light></v-text-field>
								</v-flex>
							</v-layout>
							<v-layout row>
								<v-flex md10 offset-md1>
									<v-text-field type="password" name="password" label="Contraseña" light></v-text-field>
								</v-flex>
							</v-layout>
							<v-layout row>
								<v-flex md10 offset-md1>
									<v-text-field type="password" name="password_confirmation" label="Repetir contraseña" light></v-text-field>
								</v-flex>
							</v-layout>
							<div class="text-xs-right">
								<input type="hidden" name="remember" value="1">
								<v-btn type="submit" class="blue" dark>Generar nueva contraseña</v-btn>
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
