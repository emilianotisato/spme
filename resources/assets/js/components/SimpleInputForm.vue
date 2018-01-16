<template>
    <div>
        <v-text-field
                 v-model="inputValue"
                 :name="name"
                 :label="label"
                 :rules="[validateField]"
                 :error-messages="errors[0]"
                 autofocus
                 ></v-text-field>
             <div class="right buttonsSingleInputForm">
                 <v-btn @click.prevent="cancel" flat icon color="grey"><v-icon>cancel</v-icon></v-btn>
                 <v-btn @click.prevent="save" flat icon color="green"><v-icon>save</v-icon></v-btn>
             </div>
    </div>
</template>

<script>
export default {

    props: {
        postUrl: {
            type: String,
            required: true
        },
        name: {
            type: String,
            default: 'name'
        },
        label: {
            type: String,
            required: true
        },
    },

    data () {
        return {
            inputValue: null,
            errors: []
        }
    },

    computed: {
        params() {
            let params = {}
            params[this.name] = this.inputValue
            return params
        },
        validateField() {
            return this.errors.length >=1 ? this.errors[0] : true
        }
    },

    methods: {

        save() {
            this.errors = []

            App.axios.post(this.postUrl, this.params)
            .then((response) => {
                this.$emit('created', response.data)
                this.cancel()
            }).catch((error) => {
                this.errors = JSON.parse(error.request.response).errors[this.name]
            });
        },

        cancel() {
            this.errors = []
            this.$emit('cancel')
        }
    }

}
</script>
<style>
    .buttonsSingleInputForm {
        position: relative;
        top: -70px;
        height: 0px;
    }
</style>
