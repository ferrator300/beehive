<template>
    <h1>toolbar</h1>
</template>

<script>
export default {
    name: 'toolbarComp',
    props: ['rol'],
    data() {
        return {
            nom: this.input_data.nom,
            email: this.input_data.email,
            rol_local: this.input_data.rol,
        }
    },
    components: {
    },  
    methods: {
        /* 
            Function: checkRol

            Comprovació del rol de l’usuari

            Parameters:
                none
        */
        // checkRol() {
        //     var apikey = "";
        //     var input = "";
        //     var output = "";
        // },

        /* 
            Function: buildToolbar

            Addició d’eines al menú lateral segons el valor del paràmetre que rep rol

            Parameters:
                rol -  nivell d'accés de l'usuari ['Admin, Gestor, Tecnic']
        */
        // buildToolbar() {
        //     var apikey = "";
        //     var input = "";
        //     var output = "";
        // }
    }
}
</script>

<style>
</style>