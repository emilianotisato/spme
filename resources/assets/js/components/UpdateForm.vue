<template>
    <div>
        <form @submit.prevent="onSubmit"
        @change="form.errors.clear($event.target.name)"
        @keydown="form.errors.clear($event.target.name)">

            <v-text-field box multi-line
            label="Escribir un comentario..."
            :rows="3"
            v-model="form.description"></v-text-field>

            <v-btn type="submit" dark success :disabled="form.description == ''">Guardar</v-btn>

        </form>
    </div>
</template>

<script>
export default {
    props:{
            taskId: {
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
                form: new App.form({
                    task_id: '',
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
            this.form.task_id = this.taskId
            this.form.closed = this.isForClose
        },

        methods: {

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
                this.form.post(window.App.api.postTaskUpdate)
                    .then((response) => {

                        this.$store.commit('update_tasks', response)
                        this.form.reset()

                        if(response.closed != null) {

                            this.$notify({
                                group: 'success',
                                title: 'Tarea cerrada!',
                                text: 'Se cerró la tarea correctamente',
                                duration: 5000
                            });

                            this.$router.push({ name: 'dashboard'})
                            location.reload()

                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }

}
</script>

<style>

</style>
