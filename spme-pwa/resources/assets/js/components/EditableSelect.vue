<template>
    <div>

        <transition enter-active-class="animated fadeIn">
            <div v-if="!editMode"
                v-text="value"
                @click="setEditMode"
                class="showText"
                :class="elementClass"
                :style="elementStyles"
                ></div>

            <div v-else>

                    <v-select
                    ref="selectComponent"
                    v-model="modified"
                    :items="itemsArray"
                    :name="name"
                    :label="label"
                    :multi-line="multiline"
                    :single-line="!multiline"
                    :item-text="itemText"
                    :item-value="itemValue"
                    :rules="[validateField]"
                    :error-messages="errors[0]"
                    autocomplete
                    @change="onChange"
                    ></v-select>

                <div class="cancelSelelection">
                    <v-btn @click.prevent="cancel" flat icon color="grey"><v-icon>cancel</v-icon></v-btn>
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
        items: {
            required: true,
        },
        itemText: {
            required: true,
        },
        itemValue: {
            required: true,
        },
        label: {
            type: String,
        },
        isNullable: {
            type: Boolean,
            default: false
        },
        nullLabel: {
            type: String,
            default: '(x) Desasingnar'
        },
        multiline: {
            type: Boolean,
        },
        elementClass: {
            type: String,
        },
        elementStyles: {
            type: String,
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
        itemsArray() {
            let array = this.items

            if(this.isNullable) {
                array.unshift({[this.itemValue]: null, [this.itemText]: this.nullLabel})
            }

            return array
        },
        params() {
            let params = {}
            params[this.name] = this.modified
            return params
        },
        validateField() {
            return this.errors.length >=1 ? this.errors[0] : true
        }
    },

    methods: {
        setEditMode() {
            this.editMode = true
            setTimeout(()=>{
                this.$refs.selectComponent.focus()
            }, 100)
        },

        onChange(value) {
            this.modified = value
            this.save()

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
    .cancelSelelection {
        position: absolute;
        right: 35px;
        top: 5px;
    }
</style>
