import Vue from 'vue';
import Vuex from 'vuex';

import actions from './actions';
import getters from './getters';
import mutations from './mutations';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        auth_user: {},
        tasks: [],
        users: [],
        clients: [],
        statuses: [],
        priorities: [],
        openTaskForm: false
    },
    getters,
    mutations,
    actions
});