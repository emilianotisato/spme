<template>
  <div>
    <div class="title grey--text pa-3">{{ task.projectFullName }}</div>

    <div class="pa-3">
      <div v-if="tab == 'project'">
      Resumen del proyecto
      </div>
      <div v-if="tab == 'notes'">
        Acordeon con notas
      </div>
      <div v-if="tab == 'secret'">
        Acordeon con pass
      </div>
    </div>

    <v-bottom-nav absolute :value="true" :active.sync="tab" color="transparent">
      <v-btn flat color="teal" value="project">
        <span>Proyecto</span>
        <v-icon>trending_up</v-icon>
      </v-btn>
      <v-btn flat color="teal" value="notes">
        <span>Notas</span>
        <v-icon>bookmark</v-icon>
      </v-btn>
      <v-btn flat color="teal" value="secret">
        <span>Contraseñas</span>
        <v-icon>lock_outline</v-icon>
      </v-btn>
    </v-bottom-nav>
  </div>
</template>

<script>
  export default {

    props: {
      task: {
        required: true
      }
    },

    data () {
      return {
        tab: 'project'
      }
    }
  }
</script>