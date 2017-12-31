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
        @if(Auth::check())
        <v-app id="spme" v-cloak>
            <v-navigation-drawer
            fixed
            clipped
            app
            v-model="drawer"
            >
            <v-list dense>
                <template v-for="(item, i) in menuItems">
                <v-list-group v-if="item.children" v-model="item.model" no-action>
                    <v-list-tile slot="item" @click="">
                    <v-list-tile-action>
                        <v-icon>@{{ item.model ? item.icon : item['icon-alt'] }}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>
                        @{{ item.title }}
                        </v-list-tile-title>
                    </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile
                    v-for="(child, i) in item.children"
                    :key="i"
                    router
                    :to="child.link"
                    >
                    <v-list-tile-action v-if="child.icon">
                        <v-icon>@{{ child.icon }}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>
                        @{{ child.title }}
                        </v-list-tile-title>
                    </v-list-tile-content>
                    </v-list-tile>
                </v-list-group>
                <v-list-tile v-else router :to="item.link"> 
                    <v-list-tile-action>
                    <v-icon>@{{ item.icon }}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                    <v-list-tile-title>
                        @{{ item.title }}
                    </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                </template>
            </v-list>
            </v-navigation-drawer>
            <v-toolbar
            color="blue darken-3"
            dark
            app
            clipped-left
            fixed
            >
            <v-toolbar-title :style="$vuetify.breakpoint.smAndUp ? 'width: 300px; min-width: 250px' : 'min-width: 72px'" class="ml-0 pl-3">
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                <span class="hidden-xs-only">{{ config( 'app.name') }}</span>
            </v-toolbar-title>
            <v-text-field
                light
                solo
                prepend-icon="search"
                placeholder="Search"
                style="max-width: 500px; min-width: 128px"
            ></v-text-field>
            <div class="d-flex align-center" style="margin-left: auto">
                <v-btn icon>
                <v-icon>apps</v-icon>
                </v-btn>
                <v-btn icon>
                <v-icon>notifications</v-icon>
                </v-btn>
            </div>
            </v-toolbar>
            <v-content>
            <v-container fluid fill-height>
                <router-view></router-view>
            </v-container>
            </v-content>
            <v-btn
            fab
            bottom
            right
            color="pink"
            dark
            fixed
            @click.stop="dialog = !dialog"
            >
            <v-icon>add</v-icon>
            </v-btn>
            <v-dialog v-model="dialog" width="800px">
            <v-card>
                <v-card-title
                class="grey lighten-4 py-4 title"
                >
                Create contact
                </v-card-title>
                <v-container grid-list-sm class="pa-4">
                <v-layout row wrap>
                    <v-flex xs12 align-center justify-space-between>
                    <v-layout align-center>
                        <v-avatar size="40px" class="mr-3">
                        <img
                            src="//ssl.gstatic.com/s2/oz/images/sge/grey_silhouette.png"
                            alt=""
                        >
                        </v-avatar>
                        <v-text-field
                        placeholder="Name"
                        ></v-text-field>
                    </v-layout>
                    </v-flex>
                    <v-flex xs6>
                    <v-text-field
                        prepend-icon="business"
                        placeholder="Company"
                    ></v-text-field>
                    </v-flex>
                    <v-flex xs6>
                    <v-text-field
                        placeholder="Job title"
                    ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                    <v-text-field
                        prepend-icon="mail"
                        placeholder="Email"
                    ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                    <v-text-field
                        type="tel"
                        prepend-icon="phone"
                        placeholder="(000) 000 - 0000"
                        mask="phone"
                    ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                    <v-text-field
                        prepend-icon="notes"
                        placeholder="Notes"
                    ></v-text-field>
                    </v-flex>
                </v-layout>
                </v-container>
                <v-card-actions>
                <v-btn flat color="primary">More</v-btn>
                <v-spacer></v-spacer>
                <v-btn flat color="primary" @click="dialog = false">Cancel</v-btn>
                <v-btn flat @click="dialog = false">Save</v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
            <notifications group="info" classes="vue-notification info" position="bottom right"></notifications>
			<notifications group="success" classes="vue-notification success" position="bottom right"></notifications>
			<notifications group="warning" classes="vue-notification warn" position="bottom right"></notifications>
			<notifications group="error" classes="vue-notification error" position="bottom right"></notifications>
        </v-app>
        @else
        <v-app v-cloak>
            <v-dialog width="600px" :value='true' persistent=''>
                <v-card hover='' style='background:white'>
                    <v-card class="blue darken-1">
                        <v-card-title class="white--text text-xs-center">
                            Ingresar al sistema
                        </v-card-title>
                    </v-card>
                <v-card>
                <v-card-text class="pt-4">
                    @if($errors->any())
						<h4 class="error--text">Los datos son incorrectos. Intente nuevamente.</h4>
					@endif
					<form class="flex pb-2" method="post" action="/login">
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
            </v-dialog>
        </v-app>
        @endif
    </div>
    <script src="{{mix('/js/app.js')}}"></script>
</body>
</html>