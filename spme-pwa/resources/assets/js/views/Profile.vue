<template>
    <div>
        <v-card>
            <v-card-text>
                <h5>Hola {{ $store.state.auth_user.name }}</h5>
                <br>
                <p>Si queres modificar tu contraseña, llena los siguientes campos</p>
                <form class="form-bordered" @submit.prevent="onSubmit" @change="form.errors.clear($event.target.name)" @keydown="form.errors.clear($event.target.name)">
                    <v-card>
                        <v-card-text>
                            <v-layout row wrap>
                                <v-flex md8 xs12>
                                    <v-text-field

                                            label="Contrseña actual"
                                            :rules="[oldPass]"
                                            required
                                            type="password"
                                            v-model="form.old_pass"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex md8 xs12>
                                    <v-text-field
                                            label="Nueva Contrseña"
                                            :rules="[newPass]"
                                            required
                                            type="password"
                                            v-model="form.password"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex md8 xs12>
                                    <v-text-field
                                            label="Repetir nueva Contrseña"
                                            required
                                            type="password"
                                            v-model="form.password_confirmation"
                                    ></v-text-field>
                                </v-flex>

                            </v-layout>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn type="submit" dark success>Actualizar contrseña</v-btn>
                        </v-card-actions>
                    </v-card>
                </form>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    export default {

        data () {
            return {
                form: new Form({
                    old_pass: '',
                    password: '',
                    password_confirmation: '',
                })
            }
        },

        computed: {

            // Validation rules
            oldPass() {
                return this.form.errors.has('old_pass') ? this.form.errors.get('old_pass') : true
            },
            newPass() {
                return this.form.errors.has('password') ? this.form.errors.get('password') : true
            }
        },

        methods: {

            onSubmit() {
                this.form.post(window.App.internal_api.updatePassword)
                    .then(response => {
                    console.log(response);

                        this.$notify({
                            group: 'success',
                            title: 'Contraseña actualizada!',
                            text: 'Se actualizo correctamente tu password, ahora serás redirigido para loguearte nuevamente',
                            duration: 5000
                        });

                        setTimeout(() => {
                            window.location.href = window.App.internal_api.logout;
                        }, 2000)

                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    }
</script>