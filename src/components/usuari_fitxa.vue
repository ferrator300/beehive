<template>
    <h1>usuari_fitxa</h1>
    <usuari_form></usuari_form>
</template>

<script>
import usuari_form from './usuari_form.vue'
export default {
    name: 'usuari_fitxa',
    props: ['input_data'],
    data() {
        return {
            nom: this.input_data.nom,
            email: this.input_data.email,
            rol: this.input_data.rol,
        }
    },
    components: {
        usuari_form
    },  
    methods: {
        /* 
            Function: openInfo

            Mostrem component d’informació, relacionat amb aquella tasca.

            Parameters:
                none
        */
        // openInfo(id) {
        //     var apikey = "";
        //     var input = "";
        //     var output = "";
        // }
    }
}
</script>

<style>
</style>