import { isUrgent, isUnassigned, isOpenTicket    } from '../utilities/helpers'

export default {

    /**
     * Get auth user
     * @param state
     * @returns {object}
     */
    auth_user(state) {
        return state.auth_user;
    },

    /**
     * Get all tickets
     * @param state
     * @returns {Array}
     */
    tickets(state) {
        return state.tickets;
    },

    /**
     * Fet ticket by id
     * @param state
     * @param getters
     */
    ticketById: (state, getters) => (ticketId) => {
        return state.tickets.find(ticket => ticket.id === ticketId);
    },

    /**
     * Urgent Tickets
     * @param state
     * @returns {Array.<*>}
     */
    urgentTickets(state){
        const tickets = state.tickets.filter((ticket) => {
            return isUrgent(ticket);
        });

        return tickets;
    },

    /**
     * Unassigned Tickets
     * @returns {Array.<*>}
     */
    unassignedTickets(state){
        const tickets = state.tickets.filter((ticket) => {
            return isUnassigned(ticket)
        });

        return tickets;
    },

    /**
     * Open Tickets
     * @returns {Array.<*>}
     */
    openTickets(state){
        const tickets = state.tickets.filter((ticket) => {
            return isOpenTicket(ticket)
        });

        return tickets;
    },

    /**
     * Get all users
     * @param state
     * @returns {Array}
     */
    users(state) {
        return state.users;
    },

    /**
     * Get all providers
     * @param state
     * @returns {Array}
     */
    providers(state) {
        return state.providers;
    },

    /**
     * Get all buildings
     * @param state
     * @returns {Array}
     */
    buildings(state) {
        return state.buildings;
    },

    /**
     * Fet building by id
     * @param state
     * @param getters
     */
    buildingById: (state, getters) => (buildingId) => {
        return state.buildings.find(building => building.id === buildingId);
    },

    statuses(state) {
        return state.statuses;
    },

    severities(state) {
        return state.severities;
    },
}