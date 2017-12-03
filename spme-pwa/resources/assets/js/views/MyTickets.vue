<template>
    <div class="animated fadeIn">
        <v-layout row wrap>
            <v-flex md4 xs12>
                <v-card hover dark class="error" @click.prevent="activeList = 'error'">
                    <v-card-text>
                        <span class="title" :class="{'activeListSelect' : activeList == 'error'}">
                            Urgentes
                        </span>

                        <span class="right animated" :class="{'shake' : urgentTickets.length >= 1}">
                            <v-btn class="grey darken-1 elevation-1" dark>
                            <v-icon dark left>alarm_off</v-icon> {{ urgentTickets.length }}
                        </v-btn>
                        </span>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex md4 xs12>
                <v-card hover dark class="success" @click.prevent="activeList = 'success'">
                    <v-card-text>
                        <span class="title" :class="{'activeListSelect' : activeList == 'success'}">
                            Abiertos
                        </span>

                        <span class="right">
                            <v-btn class="grey darken-1 elevation-1" dark>
                            <v-icon dark left>alarm_on</v-icon> {{ openTickets.length }}
                        </v-btn>
                        </span>
                    </v-card-text>
                </v-card>
            </v-flex>

        </v-layout>

        <v-card>
            <v-card-title>
                Tickets
                <v-spacer></v-spacer>
                <v-text-field
                        append-icon="search"
                        label="Buscar"
                        single-line
                        v-model="search"
                ></v-text-field>
            </v-card-title>
            <v-data-table
                    class="elevation-1"
                    no-data-text="No hay datos"
                    no-results-text="No encontramos resultados"
                    rows-per-page-text="Columnas por página"
                    :headers="headers"
                    :items="selectedList"
                    :rows-per-page-items="rowsPerPage"
                    :search="search"
            >
                <template slot="items" scope="props">
                    <td class="text-xs-left" @click.stop="showTicketTab(props.item)">{{ props.item.id }}</td>
                    <td class="text-xs-left" @click.stop="showTicketTab(props.item)">{{ props.item.unitFullName }}</td>
                    <td class="text-xs-left" @click.stop="showTicketTab(props.item)">{{ props.item.subject }}</td>
                    <td class="text-xs-left" @click.stop="showTicketTab(props.item)">{{ props.item.created_at | justDate }}</td>
                    <td class="text-xs-left" @click.stop="showTicketTab(props.item)">{{ props.item.ticket_severity.label }}</td>
                    <td class="text-xs-left" @click.stop="showTicketTab(props.item)">{{ props.item.ticket_status.label }}</td>
                    <td class="text-xs-left" @click.stop="showTicketTab(props.item)">{{ props.item.Proveedores }}</td>
                </template>
                <template slot="pageText" scope="{ pageStart, pageStop }">
                    Desde {{ pageStart }} hasta {{ pageStop }}
                  </template>
            </v-data-table>
        </v-card>
        <ticket @closeTab="openTicket = false" :ticketId="selectedTicket.id" :dialog="openTicket" v-if="openTicket"></ticket>
    </div>
</template>

<script>
    import Ticket from './../components/Ticket';

    export default {
        components: { Ticket },

        data() {
            return {
                activeList: 'success',
                search: '',
                pagination: {},
                rowsPerPage: [10, 20, 30, { text: "Todos", value: -1 }],
                headers: [
                    { align: 'left', text: 'Ticket', value: 'id' },
                    { align: 'left', text: 'Edificio/Unidad', value: 'unitFullName' },
                    { align: 'left', text: 'Asunto', value: 'subject' },
                    { align: 'left', text: 'Abierto el', value: 'created_at' },
                    { align: 'left', text: 'Urgencia', value: 'ticket_severity.label' },
                    { align: 'left', text: 'Estado', value: 'ticket_status.label' },
                    { align: 'left', text: 'Proveedores', value: 'Proveedores' },
                ],
                items: [],
                selectedTicket: {ticket_status:{label:''},ticket_severity:{label:''},assigned:{name:''}},
                openTicket: false
            }
        },

        computed: {
            urgentTickets() {
                const ALLurgentTickets = this.$store.getters.urgentTickets;

                const urgentTickets = ALLurgentTickets.filter((ticket) => {
                    return ticket.assigned_user == this.$store.state.auth_user.id
                });

                urgentTickets.length >= 1 ? this.activeList = 'error' : 'warning';
                return urgentTickets;
            },
            unassignedTickets(){
                return [] // I dont need them here for the user
            },
            openTickets(){
                const ALLopenTickets = this.$store.getters.openTickets;

                const openTickets = ALLopenTickets.filter((ticket) => {
                    return ticket.assigned_user == this.$store.state.auth_user.id
                });

                if(this.urgentTickets < 1){
                    openTickets.length >= 1 ? this.activeList = 'warning' : 'success';
                }
                return openTickets;
            },
            selectedList(){
                switch(this.activeList) {
                    case 'error':
                        return this.items = this.urgentTickets;
                        break;
                    case 'warning':
                        return this.items = this.unassignedTickets;
                        break;
                    case 'success':
                        return this.items = this.openTickets;
                        break;
                    default:
                        return this.items = this.$store.getters.tickets;
                }
            }
        },

        methods: {
            showTicketTab(ticket){
                this.selectedTicket = ticket;
                this.openTicket = true;
            },
            closeTicketTab(){
                this.openTicket = false;
                this.selectedTicket = {};
            }
        }

    }
</script>

<style scoped="">
    td {
        cursor: pointer;
    }
    .activeListSelect {text-shadow: 1px 1px 2px #efefef; color: #5f5757;}
</style>