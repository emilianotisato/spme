<template>
    <div class="animated fadeIn">
        <v-layout row wrap>
            <v-flex md4 xs12 class="px-1">
                <v-card hover dark class="error" @click.native="activeList = 'error'">
                    <v-card-text>
                        <span class="title" :class="{'activeListSelect' : activeList == 'error'}">
                            Alta Prioridad
                        </span>

                        <span class="right animated" :class="{'shake' : highPriority.length >= 1}">
                            <v-btn class="grey darken-1 elevation-1" dark>
                            <v-icon dark left>alarm_off</v-icon> {{ highPriority.length }}
                        </v-btn>
                        </span>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex md4 xs12 class="px-1">
                <v-card hover dark class="warning" @click.native="activeList = 'warning'">
                    <v-card-text>
                        <span class="title" :class="{'activeListSelect' : activeList == 'warning'}">
                            Sin Asignar
                        </span>

                        <span class="right">
                            <v-btn class="grey darken-1 elevation-1" dark>
                            <v-icon dark left>alarm_add</v-icon> {{ unassignedTasks.length }}
                        </v-btn>
                        </span>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex md4 xs12 class="px-1">
                <v-card hover dark class="success" @click.native="activeList = 'success'">
                    <v-card-text>
                        <span class="title" :class="{'activeListSelect' : activeList == 'success'}">
                            Estables
                        </span>

                        <span class="right">
                            <v-btn class="grey darken-1 elevation-1" dark>
                            <v-icon dark left>alarm_on</v-icon> {{ openTasks.length }}
                        </v-btn>
                        </span>
                    </v-card-text>
                </v-card>
            </v-flex>

        </v-layout>

        <v-card>
            <v-card-title>
                Tasks
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
                <template slot="items" slot-scope="props">
                    <td class="text-xs-left" @click.stop="showTaskTab(props.item)">{{ props.item.id }}</td>
                    <td class="text-xs-left" @click.stop="showTaskTab(props.item)">{{ props.item.projectFullName }}</td>
                    <td class="text-xs-left" @click.stop="showTaskTab(props.item)">{{ props.item.subject }}</td>
                    <td class="text-xs-left" @click.stop="showTaskTab(props.item)">{{ props.item.created_at | justDate }}</td>
                    <td class="text-xs-left" @click.stop="showTaskTab(props.item)">{{ props.item.priority.label }}</td>
                    <td class="text-xs-left" @click.stop="showTaskTab(props.item)">{{ props.item.status.label }}</td>
                    <td class="text-xs-left" @click.stop="showTaskTab(props.item)">
                        <span v-if="props.item.assigned">{{ props.item.assigned.name }}</span>
                        <span v-else>Sin Asignar</span></td>
                </template>
                <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                    Desde {{ pageStart }} hasta {{ pageStop }}
                </template>
            </v-data-table>
        </v-card>
        <task @closeTab="openTask = false" :taskId="selectedTask.id" :dialog="openTask" v-if="openTask"></task>
    </div>
</template>

<script>
    import Task from '../components/Task';

    export default {
        components: { Task },

        data() {
            return {
                activeList: 'success',
                previousActiveList: 'Nah ah!',
                search: '',
                pagination: {},
                rowsPerPage: [10, 20, 30, { text: "Todos", value: -1 }],
                headers: [
                    { align: 'left', text: 'Task', value: 'id' },
                    { align: 'left', text: 'Cliente/Proyecto', value: 'projectFullName' },
                    { align: 'left', text: 'Asunto', value: 'subject' },
                    { align: 'left', text: 'Abierto el', value: 'created_at' },
                    { align: 'left', text: 'Urgencia', value: 'priority.label' },
                    { align: 'left', text: 'Estado', value: 'status.label' },
                    { align: 'left', text: 'Asignado a', value: 'assigned.name' },
                ],
                items: [],
                selectedTask: {status:{label:''},priority:{label:''},assigned:{name:''}},
                openTask: false
            }
        },

        computed: {
            highPriority() {
                const highPriority = this.$store.getters.highPriority;
                highPriority.length >= 1 ? this.activeList = 'error' : 'warning';
                return highPriority;
            },
            unassignedTasks(){
                const unassignedTasks = this.$store.getters.unassignedTasks;
                if(this.highPriority < 1){
                    unassignedTasks.length >= 1 ? this.activeList = 'warning' : 'success';
                }
                return unassignedTasks;
            },
            openTasks(){
                return this.$store.getters.openTasks;
            },
            selectedList(){
                switch(this.activeList) {
                    case 'error':
                        return this.items = this.highPriority;
                        break;
                    case 'warning':
                        return this.items = this.unassignedTasks;
                        break;
                    case 'success':
                        return this.items = this.openTasks;
                        break;
                    default:
                        return this.items = this.$store.getters.tasks;
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

            showTaskTab(task){
                this.selectedTask = task;
                this.openTask = true;
            },
            closeTaskTab(){
                this.openTask = false;
                this.selectedTask = {};
            }
        }

    }
</script>

<style scoped>
    td {
        cursor: pointer;
    }
    .activeListSelect {text-shadow: 1px 1px 2px #efefef; color: #5f5757;}
</style>