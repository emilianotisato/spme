<template>
    <div>
        <v-text-field
              :name="name"
              :label="label"
              single-line
              :value="value"
            ></v-text-field>
    </div>
</template>

<script>
export default {
    props: {
        name: {

        },
        value: {

        },
        label: {

        },
    },

}
</script>

<style>

</style>
