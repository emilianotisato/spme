/**
 * Main boostrap.
 */
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
window.Form = Form;
window.moment = Moment;

// Axios Config
window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
  console.error(
    "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
  );
}
