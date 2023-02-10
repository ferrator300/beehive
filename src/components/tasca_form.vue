<template>
<v-card id="tasca_form">
<v-card-actions @click="tancar()"><v-btn>X</v-btn></v-card-actions>
<v-text-field id="NomTasca"  :value="informacio.Nom"></v-text-field>
<v-textarea id="Descripcio" :value="informacio.Descripcio"></v-textarea>
<v-text-field id="DataInici" :value="informacio.DataInici" type="datetime-local"></v-text-field>
<v-text-field id="DataFi" :value="informacio.DataFi" type="datetime-local"></v-text-field>
<v-slider hint="Prioritat" step="1" thumb-label="hover" max="9" min="1" v-model="informacio.Prioritat"></v-slider>
<v-select :items="items" :value="informacio.Estat" dense solo></v-select>
<v-textarea id="Comentaris" :value="informacio.Comentaris"></v-textarea>
<v-text-field id="Responsable" :value="informacio.Email"></v-text-field>
</v-card>
</template>

<script>
export default {
    name: 'tasca_form',
    props: ['input_data', 'treballadors', 'informacio'],
    data() {
        return {
            isHidden: false,
            items: ['Per Fer', 'En Progres', 'Finalitzada'],
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
            this.isHidden = true
        }
    }
}
</script>

<style>
#tasca_form {
  position: fixed;
  top:20%;
  left:10%;
  width: 85%;
  height:85%;
  padding: 50px;
  overflow: auto;

  
}
</style>