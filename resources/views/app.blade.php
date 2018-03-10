@extends('layouts.master')

@section('container')
        <v-app id="spme" v-cloak>
            <v-navigation-drawer
            fixed
            clipped
            app
            v-model="drawer"
            >
            @if(!Auth::user()->hasRole('client'))
            <v-list dense>
                <template v-for="(item, i) in menuItems">
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
            @else
            <v-list dense>
                <v-list-tile to="/">
                    <v-list-tile-action>
                    <v-icon>assignment_turned_in</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                    <v-list-tile-title>
                        Panel de trabajo
                    </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <v-list-tile to="/reporte">
                    <v-list-tile-action>
                    <v-icon>timeline</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                    <v-list-tile-title>
                        Reporte
                    </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
            @endif
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
            @if(!Auth::user()->hasRole('client'))
            <v-text-field
                light
                solo
                :disabled="!initStore"
                prepend-icon="search"
                placeholder="Buscar..."
                style="max-width: 500px; min-width: 128px"
            ></v-text-field>
            @endif
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
            <v-container fluid  v-if="initStore">
                <router-view></router-view>
            </v-container>
            <v-container v-else fluid fill-height>
                <v-layout justify-center align-center>
                    <v-progress-circular indeterminate :size="60" color="primary"></v-progress-circular>
                </v-layout>
            </v-container>
            </v-content>
            <task-form v-if="initStore"></task-form>
            <notifications group="info" classes="vue-notification info" position="bottom right"></notifications>
			<notifications group="success" classes="vue-notification success" position="bottom right"></notifications>
			<notifications group="warning" classes="vue-notification warn" position="bottom right"></notifications>
			<notifications group="error" classes="vue-notification error" position="bottom right"></notifications>
		</v-app>
@endsection
