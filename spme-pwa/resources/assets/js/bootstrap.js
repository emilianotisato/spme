/**
 * Main boostrap.
 */
window.App = {}
window.App.api = {
  getUser: "/get-auth-user",
  updatePassword: "/update-user-password",
  getUsers: "/get-users",
  getStatuses: "/get-statuses",
  getPriorities: "/get-priorities",
  getTasks: "/get-tasks",
  postTask: "/post-task",
  postTaskUpdate: "/post-task-update",
  deleteTaskUpdate: "/delete-task-update",
  getClients: "/get-clients",
  postClient: "/post-client",
  postProject: "/post-project",
  deleteClient: "/delete-client",
  deleteProject: "/delete-project"
};

import Vue from "vue";
import Moment from "moment";
import Vuetify from "vuetify";
import VueRouter from "vue-router";
import Form from "./utilities/Form";
import Notifications from "vue-notification";
import { permissionsMixin } from "./utilities/permissionsMixin";


Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(Notifications);
Vue.mixin(permissionsMixin)

window.Vue = Vue;
window.App.form = Form;
window.moment = Moment;
moment.locale('es')

// Axios Config
window.App.axios = require("axios");
window.App.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  window.App.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
  console.error(
    "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
  );
}
