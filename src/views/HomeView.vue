<template>
  <toolbar :rol="rol"></toolbar>
  <div class="fitxa">
    <tascafitxa v-for="na in llistaTasques" :input_data="na.Nom" @click="enviarTasca(na)" ></tascafitxa>
  </div>
  <footercustom></footercustom>
  <tascaform :informacio="tascaSeleccionada"></tascaform>
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
      n : ['a', 'b'],
      llistaTasques:{},
      tascaSeleccionada: {}
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
                    alert('Error');
                }
        },
        enviarTasca(infoTasca){
          this.tascaSeleccionada = infoTasca
        }
  },
  mounted(){
      this.llistarTasques();
  }
}
</script>

<style>
.fitxa {
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