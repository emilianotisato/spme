<template>
    <div>

        <transition enter-active-class="animated fadeIn">
            <div v-if="!editMode"
                v-html="nToBr(value)"
                @mouseup="setEditMode"
                class="scrollarea"
                :class="elementClass"
                :style="elementStyles"
                ></div>

            <div v-else>

                <v-text-field
                    v-model="modified"
                    :name="name"
                    :label="label"
                    :multi-line="multiline"
                    :value="value"
                    :rules="[validateField]"
                    :error-messages="errors[0]"
                    autofocus
                    ></v-text-field>

                <div class="right">
                    <v-btn @click.prevent="cancel" flat icon color="grey"><v-icon>cancel</v-icon></v-btn>
                    <v-btn @click.prevent="save" flat icon color="green"><v-icon>save</v-icon></v-btn>
                </div>

            </div>
        </transition>
    </div>
</template>

<script>
export default {
    props: {
        patchUrl: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
        value: {
            required: true,
        },
        label: {
            type: String,
        },
        multiline: {
            type: Boolean,
        },
        elementClass: {
            type: String,
        },
        elementStyles: {
            type: String,
            default: 'height:50px;'
        }
    },

    data () {
        return {
            editMode: false,
            modified: '',
            errors: []
        }
    },

    computed: {
        params() {
            let params = {}
            params[this.name] = this.modified
            return params
        },
        validateField() {
            return this.errors.length >=1 ? this.errors[0] : true
        }
    },

    created() {
        this.modified = this.value
    },

    methods: {
        nToBr(text) {
            if(text != null) {
                return text.replace(/\n/g, "<br />")
            }
            return ''
        },

        setEditMode() {
            if(window.getSelection().type == 'Caret') {
                this.editMode = true
            }
        },

        save() {
            this.errors = []

            App.axios.patch(this.patchUrl, this.params)
            .then((response) => {
                this.$emit('updated', response.data)
                this.editMode = false
            }).catch((error) => {
                this.errors = JSON.parse(error.request.response).errors[this.name]
            });
        },

        cancel() {
            this.errors = []
            this.editMode = false
        }
    }

}
</script>

<style>
    .scrollarea {
        overflow-y: auto;
        cursor: pointer;
    }

    .scrollarea::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    .scrollarea::-webkit-scrollbar
    {
        width: 12px;
        background-color: #F5F5F5;
    }

    .scrollarea::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #555;
    }

</style>
