export default {

    set_auth_user(state, auth_user) {
        state.auth_user = auth_user;
    },

    set_tickets(state, payload) {
        payload.ticket ? state.tickets.push(payload.ticket) : state.tickets = payload.tickets;
    },

    update_tickets(state, updatedTicket) {
        Object.assign(state.tickets.find(ticket => ticket.id === updatedTicket.id), updatedTicket)
    },

    set_buildings(state, buildings) {
        state.buildings = buildings;
    },

    update_buildings(state, payload) {

        if(payload.action == 'create') {

            state.buildings.push(payload.object)
        }

        if(payload.action == 'update') {

            Object.assign(state.buildings.find(building => building.id === payload.object.id), payload.object)
        }
    },

    update_units(state, payload) {

        let building = state.buildings.find(building => building.id === payload.object.building_id)

        if(payload.action == 'create') {

            if(! building.hasOwnProperty('units')) { // Create units array if the building has just created in the front
                building.units = []
            }

            building.units.push(payload.object)
        }

        if(payload.action == 'update') {
            Object.assign(building.units.find(unit => unit.id === payload.object.id), payload.object)
        }

        Object.assign(state.buildings.find(building => building.id === payload.object.building_id), building)
    },

    set_users(state, users) {
        state.users = users;
    },

    set_providers(state, providers) {
        state.providers = providers;
    },

    set_statuses(state, statuses) {
        state.statuses = statuses;
    },

    set_severities(state, severities) {
        state.severities = severities;
    }


}