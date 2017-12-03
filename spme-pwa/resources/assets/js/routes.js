import VueRouter from 'vue-router';
import store from './store/store';

export default new VueRouter({
    hashbang: false,
    history: true,
    mode: 'history',
    linkActiveClass: 'active',
    // transitionOnLoad: true,
    root: '/',
    routes: [
        {
            path: '/',
            name: 'dashboard',
            component: require('./views/Dashboard'),
        },
        {
            path: '/ticket/:ticketId',
            name: 'ticket',
            component: require('./views/Ticket'),
        },
        {
            path: '/mis-tickets',
            name: 'myTickets',
            component: require('./views/MyTickets'),
        },
        {
            path: '/perfil',
            name: 'profile',
            component: require('./views/Profile'),
        },
        {
            path: '/edificios',
            name: 'Buildings',
            component: require('./views/Buildings'),
            beforeEnter: (to, from, next) => {
                if(store.state.auth_user.is_admin != 1) {
                    next({ path: '/' })
                }
                next()
            }
        }
    ]
});