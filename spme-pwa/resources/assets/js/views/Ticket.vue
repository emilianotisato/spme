<template>
    <div>
        <ticket @closeTab="goToList" :ticketId="selectedTicket" :dialog="openTicket" v-if="openTicket"></ticket>
        <h3 v-else>Cargando...</h3>
    </div>
</template>

<script>
    import Ticket from './../components/Ticket'

    export default {
        components: { Ticket },

        data() {
            return {
                openTicket: false,
                selectedTicket: ''
            }
        },

        created() {
            this.selectedTicket = Number(this.$route.params.ticketId)
            this.openTicket = true

        },

        methods: {
            goToList() {
                this.openTicket = false
                this.$router.push({ name: 'dashboard'});
            }
        }
    }
</script>