<template>
    <task @closeTab="goToList" :taskId="taskId" :dialog="openTask" v-if="openTask"></task>
</template>

<script>
import Task from '../components/Task';

export default {
        components: { Task },

        data() {
            return {
                taskId: '',
                openTask: false
            }
        },


        mounted() {
            this.taskId = Number(this.$route.params.id)
            this.openTask = true

        },

        methods: {
            goToList() {
                this.openTask = false
                this.$router.push({ name: 'dashboard'});
            }
        }


}
</script>

<style>

</style>
