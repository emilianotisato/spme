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
                <v-card hover dark class="warning" @click.prevent="activeList = 'warning'">
                    <v-card-text>
                        <span class="title" :class="{'activeListSelect' : activeList == 'warning'}">
                            Sin Asignar
                        </span>

                        <span class="right">
                            <v-btn class="grey darken-1 elevation-1" dark>
                            <v-icon dark left>alarm_add</v-icon> {{ unassignedTickets.length }}
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
        <a @click.prevent.stop="print()"><v-icon left>print</v-icon> Imprimir</a>

        <v-card>
            <v-card-title>
                Tickets
                <v-spacer></v-spacer>
                <v-text-field
                        append-icon="search"
                        label="Buscar"
                        single-line
                        v-model="search"
                        @input="searchInputChange"
                ></v-text-field>
            </v-card-title>
            <v-data-table
                    id="forPrint"
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
                    <td class="text-xs-left" @click.stop="showTicketTab(props.item)">
                        <span v-if="props.item.assigned">{{ props.item.assigned.name }}</span>
                        <span v-else>Sin Asignar</span></td>
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
                previousActiveList: 'Nah ah!',
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
                    { align: 'left', text: 'Asignado a', value: 'assigned.name' },
                    { align: 'left', text: 'Proveedores', value: 'Proveedores' },
                ],
                items: [],
                selectedTicket: {ticket_status:{label:''},ticket_severity:{label:''},assigned:{name:''}},
                openTicket: false
            }
        },

        computed: {
            urgentTickets() {
                const urgentTickets = this.$store.getters.urgentTickets;
                urgentTickets.length >= 1 ? this.activeList = 'error' : 'warning';
                return urgentTickets;
            },
            unassignedTickets(){
                const unassignedTickets = this.$store.getters.unassignedTickets;
                if(this.urgentTickets < 1){
                    unassignedTickets.length >= 1 ? this.activeList = 'warning' : 'success';
                }
                return unassignedTickets;
            },
            openTickets(){
                return this.$store.getters.openTickets;
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
            searchInputChange(val) {
                if(val != '') {
                    if(this.previousActiveList == 'Nah ah!') { // Just to check if it's the first stroke
                        [this.previousActiveList, this.activeList] = [this.activeList, this.previousActiveList]
                    }
                } else {
                    [this.previousActiveList, this.activeList] = [this.activeList, this.previousActiveList]
                }
            },

            showTicketTab(ticket){
                this.selectedTicket = ticket;
                this.openTicket = true;
            },
            closeTicketTab(){
                this.openTicket = false;
                this.selectedTicket = {};
            },
            print() {
                printJS('forPrint', 'html')
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