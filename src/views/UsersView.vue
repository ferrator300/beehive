<template>
    <toolbar></toolbar>
    <footercustom></footercustom>
</template>

<script>
import createUser from '@/components/usuari_form.vue'
import toolbar from '@/components/toolbar.vue'
import footercustom from '@/components/footercustom.vue'
export default {
    name: 'UserView',
    props: [],
    data() {
        return {
            llistat: "",
            user: "",
            rol: ""
        }
    },
    components: {
        createUser,
        toolbar,
        footercustom
    },  
    methods: {
        /* 
            Function: list

            Crida a l’API per al llistat d’usuaris

            Parameters:
                none
        */
        list() {

        },

        /* 
            Function: getListUsers()

            Recollida de l’informació a la base de dade sper al usuari identificat

            Parameters:
                none
        */
       getListUsers() {

       },

        /* 
            Function: modifyUser(id)

            Crida al component de formulari de modificació d’usuari segons el valor del parametre id

            Parameters:
                id - identificador de l'usuari que volem modificar
        */
       modifyUser(id) {
            console.log(id)
       }
    }
}
</script>