<template>
    <h1>task_form</h1>
</template>

<script>
export default {
    name: 'tasca_form',
    props: ['input_data', 'treballadors'],
    data() {
        return {
        }
    },
    components: {
    },  
    methods: {
        /* 
            Function: delete

            Crida a l’API per a la eliminació d’aquella tasca

            Parameters:
                id - identificador de la tasca a eliminar
        */
        // delete(id) {
        //     var apikey = "";
        //     var input = "beehive.daw.institutmontilivi.cat/API/Tasques/Eliminar";
        //     var output = "";
        // },

        /* 
            Function: crear

            Crida a l’API per a la creació d’aquella tasca

            Parameters:
                none
        */
        // crear() {
        //     var apikey = "";
        //     var input = "beehive.daw.institutmontilivi.cat/API/Tasques/Crear";
        //     var output = "";
        // },

        /* 
            Function: checkAction

            Comprovem si estem creant o modificant la tasca

            Parameters:
                rol - nivell d'accés de l'usuari ['admin, gestor, treballador']
        */
        // checkAction() {
        //     var apikey = "";
        //     var input = "";
        //     var output = "";
        // }
    }
}
</script>

<style>
</style>