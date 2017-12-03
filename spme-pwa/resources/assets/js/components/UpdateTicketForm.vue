<template>
    <div>
        <form class="form-bordered" @submit.prevent="onSubmit" @change="form.errors.clear($event.target.name)" @keydown="form.errors.clear($event.target.name)">
            <v-card flat>
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex md3 xs12 v-if="!isForClose">
                            <v-layout row wrap>
                                <v-flex md12>
                                    <v-switch :label="`Activar recordatorio`" v-model="dateTimeEnable"></v-switch>
                                </v-flex>
                                <v-flex md12 v-show="dateTimeEnable">
                                    <v-menu
                                            lazy
                                            :close-on-content-click="false"
                                            v-model="dateMenu"
                                            transition="scale-transition"
                                            offset-y
                                            full-width
                                            :nudge-left="40"
                                            max-width="290px"
                                    >
                                        <v-text-field
                                                slot="activator"
                                                label="Fecha"
                                                v-model="date"
                                                prepend-icon="event"
                                                readonly
                                        ></v-text-field>
                                        <v-date-picker v-model="date" autosave no-title scrollable>
                                        </v-date-picker>
                                    </v-menu>
                                </v-flex>
                                <v-flex md12 v-show="dateTimeEnable">
                                    <v-menu
                                            lazy
                                            :close-on-content-click="false"
                                            v-model="timeMenu"
                                            transition="scale-transition"
                                            offset-y
                                            :nudge-left="40"
                                    >
                                        <v-text-field
                                                slot="activator"
                                                label="Horario"
                                                v-model="time"
                                                prepend-icon="access_time"
                                                readonly
                                        ></v-text-field>
                                        <v-time-picker v-model="time" autosave></v-time-picker>
                                    </v-menu>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex md7 xs12>
                            <v-text-field
                                    label="Descripción"
                                    :rules="[descriptionValidation]"
                                    required
                                    :rows="2"
                                    multi-line
                                    v-model="form.description"
                            ></v-text-field>
                        </v-flex>
                        <v-flex md2 xs12 text-sm-right>
                            <v-btn class="blue--text darken-1" flat @click.native="closeTicketUpdate">Cancelar</v-btn>
                            <v-btn type="submit" dark success><span v-if="isForClose">Cerrar Ticket</span><span v-else>Guardar</span></v-btn>
                        </v-flex>
                    </v-layout>
                </v-card-text>
            </v-card>
        </form>
    </div>
</template>

<script>
    export default {

        props:{
            ticketId: {
                type: Number,
                required: true,
            },
            isForClose: {
                type: Boolean,
                default: false
            },
        },

        data () {
            return {
                form: new Form({
                    ticket_id: '',
                    description: '',
                    due_date: null,
                    closed: false
                }),
                dateTimeEnable: false,
                dateMenu: false,
                date: null,
                timeMenu: false,
                time: null,
            }
        },

        watch: {
            dateTimeEnable(val) {
                if(val == false) {
                    this.form.due_date = null
                    this.date = null
                    this.time = null
                }
            }
        },

        mounted() {
            this.form.ticket_id = this.ticketId
            this.form.closed = this.isForClose
        },

        computed: {
            descriptionValidation() {
                return this.form.errors.has('description') ? this.form.errors.get('description') : true
            }
        },

        methods: {
            closeTicketUpdate() {
                this.$emit('closeTicketUpdate')
            },

            dueDate() {
                if(this.date != null) {
                    let due_date = moment(this.date)

                    if(this.time != null) {
                        let time = moment(this.time, ["h:mma"]).format("HH:mm")
                        due_date = moment(moment(due_date).hours(time.split(":")[0]).minutes(time.split(":")[1]).seconds(0))
                    }

                    this.form.due_date = moment(due_date).format('YYYY-MM-DD HH:mm:ss')
                }

            },

            onSubmit() {
                if (this.dateTimeEnable != false) {
                    this.dueDate()
                }
                this.form.post(window.App.internal_api.postTicketUpdate)
                    .then((response) => {

                        this.$store.commit('update_tickets', response)

                        if(response.closed != null) {

                            this.$notify({
                                group: 'success',
                                title: 'Ticket cerrado!',
                                text: 'Se cerró el ticket correctamente',
                                duration: 5000
                            });

                            this.$router.push({ name: 'dashboard'})
                            location.reload()

                        } else {

                            this.$notify({
                                group: 'success',
                                title: 'Actualización agregada!',
                                text: 'La actualización creó correctamente',
                                duration: 5000
                            });

                            this.form.reset()
                            this.closeTicketUpdate()
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>