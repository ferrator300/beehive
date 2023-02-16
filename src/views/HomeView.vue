<template>
  <toolbar :rol="rol" :nom="nom"></toolbar>
  <select v-if="amagat" id="ordenar" v-model="ordre">Ordenar per:
    <option value="prioritat">Prioritat</option>
    <option value="nom">Nom</option>
    <option value="datafi">DataFi</option>
  </select>
  <v-select id="ordenar">hola</v-select>
  <v-btn rounded="pill" size="large" id="perfer" @click="filtre = 'todo'">Per Fer ⏳</v-btn>
  <v-btn rounded="pill" size="large" id="enprogres" @click="filtre = 'ongoing'">En Progres ⚙️</v-btn>
  <v-btn rounded="pill" size="large" id="finalitzar" @click="filtre = 'done'">Finalitzades ✅</v-btn>
  <v-btn rounded="pill" size="large" id="totes" @click="filtre = 'tot'">Totes </v-btn>
  <div class="fitxa1">
    <tascafitxa v-if="rol !== 'Tecnic'" id="crearTasca" :estat="crear" :input_data="crearTasca"
      :prioritat="crearTascaBorder" @click="afegirTasca()"></tascafitxa>
    <tascafitxa v-for="na in estadoFiltrado" :input_data="na.Nom" :prioritat="na.Prioritat" :estat="na.Estat"
      @click="enviarTasca(na)"></tascafitxa>
  </div>
  <footercustom></footercustom>
  <tascaform v-if="isHidden" :informacio="tascaSeleccionada" :usuaris="llistat" :action="modify"
    @tancar="isHidden = false"></tascaform>

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
    login, toolbar, tascafitxa, footercustom, tascaform
  },
  data() {
    return {
      isHidden: false,
      llistaTasques: {},
      tascaSeleccionada: {},
      llistat: [],
      items: ['Prioritat', 'Nom', 'DataFi'],
      rol: "",
      nom: "",
      crear: "➕",
      crearTasca: "Crear Tasca",
      crearTascaBorder: "1",
      filtre: "",
      ordre: "prioritat",
      modify: false,
      amagat: false
    }
  },
  computed: {
    estadoFiltrado() {
      if (this.filtre == "") {
        return this.llistaTasques
      }
      else if (this.filtre == "tot" && this.ordre != "") {
        if (this.ordre === 'prioritat') {
          this.amagat = true
          return this.llistaTasques.sort((a, b) => Number(a.Prioritat) - Number(b.Prioritat));
        }
        else if (this.ordre === 'nom') {
          this.amagat = true
          return this.llistaTasques.sort((a, b) => a.Nom.localeCompare(b.Nom))
        }
        else if (this.ordre === 'datafi') {
          this.amagat = true
          return this.llistaTasques.sort((a, b) => new Date(a.DataFi) - new Date(b.DataFi))
        }

      }
      else if (this.ordre === 'prioritat') {
        this.amagat = true
        let temp = this.llistaTasques.filter(tasca => tasca.Estat === this.filtre)
        return temp.sort((a, b) => Number(a.Prioritat) - Number(b.Prioritat));
      } else if (this.ordre === 'nom') {
        this.amagat = true
        return this.llistaTasques.sort((a, b) => a.Nom.localeCompare(b.Nom)).filter(tasca => tasca.Estat === this.filtre);
      } else if (this.ordre === 'datafi') {
        this.amagat = true
        return this.llistaTasques.sort((a, b) => new Date(a.DataFi) - new Date(b.DataFi)).filter(tasca => tasca.Estat === this.filtre);
      }
      else
        return this.llistaTasques.filter(tasca => tasca.Estat === this.filtre)

    },
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
          this.rol=localStorage.getItem("Rol");
          this.nom=localStorage.getItem("NomUsuari");
          this.llistarTasques();
          if(this.rol!='Tecnic'){
            this.getListUsers();
          }
         
        },
        enviarTasca(infoTasca){
          this.isHidden=true
          this.tascaSeleccionada = infoTasca
          this.modify=true
        },
        afegirTasca(){
          this.isHidden=true
          this.tascaSeleccionada = {}
          this.modify=false
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
        this.llistat = data.map(item => item.Email)
      }
    },
    canvi(event) {
      this.filtre = event.target.value;
    }

  },
  mounted() {
    this.llistats();
    if (!localStorage.getItem("token_usuari")) {
      this.$router.push("home");
    }
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

#perfer {
  position: absolute;
  top: 3%;
  left: 10%;
}

#enprogres {
  position: absolute;
  top: 3%;
  left: 27%;
}

#finalitzar {
  position: absolute;
  top: 3%;
  left: 45%;
}

#totes {
  position: absolute;
  top: 3%;
  left: 65%;
}

#ordenar {
  position: absolute;
  top: 3%;
  left: 80%;
}

#creartasca tspan {
  font-size: 70px;
}

::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #828282;
}
</style>