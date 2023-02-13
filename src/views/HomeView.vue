<template>
  <toolbar :rol="rol" :nom="nom"></toolbar>
  <div class="fitxa1">
    <tascafitxa v-for="na in llistaTasques" :input_data="na.Nom" :prioritat="na.Prioritat" :rol="rol" @click="enviarTasca(na)" ></tascafitxa>
  </div>
  <footercustom></footercustom>
  <tascaform v-if="isHidden" :informacio="tascaSeleccionada" :usuaris="llistat" @tancar="isHidden=false"></tascaform>
  
</template>

<script>
// @ is an alias to /src
import login from '@/components/login_form.vue'
import toolbar from '@/components/toolbar.vue'
import tascafitxa from '@/components/tasca_fitxa.vue'
import tascaform from '@/components/tasca_form.vue'
import footercustom from '@/components/footercustom.vue'
export default {
  name: 'HomeView',
  components: {
    login,  toolbar, tascafitxa, footercustom, tascaform
  },
  data() {
    return {
      isHidden: false,
      llistaTasques:{},
      tascaSeleccionada: {},
      llistat: [],
      rol: "",
      nom: ""
    }
  },
  methods: {
        /* 
            Function: openInfo

            Mostrem component d’informació, relacionat amb aquella tasca.

            Parameters:
                none
        */
        // openInfo() {
        //     var apikey = "";
        //     var input = "";
        //     var output = "";
        // }

        llistarTasques() {
            var userToken = localStorage.getItem("token_usuari");
            // var apikey = "";
            var input = "http://beehive.daw.institutmontilivi.cat/API/Tasca/Llistat";
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", input, false);
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(userToken));
            if (xmlhttp.status == 200) {
                    this.llistaTasques = JSON.parse(xmlhttp.responseText);
                }
                else {
                    alert('Error al recuperar el llistat de Tasques');
                }
        },
        llistats(){
          this.llistarTasques();
          this.getListUsers();
          this.rol=localStorage.getItem("Rol");
          this.nom=localStorage.getItem("NomUsuari");
        },
        enviarTasca(infoTasca){
          this.isHidden=true
          this.tascaSeleccionada = infoTasca
        },
        getListUsers() {
            var userToken = localStorage.getItem("token_usuari");
            var input = "http://beehive.daw.institutmontilivi.cat/API/Usuari/Llistat";

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("PUT", input, false);
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(userToken));
            if (xmlhttp.status == 200) {
              var data = JSON.parse(xmlhttp.responseText);
              this.llistat=data.map(item => item.Email)
            }
        },
  },
  mounted(){
      this.llistats();
  }
}
</script>

<style>
.fitxa1 {
  position: absolute;
  width: -webkit-fill-available;
  height: -webkit-fill-available;
  margin: 5px;
  top: 10%;
  left: 10%;
  /*display: flex;*/
  overflow-y: auto;
  /*gap: 20px;*/
  flex-wrap: wrap;
}
html {
  overflow: hidden;
}


</style>