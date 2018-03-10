require("./bootstrap");
require('./utilities/filters') // Load global filters

import 'babel-polyfill'			// To improve working on IE 11 and Safari 9
import router from "./routes";
import store from "./store/store";
import TaskForm from './components/TaskForm'

new Vue({
  el: "#vue-container",

  store,

  router,

  components: { TaskForm },

  data: {
    initStore: false,
    drawer: true,
    mini: false,
    right: null,
    myEvents: true,
    dueDateTime: new Date() // This will be replaced by setDueDateTime methods
  },

  computed: {
    menuItems() {
      return [
        { title: "Panel Común", icon: "dashboard", link: "/", show: true },
        { title: "Mis Tareas", icon: "star", link: "mis-tareas", show: true }
      ];
    }
  },

  mounted() {
    this.initStoreState();
  },

  methods: {

    initStoreState() {
      let authUser, tasks, users, clients, statuses, priorities = false;

      this.$store.dispatch("set_auth_user").then(() => {
        authUser = true;
      });

      this.$store.dispatch("set_tasks").then(() => {
        tasks = true;
      });

      this.$store.dispatch("set_users").then(() => {
        users = true;
      });

      this.$store.dispatch("set_clients").then(() => {
        clients = true;
      });

      this.$store.dispatch("set_statuses").then(() => {
        statuses = true;
      });

      this.$store.dispatch("set_priorities").then(() => {
        priorities = true;
      });


      let checkLoaded = () => {
        setTimeout(() => {
          if ([authUser, tasks, users, clients, statuses, priorities].every(el => el === true )) {
            this.initStore = true;
          } else {
            checkLoaded();
          }
        }, 50);
      };

      checkLoaded();
    }

  }
});
