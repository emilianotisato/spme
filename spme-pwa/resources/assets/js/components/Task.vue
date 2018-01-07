<template>
    <v-layout row justify-center v-if="task != null">
        <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition" :overlay=false>
            <v-card>
                <v-toolbar dark :class="activeList">
                    <v-btn icon @click.stop="closeTab" dark>
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>Task {{ task.id }} <span class="hidden-sm-and-down">| {{ task.subject }} <v-icon dark>updated</v-icon>{{ task.updated_at | fullDateAndTime }}</span></v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark flat @click.stop="showCloseTaskForm = !showCloseTaskForm"><v-icon dark left>done_all</v-icon> <span class="hidden-sm-and-down">Marcar como Finalizado</span></v-btn>
                        <v-btn dark flat @click.stop="editMode = !editMode"><v-icon dark left>edit</v-icon> <span class="hidden-sm-and-down">Editar</span></v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <v-layout row wrap>
                    Parte superior
                </v-layout>
                <v-divider></v-divider>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    import { isHighPriority, isUnassigned } from '../utilities/helpers'

    export default {

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

        methods: {
            nToBr(text) {
                return text.replace(/\n/g, "<br />")
            },

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
            }
        }
    }
</script>