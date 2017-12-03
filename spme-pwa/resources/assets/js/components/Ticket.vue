<template>
    <v-layout row justify-center>
        <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
            <v-card v-if="ticket">
                <v-toolbar dark :class="activeList">
                    <v-btn icon @click.stop="closeTab" dark>
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Ticket {{ ticket.id }} | {{ ticket.subject }}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark flat @click.stop="showCloseTicketForm = !showCloseTicketForm"><v-icon dark left>done_all</v-icon> <span class="hidden-sm-and-down">Marcar como Finalizado</span></v-btn>
                        <v-btn dark flat @click.stop="editMode = !editMode"><v-icon dark left>edit</v-icon> <span class="hidden-sm-and-down">Editar</span></v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <v-layout row wrap>
                    <transition enter-active-class="animated slideInRight">
                        <v-flex md12 class="mt-2 pb-3" v-if="showCloseTicketForm">
                            <h4 class="primary--text ml-2">Indique los modivos de cierre</h4>
                            <update-ticket-form @closeTicketUpdate="showCloseTicketForm = false" :isForClose="true" :ticketId="ticketId"></update-ticket-form>
                        </v-flex>
                    </transition>
                    <v-flex md6 xs12 class="mt-2 pb-3 pr-3">
                        <transition enter-active-class="animated fade">
                            <div v-if="!editMode">
                                <h4 class="pt-3 pl-2" v-text="ticket.unitFullName"></h4>
                                <v-subheader>{{ ticket.subject }}</v-subheader>
                                <blockquote class="mb-3 ml-2" v-html="this.$options.filters.nToBr(ticket.description)"></blockquote>
                            </div>
                        </transition>
                        <transition enter-active-class="animated slideInLeft">
                            <div v-if="editMode">
                                <h4 class="pt-3 pl-2" v-text="ticket.unitFullName"></h4>
                                <v-layout row wrap>
                                    <v-flex md12>
                                        <v-text-field
                                                label="Asunto"
                                                :rules="[subjectValidation]"
                                                required
                                                v-model="form.subject"
                                        ></v-text-field>
                                    </v-flex>
                                </v-layout>
                                <v-flex md12>
                                    <v-text-field
                                            label="Descripción"
                                            :rules="[descriptionValidation]"
                                            required
                                            v-model="form.description"
                                            multi-line
                                    ></v-text-field>
                                </v-flex>
                            </div>
                        </transition>
                    </v-flex>
                    <v-flex md3 xs12 class="mt-2 pb-3 pr-3">
                        <transition enter-active-class="animated fadeIn">
                            <v-card class="grey lighten-2" v-if="!editMode">
                                <v-card-title primary-title>
                                    <div v-if="ticket.assigned">
                                        <h5 class="subheading">Actualizado: {{ ticket.updated_at | fullDateAndTime}}</h5>
                                        <h6 class="body-2">Asignado a:</h6>
                                        <h4 class="title">{{ ticket.assigned.name }}</h4>
                                    </div>
                                    <div v-else>
                                        <h3>Sin Asignar!</h3>
                                    </div>
                                </v-card-title>
                                <v-card-text>
                                    <v-chip class="primary lighten-3 white--text">
                                        {{ ticket.ticket_severity.label}}
                                        <v-icon right>thumbs_up_down</v-icon>
                                    </v-chip>
                                    <v-chip class="primary lighten-3 white--text">
                                        {{ ticket.ticket_status.label}}
                                        <v-icon right>info</v-icon>
                                    </v-chip>
                                </v-card-text>
                            </v-card>
                        </transition>
                        <transition enter-active-class="animated flipInY">
                            <v-card class="grey lighten-2" v-if="editMode">
                                <v-card-text>
                                    <v-layout row wrap>
                                        <v-flex md12>
                                            <v-select
                                                    label="Asignado a"
                                                    :items="users"
                                                    item-value="id"
                                                    item-text="name"
                                                    v-model="form.assigned_user"
                                                    @change="setStatus"
                                            ></v-select>
                                        </v-flex>
                                        <v-flex md12>
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
                                        <v-flex md12>
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
                                    </v-layout>
                                </v-card-text>
                            </v-card>
                        </transition>
                    </v-flex>
                    <transition enter-active-class="animated fade">
                        <v-flex md3 xs12 class="mt-2 pb-3 pr-3" v-if="!editMode && !showCreateContactForm && !showAddProvider">
                            <v-expansion-panel>
                                <v-expansion-panel-content v-for="(contact, i) in ticket.unit.contacts" :key="i" v-bind:value="i === 0">
                                    <div slot="header">
                                        <v-icon left v-if="contact.is_provider" class="indigo--text">person</v-icon>
                                        <v-icon left v-else>person_outline</v-icon>
                                        {{ contact.name}}
                                    </div>
                                    <v-card>
                                        <v-card-text class="grey lighten-3">
                                            <h6 v-show="contact.email"><v-icon left>email</v-icon> {{ contact.email }}</h6>
                                            <h6 v-show="contact.phone"><v-icon left>phone</v-icon> {{ contact.phone }}</h6>
                                            <p v-html="contact.notes"></p>
                                        </v-card-text>
                                    </v-card>
                                </v-expansion-panel-content>
                                <v-card>
                                    <v-card-actions>
                                        <v-btn flat block @click.prevent="showCreateContactForm = !showCreateContactForm">Agregar contacto</v-btn>
                                        <v-btn flat block @click.prevent="showAddProvider = !showAddProvider">Agregar Proveedor</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-expansion-panel>
                        </v-flex>
                    </transition>
                    <transition enter-active-class="animated flipInY">
                        <v-flex md3 xs12 class="mt-2 pb-3 pr-3" v-if="showCreateContactForm">
                            <contact-form
                                    @contactSuccessfullyAdded="pushNewContact"
                                    @closeContact="showCreateContactForm = false"
                                    :unitId="ticket.unit_id"
                            ></contact-form>
                        </v-flex>
                        <v-flex md3 xs12 class="mt-2 pb-3 pr-3" v-else-if="showAddProvider">
                            <add-provider-form
                                    @providerSuccessfullyAdded="pushNewContact"
                                    @closeAddProvider="showAddProvider = false"
                                    :unitId="ticket.unit_id"
                            ></add-provider-form>
                        </v-flex>
                    </transition>
                </v-layout>
                <v-divider></v-divider>
                <transition enter-active-class="animated fade">
                    <div v-if="!editMode">
                        <h5 class="pl-4 pt-3"><v-icon>attach_file</v-icon> Archivos Adjuntos</h5>
                        <v-divider v-if="!editMode"></v-divider>
                        <v-btn class="blue-grey white--text right mt-3" @click.prevent="showUpdateForm = !showUpdateForm">
                            Agregar actualización
                            <v-icon right dark>reply</v-icon>
                        </v-btn>
                        <v-subheader>Actualizaciones</v-subheader>
                        <transition enter-active-class="animated slideInLeft">
                            <div v-if="showUpdateForm">
                                <h4 class="primary--text ml-2">Describa la actualización</h4>
                                <update-ticket-form
                                        @closeTicketUpdate="showUpdateForm = false"
                                        :ticketId="ticketId">
                                </update-ticket-form>
                            </div>
                        </transition>
                        <v-list three-line subheader>
                            <v-list-tile avatar v-for="update in ticket.updates" :key="update.id">
                                <v-list-tile-action>
                                    <div class="subheading">{{ update.created_at | fullDateAndTime}}</div>
                                </v-list-tile-action>
                                <v-list-tile-content>
                                    <v-list-tile-title>{{ update.userName }}
                                        <span v-if="update.due_date != null" class="error--text">
                                            <v-icon class="error--text">event</v-icon> {{ update.due_date | fullDateAndTime }}
                                        </span>
                                    </v-list-tile-title>
                                    <v-list-tile-sub-title v-html="nToBr(update.description)"></v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list>
                    </div>
                </transition>
                <transition enter-active-class="animated fadeInUp">
                    <div class="text-xs-center" v-if="editMode"><br>
                        <v-btn class="blue--text darken-1" @click.prevent="editMode = false" flat>Cancelar</v-btn>
                        <v-btn dark success @click.prevent="submitTicketUpdateForm">Guardar</v-btn>
                    </div>
                </transition>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    import { isUrgent, isUnassigned } from '../utilities/helpers'
    import UpdateTicketForm from './UpdateTicketForm'
    import ContactForm from './ContactForm'
    import AddProviderForm from './AddProviderForm'

    export default {
        components: { UpdateTicketForm, ContactForm, AddProviderForm },

        props: {
            ticketId: {
                type: Number,
                required: true
            },
            dialog: {
                type: Boolean,
                required: true,
                default: false
            }
        },

        data() {
            return {
                ticket: null,
                editMode: false,
                activeList: 'success',
                form: {},
                showUpdateForm: false,
                showCloseTicketForm: false,
                showCreateContactForm: false,
                showAddProvider: false
            }
        },

        computed: {
            users() {
                return this.$store.getters.users
            },
            statuses() {
                return this.$store.getters.statuses
            },
            severities() {
                return this.$store.getters.severities
            },

            // Validation rules
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

        created() {
            let ticket = this.$store.getters.ticketById(this.ticketId) // Check if ticket is already loaded in the store
            if(ticket != undefined) {
                this.setComponent(ticket)
            } else { // Else go ask the API for the ticket
                axios.get(window.App.internal_api.getTickets + '/' + this.ticketId)
                    .then((response) => {
                        this.setComponent(response.data)
                    }).catch((error) => {
                    this.$notify({
                        group: 'error',
                        title: 'Ticket no encontrado!',
                        text: 'El ticket no existe o está cerrado',
                        duration: 40000
                    });
                        console.log(error)
                    }
                );
            }

        },

        methods: {
            nToBr(text) {
                return text.replace(/\n/g, "<br />")
            },
            setComponent(ticket) {
                this.ticket = ticket // Set ticket

                this.form = new Form(ticket) // Set form

                if(isUrgent(ticket)) { // Set activeList
                    this.activeList = 'error'
                } else if(isUnassigned(ticket)) {
                    this.activeList = 'warning'
                }
            },
            closeTab(){
                this.$emit('closeTab')
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

            submitTicketUpdateForm() {
                this.form.post(window.App.internal_api.postTicket + '/' + this.ticketId)
                    .then((response) => {

                        this.$notify({
                            group: 'success',
                            title: 'Ticket actualizado!',
                            text: 'El ticket se actualizo correctamente',
                            duration: 5000
                        });

                        this.$store.commit('update_tickets', response)
                        this.setComponent(response)
                        this.editMode = false
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            pushNewContact(contact) {
                this.ticket.unit.contacts.push(contact)
            }
        }
    }
</script>

<style scoped="">
    .layout {
        margin-right: 0px;
        margin-left: 0px;
    }
</style>