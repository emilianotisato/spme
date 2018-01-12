<template>
    <v-layout row justify-center v-if="task != null">
        <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition" :overlay="false">
            <v-card>
                <v-toolbar dark :class="activeList">
                    <v-btn icon @click.stop="closeTab" dark>
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Tarea {{ task.id }} <span class="hidden-sm-and-down" @click="editSubject">| {{ task.subject }}</span></v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark flat @click.stop="showCloseTaskForm = !showCloseTaskForm"><v-icon dark left>done_all</v-icon> <span class="hidden-sm-and-down">Marcar como Finalizado</span></v-btn>
                        <v-btn dark flat @click.stop="editMode = !editMode"><v-icon dark left>edit</v-icon> <span class="hidden-sm-and-down">Editar</span></v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <div class="taskContent pt-1">
                    <v-layout row wrap>
                        <v-flex md8 xs12 class="px-1">
                            <v-card>
                                <v-card-text>
                                    <v-layout row wrap>
                                        <v-flex md8 xs12>
                                            <editable-text-field
                                            ref="taskSubject"
                                            name="subject"
                                            label="Nombre"
                                            :patchUrl="patchUrl"
                                            :value="task.subject"
                                            @updated="updateTask"
                                            elementClass="title"
                                            elementStyles="height:80px;"
                                            ></editable-text-field>
                                            <editable-text-field
                                            name="description"
                                            label="Descripcion"
                                            :patchUrl="patchUrl"
                                            :multiline="true"
                                            :value="task.description"
                                            @updated="updateTask"
                                            elementStyles="height:230px;"
                                            ></editable-text-field>
                                        </v-flex>
                                        <v-flex md4 xs12 pa-3 mb-4>
                                            <p class="grey--text pa-3 ma-0">Tarea creada por <strong>{{ task.user.name }}</strong> el {{ task.created_at | justDate }}</p>
                                            <!-- <p class="grey--text px-3 ma-0"><strong>Estado: </strong></p> -->
                                            <v-list two-line>
                                                <v-list-tile ripple @click="$refs.asignedUser.$el.firstChild.click()">
                                                    <v-list-tile-content>
                                                        <!-- <v-list-tile-title v-if="task.assigned">{{ task.assigned.name }}</v-list-tile-title> -->
                                                        <editable-select
                                                        v-if="task.assigned"
                                                        ref="asignedUser"
                                                        name="assigned_user"
                                                        :value="task.assigned.name"
                                                        :items="$store.getters.users"
                                                        itemText="name"
                                                        itemValue="id"
                                                        label="Asignadr a"
                                                        :isNullable="true"
                                                        :patchUrl="patchUrl"
                                                        @updated="updateTask">
                                                        </editable-select>

                                                        <!-- <v-list-tile-title v-else>Sin asignar!</v-list-tile-title> -->
                                                        <editable-select
                                                        v-else
                                                        ref="asignedUser"
                                                        name="assigned_user"
                                                        value="Sin asignar!"
                                                        :items="$store.getters.users"
                                                        itemText="name"
                                                        itemValue="id"
                                                        label="Asignadr a"
                                                        :isNullable="true"
                                                        :patchUrl="patchUrl"
                                                        @updated="updateTask">
                                                        </editable-select>
                                                        <v-list-tile-sub-title>Asignada a</v-list-tile-sub-title>
                                                    </v-list-tile-content>
                                                    <v-list-tile-action>
                                                        <v-icon v-if="task.assigned" color="green">perm_identity</v-icon>
                                                        <v-icon v-else color="red">perm_identity</v-icon>
                                                    </v-list-tile-action>
                                                </v-list-tile>
                                                <v-divider></v-divider>
                                                <v-list-tile ripple @click="">
                                                    <v-list-tile-content>
                                                        <v-list-tile-title>{{ task.priority.label }}</v-list-tile-title>
                                                        <v-list-tile-sub-title>Prioridad</v-list-tile-sub-title>
                                                    </v-list-tile-content>
                                                    <v-list-tile-action>
                                                        <v-icon :color="priorityColor">error_outline</v-icon>
                                                    </v-list-tile-action>
                                                </v-list-tile>
                                                <v-divider></v-divider>
                                                <v-list-tile ripple @click="">
                                                    <v-list-tile-content>
                                                        <v-list-tile-title>{{ task.status.label }}</v-list-tile-title>
                                                        <v-list-tile-sub-title>Estado</v-list-tile-sub-title>
                                                    </v-list-tile-content>
                                                    <v-list-tile-action>
                                                        <v-icon :color="task.status.color">{{ task.status.icon }}</v-icon>
                                                    </v-list-tile-action>
                                                </v-list-tile>
                                            </v-list>
                                        </v-flex>
                                    </v-layout>
                                </v-card-text>
                                <v-bottom-nav
                                absolute
                                :value="true"
                                color="light-green darken-2"
                                style="justify-content: left;"
                                >
                                <div class="lastUpdate">
                                    <v-icon dark left>loop</v-icon>&nbsp;&nbsp;&nbsp;{{ task.updated_at | fullDateAndTime }}
                                </div>
                                </v-bottom-nav>
                            </v-card>
                        </v-flex>
                        <v-flex md4 xs12 class="px-1">
                            <v-card>
                                <extra-info :task="task"></extra-info>
                            </v-card>
                        </v-flex>
                    </v-layout>
                    <v-divider class="my-3"></v-divider>
                    <v-layout row wrap>
                        <v-flex md12 xs12>
                            <v-icon left>comment</v-icon> Comentarios
                        </v-flex>
                        <v-flex md12 xs12>
                            loopear updates
                        </v-flex>
                    </v-layout>
                </div>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    import { isHighPriority, isUnassigned } from '../utilities/helpers';
    import ExtraInfo from './ExtraInfo'
    import EditableSelect from './EditableSelect'
    import EditableTextField from './EditableTextField'

    export default {

        components: { ExtraInfo, EditableTextField, EditableSelect },

        props: {
            taskId: {
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
                task: null,
                // editMode: false,
                activeList: 'success',
                form: {},
                // showUpdateForm: false,
                showCloseTaskForm: false
            }
        },

        created() {
            this.setTask()

        },

        computed: {
            patchUrl() {
                return App.api.postTask + '/' + this.taskId
            },
            priorityColor() {
                let level = this.task.priority.level

                if(level >= 8) {
                    return 'red'
                } else if(level >=5) {
                    return 'yellow'
                } else {
                    return 'green'
                }
            }
        },

        methods: {

            setTask(){
                let task = this.$store.getters.taskById(this.taskId) // Check if task is already loaded in the store

                let checkLoaded = () => {
                    setTimeout(() => {
                    if (task != undefined) {
                        this.task = task // Set task

                        this.form = new App.form(task) // Set form

                        if(isHighPriority(task)) { // Set activeList
                            this.activeList = 'error'
                        } else if(isUnassigned(task)) {
                            this.activeList = 'warning'
                        }
                    } else {
                        checkLoaded();
                    }
                    }, 50);
                };

                checkLoaded();
            },

            closeTab(){
                this.$emit('closeTab')
            },

            editSubject() {
                this.$refs.taskSubject.$el.firstChild.click()
            },

            updateTask(task) {
                this.$store.commit('update_tasks', task);
            }
        }
    }
</script>

<style>
    .taskContent {
        max-width: 1280px;
        margin: auto;
    }

    .taskContent .card {
        height: auto;
        min-height: 400px;
    }

    .lastUpdate {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        color: #fff;
        font-size: 14px;
        font-weight: bold;
        text-shadow: 1px 1px #403f3f;
    }

</style>