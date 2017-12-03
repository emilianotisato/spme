<template>
    <div>
        <v-card>
            <v-card-text>
                <h3>Editar Edificios</h3>
                <p>NOTA: Al finalizar todos los agregados/modificaciones refrescar la página para que los cambios tomen efecto sobre las tareas del listado.</p>
                <v-layout row wrap>
                    <v-flex md6 xs12>
                        <v-card>
                            <h4 class="text-md-right pt-2">
                                <v-btn @click.prevent="addBuilding" dark success><v-icon>add</v-icon> Agregar edificio</v-btn>
                            </h4>
                            <v-card-text>
                                <p>Seleccione un edificio para editar</p>
                                <v-select
                                        label="Seleccione un edificio"
                                        :items="buildings"
                                        item-value="id"
                                        item-text="name"
                                        autocomplete
                                        @change="setActiveBuilding"
                                ></v-select>

                                <v-card class="grey lighten-2" v-if="buildingForm.id != ''">
                                    <v-card-text>
                                        <h5 v-if="buildingForm.id == null">Nuevo edificio</h5>
                                        <h5 v-else>Editar edificio</h5>
                                        <form class="form-bordered" @submit.prevent="submitBuildingForm" @change="buildingForm.errors.clear($event.target.name)" @keydown="buildingForm.errors.clear($event.target.name)">
                                            <v-text-field
                                                    label="Nombre"
                                                    :rules="[buildingNameValidation]"
                                                    required
                                                    v-model="buildingForm.name"
                                            ></v-text-field>
                                            <v-text-field
                                                    label="Dirección"
                                                    :rules="[buildingAddressValidation]"
                                                    required
                                                    v-model="buildingForm.address"
                                            ></v-text-field>
                                            <v-btn class="blue--text darken-1" flat @click.native="deleteBuilding" v-if="buildingForm.id != null"><v-icon>delete_forever</v-icon> Eliminar</v-btn>
                                            <v-btn type="submit" dark success>
                                                <span v-if="buildingForm.id == null">Crear edificio</span>
                                                <span v-else>Actualizar edificio</span>
                                            </v-btn>
                                        </form>
                                    </v-card-text>
                                </v-card>

                            </v-card-text>
                        </v-card>
                    </v-flex>
                    <v-flex md6 xs12>
                        <v-card>
                            <h4 class="text-md-right pt-2">
                                <v-btn @click.prevent="addUnit" dark success><v-icon>add</v-icon> Agregar unidad</v-btn>
                            </h4>
                            <v-card-text>
                                <p>Seleccione la unidad que quiere editar</p>
                                <v-select
                                        label="Seleccione una unidad"
                                        :items="activeBuildingUnits"
                                        item-value="id"
                                        item-text="name"
                                        autocomplete
                                        @change="setActiveUnit"
                                ></v-select>

                                <v-card class="grey lighten-2" v-if="unitForm.id != ''">
                                    <v-card-text>
                                        <h5 v-if="buildingForm.id == null">Nuevo unidad</h5>
                                        <h5 v-else>Editar unidad</h5>
                                        <form class="form-bordered" @submit.prevent="submitUnitForm" @change="unitForm.errors.clear($event.target.name)" @keydown="unitForm.errors.clear($event.target.name)">
                                            <v-text-field
                                                    label="Nombre"
                                                    :rules="[unitNameValidation]"
                                                    required
                                                    v-model="unitForm.name"
                                            ></v-text-field>
                                            <v-btn class="blue--text darken-1" flat @click.native="deleteUnit" v-if="unitForm.id != null"><v-icon>delete_forever</v-icon> Eliminar</v-btn>
                                            <v-btn type="submit" dark success>
                                                <span v-if="unitForm.id == null">Crear unidad</span>
                                                <span v-else>Actualizar unidad</span>
                                            </v-btn>
                                        </form>
                                    </v-card-text>
                                </v-card>

                            </v-card-text>
                        </v-card>
                    </v-flex>


                </v-layout>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    export default {

        data () {
            return {
                buildingForm: new Form({id: '', name: '', address: ''}),
                unitForm: new Form({id: '', building_id: '', name: ''}),
            }
        },

        computed: {
            buildings() {
                return this.$store.getters.buildings
            },

            activeBuildingUnits() {
                if(this.buildingForm.id != '' && this.buildingForm.id != null) {
                    if(this.buildingForm.hasOwnProperty('units')) {
                        return this.buildingForm.units
                    }
                }

                return []
            },

            // Validation rules
            buildingNameValidation() {
                return this.buildingForm.errors.has('name') ? this.buildingForm.errors.get('name') : true
            },
            buildingAddressValidation() {
                return this.buildingForm.errors.has('address') ? this.buildingForm.errors.get('address') : true
            },
            unitNameValidation() {
                return this.unitForm.errors.has('name') ? this.unitForm.errors.get('name') : true
            },
        },

        methods: {
            setActiveBuilding(buildingId) {
                this.buildingForm = new Form(this.$store.getters.buildingById(buildingId))
                this.unitForm = {id:'', building_id: buildingId}
            },

            addBuilding() {
                this.buildingForm = new Form({id: null, name: '', address: ''})
            },

            setActiveUnit(unitId) {
                this.unitForm = new Form(this.activeBuildingUnits.find(unit => unit.id === unitId))
            },

            addUnit() {
                this.unitForm = new Form({id: null, building_id: this.buildingForm.id, name: ''})
            },

            submitBuildingForm() {
                this.buildingForm.post(window.App.internal_api.postBuilding)
                    .then(response => {

                        if(response.action == 'create') {

                            this.$store.commit('update_buildings', response)
                            this.buildingForm = new Form(response.object)

                            this.$notify({
                                group: 'success',
                                title: 'Edificio creado!',
                                text: 'Se ha creado el edificio con exito.',
                                duration: 5000
                            });
                        }

                        if(response.action == 'update') {

                            this.$store.commit('update_buildings', response)

                            this.$notify({
                                group: 'success',
                                title: 'Edificio actualizado!',
                                text: 'Se actualizó el edificio con exito.',
                                duration: 5000
                            });
                        }


                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            deleteBuilding() {
                let r = confirm("Si eliminas un edificio se eliminarán también todas sus unidades y tareas dentro de ellas!")
                if (r == true) {
                    axios.post(window.App.internal_api.deleteBuilding, {buildingId: this.buildingForm.id})
                        .then(function (response) {
                            location.reload(true)
                        }).catch(error => console.log(error));
                }
            },

            submitUnitForm() {
                this.unitForm.post(window.App.internal_api.postUnit)
                    .then(response => {

                        if(response.action == 'create') {

                            this.$store.commit('update_units', response)

                            this.$notify({
                                group: 'success',
                                title: 'Unidad creada!',
                                text: 'Se ha creado la unidad con exito.',
                                duration: 5000
                            });
                        }

                        if(response.action == 'update') {

                            this.$store.commit('update_units', response)

                            this.$notify({
                                group: 'success',
                                title: 'Unidad actualizada!',
                                text: 'Se actualizó la unidad con exito.',
                                duration: 5000
                            });
                        }


                    })
                    .catch(error => {
                        console.log(error);
                    });
            },

            deleteUnit() {
                let r = confirm("Si eliminas esta unidad perderás todas las tareas dentro de ella!")
                if (r == true) {
                    axios.post(window.App.internal_api.deleteUnit, {unitId: this.unitForm.id})
                        .then(function (response) {
                            location.reload(true)
                        }).catch(error => console.log(error));
                }
            }
        }
    }
</script>