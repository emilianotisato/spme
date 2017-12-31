/**
 * Main boostrap.
 */
window.App = {}
window.App.api = {
  getUser: "get-auth-user",
  updatePassword: "update-user-password",
  logout: "logout",
  getTasks: "get-tasks",
  getUsers: "get-users",
  getClients: "get-clients",
  getStatuses: "get-statuses",
  getPriorities: "get-priorities",
  postTask: "post-task",
  postTaskUpdate: "post-task-update",
  postClient: "post-client",
  postProject: "post-project",
  deleteClient: "delete-client",
  deleteProject: "delete-project"
};

import Vue from "vue";
import Moment from "moment";
import Vuetify from "vuetify";
import VueRouter from "vue-router";
import Form from "./utilities/Form";
import Notifications from "vue-notification";

Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(Notifications);

window.Vue = Vue;
window.App.form = Form;
window.moment = Moment;

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
