<template>
    <h1>usuari_form</h1>
</template>

<script>
export default {
    name: 'usuari_form',
    props: ['input_data', 'rol'],
    data() {
        return {
            nom: this.input_data.nom,
            email: this.input_data.email,
            pwsd: this.input_data.pwsd,
        }
    },
    components: {
    },  
    methods: {
        /* 
            Function: delete

            Crida a l’API per a la eliminació d’aquell usuari

            Parameters:
                id - identificador de l'usuari a eliminar
        */
        // delete(id) {
        //     var apikey = "";
        //     var input = "beehive.daw.institutmontilivi.cat/API/Usuari/Eliminar";
        //     var output = "";
        // },

        /* 
            Function: modifyUser

            Crida a l’API per a la modificació d’un usuari amb la informació recollida del formulari

            Parameters:
                none
        */
        // modifyUser() {
        //     var apikey = "";
        //     var input = "beehive.daw.institutmontilivi.cat/API/Usuari/Editar";
        //     var output = "";
        // },

        /* 
            Function: createUser

            Crida a l’API per a la creació d’un usuari amb la informació recollida del formulari i el token recuperat

            Parameters:
                none
        */
        // createUser() {
        //     var apikey = "";
        //     var input = "beehive.daw.institutmontilivi.cat/API/Usuari/Crear";
        //     var output = "";
        // },

        /* 
            Function: checkAction

            Comprovem si estem creant o modificant l’usuari

            Parameters:
                rol -  nivell d'accés de l'usuari ['Admin, Gestor, Tecnic']
        */
        // checkAction(rol) {
        //     var apikey = "";
        //     var input = "";
        //     var output = "";
        // },

        /* 
            Function: getToken

            Recuperem el token de la cookie

            Parameters:
                none
        */
        // getToken() {
        //     var apikey = "";
        //     var input = "beehive.daw.institutmontilivi.cat/API/Token";
        //     var output = "";
        // }
    }
}
</script>

<style>
</style>