<template>
    <div>
        <form class="form-bordered" @submit.prevent="onSubmit" @change="form.errors.clear($event.target.name)" @keydown="form.errors.clear($event.target.name)">
            <v-card>
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex md12>
                            <v-text-field
                                    label="Nombre"
                                    :rules="[nameValidation]"
                                    required
                                    v-model="form.name"
                            ></v-text-field>
                        </v-flex>
                        <v-flex md6>
                            <v-text-field
                                    label="Email"
                                    v-model="form.email"
                            ></v-text-field>
                        </v-flex>
                        <v-flex md6>
                            <v-text-field
                                    label="Teléfono"
                                    v-model="form.phone"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>
                    <v-flex md12>
                        <v-text-field
                                label="Notas"
                                v-model="form.notes"
                        ></v-text-field>
                    </v-flex>
                    <v-flex md12 text-sm-right>
                        <v-btn class="blue--text darken-1" flat @click.native="closeContact">Cancelar</v-btn>
                        <v-btn type="submit" dark success><span>Guardar</span></v-btn>
                    </v-flex>
                </v-card-text>
            </v-card>
        </form>
    </div>
</template>

<script>
    export default {

        props:{
            unitId: {
                type: Number,
                required: true,
            },
            isProvider: {
                type: Boolean,
                default: false,
            },
        },

        data () {
            return {
                form: new Form({
                    unit_id: '',
                    is_provider: '',
                    name: '',
                    email: '',
                    phone: '',
                    notes: '',
                }),
            }
        },

        mounted() {
            this.form.unit_id = this.unitId
            this.form.is_provider = this.isProvider
        },

        computed: {
            nameValidation() {
                return this.form.errors.has('name') ? this.form.errors.get('name') : true
            }
        },

        methods: {
            closeContact() {
                this.$emit('closeContact')
            },

            onSubmit() {
                this.form.post(window.App.internal_api.postContact)
                    .then((response) => {

                        this.$emit('contactSuccessfullyAdded', response)

                        this.$notify({
                            group: 'success',
                            title: 'Contacto agregado!',
                            text: 'El contacto se creó correctamente',
                            duration: 5000
                        });

                        this.form.reset()
                        this.closeContact()
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>