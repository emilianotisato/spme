export default {

    set_auth_user(state, auth_user) {
        state.auth_user = auth_user;
    },

    set_tasks(state, payload) {
        payload.task ? state.tasks.push(payload.task) : state.tasks = payload.tasks;
    },

    update_tasks(state, updatedTask) {
        Object.assign(state.tasks.find(task => task.id === updatedTask.id), updatedTask)
    },

    set_clients(state, clients) {
        state.clients = clients;
    },

    update_clients(state, payload) {

        if(payload.action == 'create') {

            state.clients.push(payload.object)
        }

        if(payload.action == 'update') {

            Object.assign(state.clients.find(client => client.id === payload.object.id), payload.object)
        }
    },

    update_projects(state, payload) {

        let client = state.clients.find(client => client.id === payload.object.client_id)

        if(payload.action == 'create') {

            if(! client.hasOwnProperty('projects')) { // Create projects array if the client has just created in the front
                client.projects = []
            }

            client.projects.push(payload.object)
        }

        if(payload.action == 'update') {
            Object.assign(client.projects.find(project => project.id === payload.object.id), payload.object)
        }

        Object.assign(state.clients.find(client => client.id === payload.object.client_id), client)
    },

    set_users(state, users) {
        state.users = users;
    },

    set_statuses(state, statuses) {
        state.statuses = statuses;
    },

    set_priorities(state, priorities) {
        state.priorities = priorities;
    }


}