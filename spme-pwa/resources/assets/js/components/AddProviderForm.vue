<template>
    <div>
        <form class="form-bordered" @submit.prevent="onSubmit" @change="form.errors.clear($event.target.name)" @keydown="form.errors.clear($event.target.name)">
            <v-card>
                <v-card-text>
                    <transition enter-active-class="animated fade">
                        <v-layout row wrap v-if="!newProviderForm">
                            <v-flex md12>
                                <h5 class="primary--text">Agregar Proveedor</h5>
                            </v-flex>
                            <v-flex md12>
                                <v-select
                                        label="Proveedores"
                                        :items="contacts"
                                        item-value="id"
                                        item-text="name"
                                        v-model="form.contact_id"
                                        autocomplete
                                ></v-select>
                            </v-flex>
                            <v-flex md12 text-sm-right>
                                <v-btn class="blue--text darken-1" flat @click.native="closeAddProvider">Cancelar</v-btn>
                                <v-btn type="submit" dark success><span>Agregar</span></v-btn>
                            </v-flex>
                            <v-flex md12>
                                <v-btn @click.prevent.stop="newProviderForm = true" small block dark class="grey lighten-4 grey--text">No esta en la lista? Agregar...</v-btn>
                            </v-flex>
                        </v-layout>
                    </transition>
                    <transition enter-active-class="animated fade">
                        <v-layout row wrap v-if="newProviderForm">
                            <v-flex md12>
                                <h5 class="primary--text">Crear Nuevo Proveedor</h5>
                            </v-flex>
                            <v-flex md12>
                                <contact-form
                                        @contactSuccessfullyAdded="newProviderFormSuccess"
                                        @closeContact="closeAddProvider"
                                        :unitId="unitId"
                                        :isProvider="true"
                                ></contact-form>
                            </v-flex>
                        </v-layout>
                    </transition>
                </v-card-text>
            </v-card>
        </form>
    </div>
</template>

<script>
    import ContactForm from './ContactForm'

    export default {
        components: { ContactForm },

        props:{
            unitId: {
                type: Number,
                required: true,
            }
        },

        data () {
            return {
                form: new Form({
                    unit_id: '',
                    contact_id: ''
                }),
                newProviderForm: false
            }
        },

        mounted() {
            this.form.unit_id = this.unitId
        },

        computed: {
            contacts() {
                return this.$store.getters.providers
            }
        },

        methods: {
            closeAddProvider() {
                this.$emit('closeAddProvider')
            },

            onSubmit() {
                this.form.post(window.App.internal_api.syncProviderToUnit)
                    .then((response) => {

                        if(response != null) {
                            this.$emit('providerSuccessfullyAdded', response)

                            this.$notify({
                                group: 'success',
                                title: 'Proveedor agregado!',
                                text: 'El proveedor se creó correctamente',
                                duration: 5000
                            });
                        }

                        this.form.reset()
                        this.closeAddProvider()
                    })
                    .catch((error) => {
                        this.form.reset()
                        this.closeAddProvider()
                        console.log(error);
                    });
            },

            newProviderFormSuccess(payload) {
                this.$emit('providerSuccessfullyAdded', payload)
            }
        }
    }
</script>