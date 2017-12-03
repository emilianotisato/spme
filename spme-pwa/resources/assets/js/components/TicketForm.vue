<template>
    <v-layout row justify-center>
        <v-dialog width="66%" v-model="dialog" persistent>
            <form class="form-bordered" @submit.prevent="onSubmit" @change="form.errors.clear($event.target.name)" @keydown="form.errors.clear($event.target.name)">
                <v-card>
                    <v-toolbar dark class="darken-1 blue-grey">
                        <v-card-title>
                            <span class="headline text--white">Creación de Ticket</span>
                        </v-card-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-layout row wrap>
                            <v-flex md6 xs12>
                                <v-select
                                        label="Edificio"
                                        :items="buildings"
                                        item-value="id"
                                        item-text="name"
                                        autocomplete
                                        :rules="[buildingValidation]"
                                        @change="setActiveBuildingUnits"
                                ></v-select>
                            </v-flex>
                            <v-flex md6 xs12>
                                <v-select
                                        label="Unidad"
                                        :items="activeBuildingUnits"
                                        item-value="id"
                                        item-text="name"
                                        autocomplete
                                        :rules="[unitValidation]"
                                        required
                                        v-model="form.unit_id"
                                        :disabled="activeBuildingUnits.length == 0"
                                ></v-select>
                            </v-flex>
                            <v-flex md8 xs12>
                                <v-text-field
                                        label="Asunto"
                                        :rules="[subjectValidation]"
                                        required
                                        v-model="form.subject"
                                ></v-text-field>
                            </v-flex>
                            <v-flex md4 xs12>
                                <v-select
                                        label="Gravedad"
                                        :items="severities"
                                        item-value="id"
                                        item-text="label"
                                        :rules="[severityValidation]"
                                        required
                                        v-model="form.ticket_severity_id"
                                ></v-select>
                            </v-flex>
                            <v-flex md12>
                                <v-text-field
                                        label="Descripción"
                                        :rules="[descriptionValidation]"
                                        required
                                        v-model="form.description"
                                        multi-line
                                ></v-text-field>
                            </v-flex>
                            <v-flex md6 xs12>
                                <v-select
                                        label="Asignado a"
                                        :items="users"
                                        item-value="id"
                                        item-text="name"
                                        v-model="form.assigned_user"
                                        @change="setStatus"
                                ></v-select>
                            </v-flex>
                            <v-flex md6 xs12>
                                <v-select
                                        label="Estado"
                                        :items="statuses"
                                        item-value="id"
                                        item-text="label"
                                        :rules="[statusValidation]"
                                        required
                                        v-model="form.ticket_status_id"
                                        @change="setUser"
                                ></v-select>
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn class="blue--text darken-1" flat @click.native="resetFormAndClose">Cancelar</v-btn>
                        <v-btn type="submit" dark success>Guardar</v-btn>
                    </v-card-actions>
                </v-card>
            </form>
        </v-dialog>
    </v-layout>
</template>

<script>
    export default {

        props:{
            dialog: {
                type: Boolean,
                required: true,
                default: false
            },
        },

        data () {
            return {
                form: new Form({
                    assigned_user: '',
                    unit_id: '',
                    ticket_severity_id: '',
                    ticket_status_id: 1,
                    subject: '',
                    description: '',
                    closed: null
                }),
                activeBuildingUnits: []

            }
        },

        computed: {
            users() {
                return this.$store.getters.users
            },
            buildings() {
                return this.$store.getters.buildings
            },
            statuses() {
                return this.$store.getters.statuses
            },
            severities() {
                return this.$store.getters.severities
            },

            // Validation rules
            buildingValidation() {
                return this.activeBuildingUnits.length == 0 ? 'Comience escogiendo un edificio' : true
            },
            unitValidation() {
                return this.form.errors.has('unit_id') ? this.form.errors.get('unit_id') : true
            },
            subjectValidation() {
                return this.form.errors.has('subject') ? this.form.errors.get('subject') : true
            },
            descriptionValidation() {
                return this.form.errors.has('description') ? this.form.errors.get('description') : true
            },
            severityValidation() {
                return this.form.errors.has('ticket_severity_id') ? this.form.errors.get('ticket_severity_id') : true
            },
            statusValidation() {
                return this.form.errors.has('ticket_status_id') ? this.form.errors.get('ticket_status_id') : true
            }
        },

        methods: {
            setActiveBuildingUnits(buildingId) {
                this.activeBuildingUnits = this.$store.getters.buildingById(buildingId).units
                this.form.unit_id = ''
            },

            setStatus() {
                this.form.ticket_status_id = 2
            },

            setUser(statusId) {
                if(statusId == 1) {
                    this.form.assigned_user = ''
                    this.form.ticket_status_id = 1
                }
            },

            resetFormAndClose() {
                this.form.reset()
                this.form.ticket_status_id = 1
                this.$store.state.openTicketForm = false
            },

            onSubmit() {
                this.form.post(window.App.internal_api.postTicket)
                    .then((response) => {

                        this.resetFormAndClose()
                        this.$notify({
                            group: 'success',
                            title: 'Ticket creado!',
                            text: 'El ticket se creó correctamente',
                            duration: 5000
                        });

                        this.$store.commit('set_tickets', {ticket: response, tickets: null});
                        this.$router.push({ name: 'ticket', params: {ticketId: response.id}});
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>