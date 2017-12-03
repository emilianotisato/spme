// import localforage from 'localforage';

export default {

    set_auth_user(context){
        return axios.get(window.App.internal_api.getUser)
            .then(function (response) {

                context.commit('set_auth_user', response.data); // Commit to store state

                return true; // This is in order to resolve initStoreState() in vm0
            }).catch(error => console.log(error));
    },

    set_tickets(context){
        return axios.get(window.App.internal_api.getTickets)
            .then(function (response) {

                context.commit('set_tickets', {ticket: null, tickets: response.data});

                return true;
            }).catch(error => console.log(error));
    },

    set_users(context){
        return axios.get(window.App.internal_api.getUsers)
            .then(function (response) {

                context.commit('set_users', response.data);

                return true;
            }).catch(error => console.log(error));
    },

    set_providers(context){
        return axios.get(window.App.internal_api.getProviders)
            .then(function (response) {

                context.commit('set_providers', response.data);

                return true;
            }).catch(error => console.log(error));
    },

    set_buildings(context){
        return axios.get(window.App.internal_api.getBuildings)
            .then(function (response) {

                context.commit('set_buildings', response.data);

                return true;
            }).catch(error => console.log(error));
    },

    set_statuses(context){
        return axios.get(window.App.internal_api.getStatuses)
            .then(function (response) {

                context.commit('set_statuses', response.data);

                return true;
            }).catch(error => console.log(error));
    },

    set_severities(context){
        return axios.get(window.App.internal_api.getSeverities)
            .then(function (response) {

                context.commit('set_severities', response.data);

                return true;
            }).catch(error => console.log(error));
    }

}