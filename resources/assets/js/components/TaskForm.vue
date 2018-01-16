<template>
<div v-if="userCan('create_tasks')">
    <v-btn fab bottom right color="deep-orange accent-4" dark fixed
        @click.stop="openTaskForm = !openTaskForm">
        <v-icon>add</v-icon>
    </v-btn>
    <v-dialog v-model="openTaskForm" width="800px">
    <form @submit.prevent="onSubmit"
        @change="form.errors.clear($event.target.name)"
        @keydown="form.errors.clear($event.target.name)">

        <v-card>
            <v-card-title class="grey lighten-4 py-4 title">Crear tarea</v-card-title>
                <v-container grid-list-sm class="pa-4">
                    <v-layout row wrap>
                        <v-flex md6 xs12>
                            <simple-input-form v-if="clientForm"
                                :postUrl="clientPostUrl"
                                label="Nombre del cliente"
                                @cancel="clientForm = false"
                                @created="clientCreated"
                                ></simple-input-form>
                            <v-layout row wrap v-else>
                                <v-flex xs10>
                                    <v-select
                                        dense
                                        label="Cliente"
                                        :items="clients"
                                        item-value="id"
                                        item-text="name"
                                        autocomplete
                                        v-model="activeClientId"
                                        @change="setActiveProjects"
                                    ></v-select>
                            </v-flex>
                            <v-flex xs2>
                                <v-btn flat icon @click.prevent="clientForm = true"><v-icon>add_circle_outline</v-icon></v-btn>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex md6 xs12>
                            <simple-input-form v-if="projectForm"
                                :postUrl="projectPostUrl"
                                label="Nombre del proyecto"
                                @cancel="projectForm = false"
                                @created="projectCreated"
                                ></simple-input-form>
                            <v-layout row wrap v-else>
                                <v-flex xs10>
                                    <v-select
                                        dense
                                        label="Proyecto"
                                        :error-messages="errorProject"
                                        :items="activeProjects"
                                        item-value="id"
                                        item-text="name"
                                        autocomplete
                                        v-model="form.project_id"
                                    ></v-select>
                            </v-flex>
                            <v-flex xs2>
                                <v-btn flat icon @click.prevent="projectForm = true"><v-icon>add_circle_outline</v-icon></v-btn>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex xs12>
                        <v-text-field
                            placeholder="Titulo de la tarea"
                            v-model="form.subject"
                            :error-messages="errorSubject"
                        ></v-text-field>
                        </v-flex>
                        <v-flex md4 xs12>
                            <v-select
                                label="Prioridad"
                                :error-messages="errorPriority"
                                :items="priorities"
                                item-value="id"
                                item-text="label"
                                autocomplete
                                v-model="form.priority_id"
                            ></v-select>
                        </v-flex>
                        <v-flex md4 xs12>
                            <v-select
                                label="Estado"
                                :error-messages="errorStatus"
                                :items="statuses"
                                item-value="id"
                                item-text="label"
                                autocomplete
                                v-model="form.status_id"
                            ></v-select>
                        </v-flex>
                        <v-flex md4 xs12>
                            <v-select
                                label="Asignar a"
                                :error-messages="errorUser"
                                :items="users"
                                item-value="id"
                                item-text="name"
                                autocomplete
                                v-model="form.assigned_user"
                            ></v-select>
                        </v-flex>
                        <v-flex xs12>
                        <v-text-field
                            multi-line
                            prepend-icon="notes"
                            placeholder="Descripcion"
                            :error-messages="errorDescription"
                            v-model="form.description"
                        ></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-card-actions>
                    <div v-if="form.hide_client">
                        <v-btn @click.prevent="form.hide_client = false" flat icon color="grey">
                            <v-icon>visibility_off</v-icon>
                        </v-btn>
                        <span class="caption grey--text">No se muestra al cliente</span>
                    </div>
                    <div v-else>
                        <v-btn @click.prevent="form.hide_client = true" flat icon color="green">
                            <v-icon>visibility</v-icon>
                        </v-btn>
                        <span class="caption grey--text">Visible al cliente</span>
                    </div>
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="openTaskForm = false">Cancelar</v-btn>
                    <v-btn flat @click="submitForm">Crear</v-btn>
                </v-card-actions>
        </v-card>

    </form>
    </v-dialog>
</div>

</template>

<script>
import SimpleInputForm from './SimpleInputForm'

export default {

    components: { SimpleInputForm },

    data () {
            return {
                openTaskForm: false,
                clientForm: false,
                projectForm: false,
                form: new App.form({
                    assigned_user: '',
                    project_id: '',
                    priority_id: '',
                    status_id: 1,
                    hide_client: false,
                    subject: '',
                    description: '',
                    closed: null
                }),
                activeClientId: '',
                activeProjects: []

            }
        },

        computed: {
            users() {
                return this.$store.getters.users
            },
            clients() {
                return this.$store.getters.clients
            },
            statuses() {
                return this.$store.getters.statuses
            },
            priorities() {
                return this.$store.getters.priorities
            },


            // Validations
            errorProject() {
                return this.form.errors.has('project_id') ? this.form.errors.get('project_id') : undefined
            },
            errorSubject() {
                return this.form.errors.has('subject') ? this.form.errors.get('subject') : undefined
            },
            errorDescription() {
                return this.form.errors.has('description') ? this.form.errors.get('description') : undefined
            },
            errorPriority() {
                return this.form.errors.has('priority_id') ? this.form.errors.get('priority_id') : undefined
            },
            errorStatus() {
                return this.form.errors.has('status_id') ? this.form.errors.get('status_id') : undefined
            },
            errorUser() {
                return this.form.errors.has('assigned_user') ? this.form.errors.get('assigned_user') : undefined
            },

            // Post urls
            clientPostUrl() {
                return App.api.postClient
            },
            projectPostUrl() {
                return App.api.postProject + '/' + this.activeClientId
            }
        },

        methods: {
            setActiveProjects(clientId) {
                this.activeClientId = clientId
                this.form.project_id = ''

                let projects = this.$store.getters.clientById(clientId).projects
                if (projects && projects.length >= 1) {
                    this.activeProjects = projects
                } else {
                    this.activeProjects = []
                    this.projectForm = true
                }
            },

            setStatus() {
                this.form.status_id = 2
            },

            setUser(statusId) {
                if(statusId == 1) {
                    this.form.assigned_user = ''
                    this.form.status_id = 1
                }
            },

            resetFormAndClose() {
                this.form.reset()
                this.form.status_id = 1
                this.openTaskForm = false
            },

            submitForm() {
                this.form.post(window.App.api.postTask)
                    .then((response) => {

                        this.resetFormAndClose()
                        this.$notify({
                            group: 'success',
                            title: 'Tarea creado!',
                            text: 'La tarea se creó correctamente',
                            duration: 5000
                        });

                        this.$store.commit('set_tasks', {task: response, tasks: null});
                        this.$router.push({ name: 'task', params: {id: response.id}});
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            clientCreated(client) {
                this.$store.commit('update_clients', {action: 'create', object: client})

                this.setActiveProjects(client.id)

            },

            projectCreated(project) {
                this.$store.commit('update_projects', {action: 'create', object: project})
                this.activeProjects.push(project)
                this.form.project_id = project.id
            }
        }

}
</script>

<style scoped>
    .input-group--select {
        white-space: nowrap !important;
    }
</style>
