import VueRouter from 'vue-router';
import store from './store/store';

export default new VueRouter({
    hashbang: false,
    history: true,
    mode: 'history',
    linkActiveClass: 'active',
    transitionOnLoad: true,
    root: '/',
    routes: [
        {
            path: '/',
            name: 'dashboard',
            component: require('./views/Dashboard'),
        },
        {
            path: '/mis-tareas',
            name: 'myTasks',
            component: require('./views/Dashboard'),
            props: { myTasks: true }
        },
        {
            path: '/tarea/:id',
            name: 'task',
            component: require('./views/Task'),
        }
    ]
});