require("./bootstrap");
import router from "./routes";
import store from "./store/store";

new Vue({
  el: "#vue-container",

  store,

  router,

  data: {
    // loader: false,
    initStore: false,
    dialog: false,
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
        { title: "Mis Tickets", icon: "star", link: "mis-tareas", show: true }
        // {
        //   title: "Configuración",
        //   icon: "settings",
        //   link: "configuracion",
        //   show: this.$store.state.auth_user.is_admin ? true : false
        // }
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

  //   upcomingEvents() {
  //     let upcomingUpdates = [];

  //     this.$store.getters.tickets.forEach(ticket => {
  //       ticket.updates.forEach(update => {
  //         if (update.due_date != null) {
  //           update.isOwner =
  //             ticket.assigned_user == this.$store.state.auth_user.id; // Added to filter auth user tickets
  //           upcomingUpdates.push(update);
  //         }
  //       });
  //     });

  //     upcomingUpdates.sort((a, b) => {
  //       return new Date(a.due_date) - new Date(b.due_date);
  //     });

  //     upcomingUpdates.map(update => {
  //       if (new Date(update.due_date) < this.dueDateTime) {
  //         update.isDueDude = true;
  //       } else {
  //         update.isDueDude = false;
  //       }
  //     });

  //     return upcomingUpdates;
  //   },

  //   eventList() {
  //     let eventList = [];

  //     if (this.myEvents) {
  //       eventList = this.upcomingEvents.filter(event => {
  //         return event.isOwner;
  //       });
  //     } else if (!this.myEvents) {
  //       eventList = this.upcomingEvents.filter(event => {
  //         return !event.isOwner;
  //       });
  //     }

  //     return eventList;
  //   },

  //   eventsLabel() {
  //     return this.myEvents ? "Mis eventos" : "Eventos del equipo";
  //   }
  // },

  // mounted() {
  //   this.initStoreState();

  //   this.setDueDateTime();
  //   setInterval(
  //     function() {
  //       this.setDueDateTime();
  //     }.bind(this),
  //     60000
  //   ); // run the function for every minute
  // },

  // methods: {
  //   initStoreState() {
  //     this.loader = true; // Init loader

  //     const load_auth_user = this.$store
  //       .dispatch("set_auth_user")
  //       .then(data => {
  //         if (data) {
  //           console.log("Loaded User");
  //           return true;
  //         } else {
  //           return false;
  //         }
  //       });

  //     const load_tickets = this.$store.dispatch("set_tickets").then(data => {
  //       if (data) {
  //         console.log("Loaded Tickets");
  //         return true;
  //       } else {
  //         return false;
  //       }
  //     });

  //     const load_users = this.$store.dispatch("set_users").then(data => {
  //       if (data) {
  //         console.log("Loaded Users");
  //         return true;
  //       } else {
  //         return false;
  //       }
  //     });

  //     const load_providers = this.$store
  //       .dispatch("set_providers")
  //       .then(data => {
  //         if (data) {
  //           console.log("Loaded Providers");
  //           return true;
  //         } else {
  //           return false;
  //         }
  //       });

  //     const load_buildings = this.$store
  //       .dispatch("set_buildings")
  //       .then(data => {
  //         if (data) {
  //           console.log("Loaded Buildings");
  //           return true;
  //         } else {
  //           return false;
  //         }
  //       });

  //     const load_statuses = this.$store.dispatch("set_statuses").then(data => {
  //       if (data) {
  //         console.log("Loaded Statuses");
  //         return true;
  //       } else {
  //         return false;
  //       }
  //     });

  //     const load_severities = this.$store
  //       .dispatch("set_severities")
  //       .then(data => {
  //         if (data) {
  //           console.log("Loaded Severities");
  //           return true;
  //         } else {
  //           return false;
  //         }
  //       });

  //     Promise.all([
  //       load_auth_user,
  //       load_tickets,
  //       load_users,
  //       load_providers,
  //       load_buildings,
  //       load_statuses,
  //       load_severities
  //     ])
  //       .then(responses => {
  //         if (
  //           responses.every(el => {
  //             return el === true;
  //           })
  //         ) {
  //           // this.$store.commit('finish_load');
  //           this.loader = false;
  //           console.log("All loaded!");
  //         } else {
  //           console.log(
  //             "We could not load all models. This array shows the load order and witch ones fails"
  //           );
  //           console.log(responses);
  //         }
  //       })
  //       .catch(error => {
  //         console.log("We could not load all models: " + error);
  //       });
  //   },

  //   updateEventClicked(id) {
  //     this.$router.push({ name: "ticket", params: { ticketId: id } });
  //   },

  //   setDueDateTime() {
  //     // New datetime minus one hour
  //     let dueDateTime = new Date();
  //     this.dueDateTime = dueDateTime.setHours(dueDateTime.getHours() + 1);
  //   }
  // }
});
