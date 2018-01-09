<template>
  <div>
    <div class="headline text-xs-center pa-5">Active: {{ e1 }}</div>
    <v-bottom-nav absolute :value="true" :active.sync="e1" color="transparent">
      <v-btn flat color="teal" value="recent">
        <span>Proyecto</span>
        <v-icon>trending_up</v-icon>
      </v-btn>
      <v-btn flat color="teal" value="favorites">
        <span>Notas</span>
        <v-icon>bookmark</v-icon>
      </v-btn>
      <v-btn flat color="teal" value="nearby">
        <span>Contraseñas</span>
        <v-icon>lock_outline</v-icon>
      </v-btn>
    </v-bottom-nav>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        e1: 'recent'
      }
    }
  }
</script>