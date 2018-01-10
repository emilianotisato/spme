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
                <v-layout row wrap>
                    <v-flex md4 xs12 class="px-1">
                        <v-card height="400px">
                            <v-card-text>
                                Ok
                            </v-card-text>
                            <v-bottom-nav
                            absolute
                            :value="true"
                            color="light-green darken-2"
                            style="justify-content: left;"
                            >
                            <div class="lastUpdate">
                                <v-icon dark left>updated</v-icon> {{ task.updated_at | fullDateAndTime }}
                            </div>
                            </v-bottom-nav>
                        </v-card>
                    </v-flex>
                    <v-flex md4 xs12 class="px-1">
                        <v-card height="400px">
                            <v-card-text>
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
                            </v-card-text>
                            <v-bottom-nav
                            absolute
                            :value="true"
                            color="grey lighten-1"
                            style="justify-content: left;"
                            >
                            <v-btn dark>
                                <span>Archivos</span>
                                <v-icon>note_add</v-icon>
                            </v-btn>
                            <v-btn dark>
                                 <v-badge left>
                                <span slot="badge">6</span>
                                <v-icon>folder_open</v-icon>
                                 </v-badge>
                            </v-btn>
                            </v-bottom-nav>
                        </v-card>
                    </v-flex>
                    <v-flex md4 xs12 class="px-1">
                        <v-card height="400px">
                            <extra-info></extra-info>
                        </v-card>
                    </v-flex>
                </v-layout>
                <v-divider></v-divider>
                <v-layout row wrap>
                    <v-flex>Parte inferior</v-flex>
                </v-layout>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    import { isHighPriority, isUnassigned } from '../utilities/helpers';
    import ExtraInfo from './ExtraInfo'
    import EditableTextField from './EditableTextField'

    export default {

        components: { ExtraInfo, EditableTextField },

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
    .lastUpdate i {
        width: 10px;
    }
</style>