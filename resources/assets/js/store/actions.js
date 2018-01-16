export default {

    set_auth_user(context){
        return App.axios.get(App.api.getUser)
            .then(function (response) {

                context.commit('set_auth_user', response.data); // Commit to store state

                return true; // This is in order to resolve initStoreState() in vm0
            }).catch(error => console.log(error));
    },

    set_tasks(context){
        return App.axios.get(App.api.getTasks)
            .then(function (response) {

                context.commit('set_tasks', {task: null, tasks: response.data});

                return true;
            }).catch(error => console.log(error));
    },

    set_users(context){
        return App.axios.get(App.api.getUsers)
            .then(function (response) {

                context.commit('set_users', response.data);

                return true;
            }).catch(error => console.log(error));
    },

    set_clients(context){
        return App.axios.get(App.api.getClients)
            .then(function (response) {

                context.commit('set_clients', response.data);

                return true;
            }).catch(error => console.log(error));
    },

    set_statuses(context){
        return App.axios.get(App.api.getStatuses)
            .then(function (response) {

                context.commit('set_statuses', response.data);

                return true;
            }).catch(error => console.log(error));
    },

    set_priorities(context){
        return App.axios.get(App.api.getPriorities)
            .then(function (response) {

                context.commit('set_priorities', response.data);

                return true;
            }).catch(error => console.log(error));
    }

}