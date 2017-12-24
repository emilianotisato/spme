<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>{{ config('app.name') }}</title>

	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/vuetify.min.css') }}" rel="stylesheet">

	<meta name="csrf-token" content="{{ csrf_token() }}">
	<style>
		@if(!Auth::check()) 
			@if(config('app.background_image')) #main {
				background-image: url("/{{config('app.background_image')}}");
				background-size: cover;
			}
			@endif 
		@endif
	</style>

</head>

<body>
	<div id="vue-container">
		@if(Auth::check())
		<v-app {{ config( 'app.theme') }} v-cloak>
			<v-navigation-drawer class="{{ config('app.sidebar_color') }}" {{ config( 'app.sidebar_theme') }} persistent :mini-variant.sync="mini"
			 v-model="drawer" overflow>
				<v-toolbar flat class="transparent">
					<v-list class="pa-0">
						<v-list-tile avatar tag="div" router to="perfil">
							<v-list-tile-avatar>
								<v-icon >account_circle</v-icon>
								{{--  <v-icon {{ config( 'app.sidebar_icons') }}>account_circle</v-icon>  --}}
							</v-list-tile-avatar>
							<v-list-tile-content>
								<v-list-tile-title>@{{ $store.state.auth_user.name }}</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
					</v-list>
				</v-toolbar>
				<v-list class="pt-0" dense>
					<v-divider></v-divider>
					<v-list-tile v-for="item in menuItems" :key="item.title" router :to="item.link" v-show="item.show">
						<v-list-tile-action>
							<v-icon {{ config( 'app.sidebar_icons') }}>@{{ item.icon }}</v-icon>
						</v-list-tile-action>
						<v-list-tile-content>
							<v-list-tile-title>@{{ item.title }}</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
				</v-list>
				<v-divider dark></v-divider>
				<div v-if="!mini">
					<v-subheader class="mt-3 white--text text--darken-1">
						<v-icon {{ config( 'app.sidebar_icons') }} left>event</v-icon>&nbsp;&nbsp;AGENDA</v-subheader>
					<v-switch :label="eventsLabel" dark v-model="myEvents" class="ml-4"></v-switch>
					<div v-if="eventList.length >= 1" id="upcomingEvents">
						<v-list-tile avatar v-for="update in eventList" :key="update.id" :class="{'error' : update.isDueDude }" @click.prevent.stop="updateEventClicked(update.ticket_id)">
							<v-list-tile-action>
								<div class="subheading">@{{ update.due_date | fullDateAndTime}}</div>
							</v-list-tile-action>
							<v-list-tile-content>
								<v-list-tile-title>@{{ update.userName }}</v-list-tile-title>
								<v-list-tile-sub-title>@{{ update.description.substring(0,45) }}</v-list-tile-sub-title>
							</v-list-tile-content>
						</v-list-tile>
					</div>
					<span class="white--text ml-3" v-else>
						<span v-if="myEvents">No tenes eventos...</span>
						<span v-else>No hay eventos!</span>
					</span>
				</div>
			</v-navigation-drawer>
			<v-toolbar fixed class="{{ config('app.main_color') }}" dark>
				<div class="hidden-sm-and-down">
					<v-toolbar-side-icon @click.prevent.stop="mini = !mini"></v-toolbar-side-icon>
				</div>
				<v-toolbar-title>
					<router-link to="/" tag="span" style="cursor: pointer">
						@if(config('app.logo') !== null)
							<img height="50px" src="{{ config('app.logo') }}" alt="{{ config('app.name') }}"> 
						@else 
							{{ config('app.name') }} 
						@endif
					</router-link>
				</v-toolbar-title>
				<div style="margin: auto" v-show="loader">
					<v-progress-circular size="40" indeterminate class="deep-orange--text"></v-progress-circular>
				</div>
				<v-btn @click="$store.state.openTicketForm = true" class="primary elevation-4" dark small absolute bottom right fab>
					<v-icon>add</v-icon>
				</v-btn>
			</v-toolbar>
			<main>
				<v-container fluid>
					<router-view></router-view>
				</v-container>
			</main>
			<ticket-form :dialog="$store.state.openTicketForm"></ticket-form>
			<notifications group="info" classes="vue-notification info" position="bottom right"></notifications>
			<notifications group="success" classes="vue-notification success" position="bottom right"></notifications>
			<notifications group="warning" classes="vue-notification warn" position="bottom right"></notifications>
			<notifications group="error" classes="vue-notification error" position="bottom right"></notifications>
		</v-app>
		@else
		<v-app {{ config( 'app.theme') }} v-cloak>
			<v-toolbar fixed class="{{ config('app.main_color') }}" dark>
				<v-toolbar-title>
					<router-link to="/" tag="span" style="cursor: pointer">
						@if(config('app.logo') !== null)
							<img height="50px" src="{{ config('app.logo') }}" alt="{{ config('app.name') }}"> 
						@else 
							{{ config('app.name') }} 
						@endif
					</router-link>
					<v-btn class="primary elevation-4" dark absolute right>
						<v-icon left>call</v-icon>&nbsp;&nbsp;+54 911 3236 3848&nbsp;&nbsp;&nbsp;
						<v-icon left>email</v-icon>&nbsp;&nbsp;info@thormaweb.com
					</v-btn>
				</v-toolbar-title>
			</v-toolbar>
			<main id="main">
				<v-container fluid>
					<v-layout row wrap>
						<v-flex xs10 offset-xs1 md6 offset-md3>
							<v-card dark class="animated fadeInUp grey lighten-4">
								<v-toolbar class="{{ config('app.main_color') }}" dark>
									<v-toolbar-title>Ingresar al sistema</v-toolbar-title>
								</v-toolbar>
								<v-card-text>
									@if($errors->any())
									<h6 class="error--text">Los datos son incorrectos. Intente nuevamente.</h6>
									@endif
									<form method="post" action="/login">
										{!! csrf_field() !!}
										<v-layout row>
											<v-flex md10 offset-md1>
												<v-text-field type="email" name="email" label="Email" light></v-text-field>
											</v-flex>
										</v-layout>
										<v-layout row>
											<v-flex md10 offset-md1>
												<v-text-field type="password" name="password" label="Contraseña" light></v-text-field>
											</v-flex>
										</v-layout>
										<div class="text-xs-right">
											<input type="hidden" name="remember" value="1">
											<v-btn type="submit" primary dark>Ingresar</v-btn>
										</div>
									</form>
									<span>
										<a href="/password/email">Olvido su contraseña?</a>
									</span>
								</v-card-text>
							</v-card>
						</v-flex>
					</v-layout>

				</v-container>
			</main>
		</v-app>
		@endif
	</div>
	<script>
		window.App = new Object();
    	window.App.internal_api = {
        {{--  getUser: '{{url()->route('getUser')}}',
        updatePassword: '{{url()->route('updatePassword')}}',
        logout: '{{url()->route('logout')}}',
        getTickets: '{{url()->route('getTickets')}}',
        getUsers: '{{url()->route('getUsers')}}',
        getProviders: '{{url()->route('getProviders')}}',
        getBuildings: '{{url()->route('getBuildings')}}',
        getStatuses: '{{url()->route('getStatuses')}}',
        getSeverities: '{{url()->route('getSeverities')}}',
        postTicket: '{{url()->route('postTicket')}}',
        postTicketUpdate: '{{url()->route('postTicketUpdate')}}',
        postContact: '{{url()->route('postContact')}}',
        syncProviderToUnit: '{{url()->route('syncProviderToUnit')}}',
        postBuilding: '{{url()->route('postBuilding')}}',
        postUnit: '{{url()->route('postUnit')}}',
        deleteBuilding: '{{url()->route('deleteBuilding')}}',
        deleteUnit: '{{url()->route('deleteUnit')}}',  --}}
    };
	</script>
	<script src="{{mix('/js/app.js')}}"></script>
	<script async src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
</body>

</html>