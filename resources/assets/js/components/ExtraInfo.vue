<template>
  <div>
    <div class="title grey--text pa-3">{{ task.projectFullName }}</div>

    <div class="pa-3">
      <div v-if="tab == 'project'">
      Resumen del proyecto
      </div>
      <div v-if="tab == 'files'">
          <v-dialog v-model="filesDialog" persistent max-width="690">
            <v-btn slot="activator" color="primary" dark>Subir archivos</v-btn>
            <v-card>
                <v-card-text>
                    <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"></vue-dropzone>
                </v-card-text>
                 <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" flat @click.native="filesDialog = false">Listo!</v-btn>
                </v-card-actions>
            </v-card>
          </v-dialog>
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
      <v-btn flat color="teal" value="files">
        <span>Archivos</span>
        <v-badge overlap>
          <span slot="badge">6</span>
          <v-icon>folder_open</v-icon>
        </v-badge>
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
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

  export default {
    components: { vueDropzone: vue2Dropzone },

    props: {
      task: {
        required: true
      }
    },

    data () {
      return {
        tab: 'project',
        filesDialog: false,
        dropzoneOptions: {
          url: 'https://httpbin.org/post',
          thumbnailWidth: 150,
          maxFilesize: 20,
          dictDefaultMessage: 'Subir Archivos...'
        }
      }
    }
  }
</script>