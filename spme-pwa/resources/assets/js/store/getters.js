import { isUrgent, isUnassigned, isOpenTask    } from '../utilities/helpers'

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
     * Get all tasks
     * @param state
     * @returns {Array}
     */
    tasks(state) {
        return state.tasks;
    },

    /**
     * Fet task by id
     * @param state
     * @param getters
     */
    taskById: (state, getters) => (taskId) => {
        return state.tasks.find(task => task.id === taskId);
    },

    /**
     * Urgent Tasks
     * @param state
     * @returns {Array.<*>}
     */
    urgentTasks(state){
        const tasks = state.tasks.filter((task) => {
            return isUrgent(task);
        });

        return tasks;
    },

    /**
     * Unassigned Tasks
     * @returns {Array.<*>}
     */
    unassignedTasks(state){
        const tasks = state.tasks.filter((task) => {
            return isUnassigned(task)
        });

        return tasks;
    },

    /**
     * Open Tasks
     * @returns {Array.<*>}
     */
    openTasks(state){
        const tasks = state.tasks.filter((task) => {
            return isOpenTask(task)
        });

        return tasks;
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
     * Get all clients
     * @param state
     * @returns {Array}
     */
    clients(state) {
        return state.clients;
    },

    /**
     * Fet client by id
     * @param state
     * @param getters
     */
    clientById: (state, getters) => (clientId) => {
        return state.clients.find(client => client.id === clientId);
    },

    statuses(state) {
        return state.statuses;
    },

    priorities(state) {
        return state.priorities;
    },
}