<template>
<v-card id="tasca_form" v-if="isHidden">
<h1>Modificar Tasca</h1>
<v-btn @click="tancar()" id="boto">X</v-btn>
<v-text-field id="NomTasca"  v-model="informacio.Nom" label="Nom"></v-text-field>
<v-textarea id="Descripcio" v-model="informacio.Descripcio" label="Descripció"></v-textarea>
<v-text-field id="DataInici" v-model="informacio.DataInici" type="datetime-local" label="Data d'Inici"></v-text-field>
<v-text-field id="DataFi" v-model="informacio.DataFi" type="datetime-local" label="Data Final"></v-text-field>
<v-slider hint="Prioritat" step="1" thumb-label="hover" max="9" min="1" v-model="informacio.Prioritat" label="Prioritat"></v-slider>
<v-select :items="items" v-model="informacio.Estat" dense solo label="Estat"></v-select>
<v-textarea id="Comentaris" v-model="informacio.Comentaris" label="Comentaris"></v-textarea>
<v-select id="Responsable" :items="usuaris" v-model="informacio.Email" dense solo label="Responsable"></v-select>
</v-card>
</template>

<script>
export default {
    name: 'tasca_form',
    props: ['input_data', 'treballadors', 'informacio', 'usuaris'],
    data() {
        return {
            isHidden: true,
            items: ['Per Fer', 'En Progres', 'Finalitzada'],
            usuaris: this.usuaris
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
        tancar(){
                this.isHidden = false;
                this.$emit("tancar")  
        },
        actualitzarTasca(){

        }
    }
}
</script>

<style>
#tasca_form {
  position: fixed;
  top:5%;
  left:10%;
  width: 85%;
  height:85%;
  padding: 50px;
  overflow: auto;
  background-color: lightgoldenrodyellow;

  
}
#boto{
    position: fixed;
    top: 6%;
    right: 10%;
}
</style>