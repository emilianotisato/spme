<template>
    <v-layout row justify-center v-if="task != null">
        <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition" :overlay="false">
            <v-card>
                <v-toolbar dark :class="priorityColor">
                    <v-btn icon @click.stop="closeTab" dark>
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Tarea {{ task.id }} <span class="hidden-sm-and-down" @click="editSubject">| {{ task.subject }}</span></v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark flat @click.stop="showCloseTaskForm = !showCloseTaskForm"><v-icon dark left>done_all</v-icon> <span class="hidden-sm-and-down">Marcar como Finalizado</span></v-btn>
                        <v-menu bottom left>
                            <v-btn icon slot="activator" dark>
                                <v-icon>more_vert</v-icon>
                            </v-btn>
                            <v-list>
                            <v-list-tile @click="">
                                <v-list-tile-title>Eliminar</v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile @click="">
                                <v-list-tile-title>Posponer</v-list-tile-title>
                            </v-list-tile>
                            </v-list>
                        </v-menu>
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
                                                <v-list-tile ripple @click="$refs.assigned_user.$el.firstChild.click()">
                                                    <v-list-tile-content>
                                                        <!-- <v-list-tile-title v-if="task.assigned">{{ task.assigned.name }}</v-list-tile-title> -->
                                                        <editable-select
                                                        v-if="task.assigned"
                                                        ref="assigned_user"
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
                                                        ref="assigned_user"
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
                                                <v-list-tile ripple @click="$refs.priority_id.$el.firstChild.click()">
                                                    <v-list-tile-content>
                                                        <!-- <v-list-tile-title>{{ task.priority.label }}</v-list-tile-title> -->
                                                        <editable-select
                                                        ref="priority_id"
                                                        name="priority_id"
                                                        :value="task.priority.label"
                                                        :items="$store.getters.priorities"
                                                        itemText="label"
                                                        itemValue="id"
                                                        label="Prioridad"
                                                        :patchUrl="patchUrl"
                                                        @updated="updateTask">
                                                        </editable-select>
                                                        <v-list-tile-sub-title>Prioridad</v-list-tile-sub-title>
                                                    </v-list-tile-content>
                                                    <v-list-tile-action>
                                                        <v-icon :color="priorityColor">error_outline</v-icon>
                                                    </v-list-tile-action>
                                                </v-list-tile>
                                                <v-divider></v-divider>
                                                <v-list-tile ripple @click="$refs.status_id.$el.firstChild.click()">
                                                    <v-list-tile-content>
                                                        <!-- <v-list-tile-title>{{ task.status.label }}</v-list-tile-title> -->
                                                        <editable-select
                                                        ref="status_id"
                                                        name="status_id"
                                                        :value="task.status.label"
                                                        :items="$store.getters.statuses"
                                                        itemText="label"
                                                        itemValue="id"
                                                        label="Estado"
                                                        :patchUrl="patchUrl"
                                                        @updated="updateTask">
                                                        </editable-select>
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
                            <update-form :taskId="task.id"></update-form>
                            <div class="ma-3" v-for="update in task.updates" :key="update.id">
                                <v-avatar size="36px" slot="activator">
                                    <img src="https://avatars1.githubusercontent.com/u/18596215?s=460&v=4" alt="">
                                </v-avatar>
                                {{ update.userName }} <span>{{ update.created_at | fullDateAndTime}}</span>
                                <blockquote class="updates elevation-1 pa-3" v-html="$options.filters.nToBr(update.description)"></blockquote>
                                <p class="ml-5 py-2" v-if="authUser.id == update.user_id">
                                    <a>Editar</a> -
                                    <v-menu bottom offset-y>
                                        <a class="text--grey" slot="activator">Eliminar</a>
                                        <v-card elevation-2>
                                            <v-card-text>
                                                <p>¿Seguro desea eliminar el comentario?</p>
                                                <v-btn @click="deleteUpdate(update)" block color="error" dark>Eliminar</v-btn>
                                            </v-card-text>
                                        </v-card>
                                    </v-menu>
                                </p>
                            </div>
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
    import UpdateForm from './UpdateForm'
    import EditableSelect from './EditableSelect'
    import EditableTextField from './EditableTextField'

    export default {

        components: { ExtraInfo, UpdateForm, EditableTextField, EditableSelect },

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
                form: {},
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
                if(isHighPriority(this.task)) {
                    return 'error'
                } else if(isUnassigned(this.task)) {
                    return 'warning'
                } else {
                    return 'success'
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
            },

            deleteUpdate(update) {
                App.axios.post(App.api.deleteTaskUpdate, update)
                .then((response) => {
                    this.updateTask(response.data)
                })

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

    .updates {
        border-left: solid 3px grey;
        margin-left: 42px;
    }

</style>