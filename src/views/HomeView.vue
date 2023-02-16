<template>
  <toolbar :rol="rol" :nom="nom"></toolbar>
  <div class="superior">
    <v-btn class="filterbtn" rounded="pill" size="large" id="perfer" @click="filtre = 'todo'">Per Fer ⏳</v-btn>
    <v-btn class="filterbtn" rounded="pill" size="large" id="enprogres" @click="filtre = 'ongoing'">En Progres ⚙️</v-btn>
    <v-btn class="filterbtn" rounded="pill" size="large" id="finalitzar" @click="filtre = 'done'">Finalitzades ✅</v-btn>
    <v-btn class="filterbtn" rounded="pill" size="large" id="totes" @click="filtre = 'tot'">Totes </v-btn>
    
    <select class="filterbtn" title="Ordenar per" v-if="amagat" id="ordenar" v-model="ordre">
      <option value="prioritat">Prioritat</option>
      <option value="nom">Nom</option>
      <option value="datafi">DataFi</option>
    </select>
  </div>
  <div class="fitxa1">
    <tascafitxa v-if="rol !== 'Tecnic'" id="crearTasca" :estat="crear" :input_data="crearTasca"
      :prioritat="crearTascaBorder" @click="afegirTasca()"></tascafitxa>
    <tascafitxa v-for="na in estadoFiltrado" :input_data="na.Nom" :prioritat="na.Prioritat" :estat="na.Estat"
      @click="enviarTasca(na)"></tascafitxa>
  </div>
  <v-snackbar absolute v-model="snackbar">
        {{ textSnack }}
        <template v-slot:actions>
            <v-btn color="pink" variant="text" @click="snackbar = false">
                Close
            </v-btn>
        </template>
    </v-snackbar>
  <footercustom></footercustom>
  <tascaform v-if="isHidden" :informacio="tascaSeleccionada" :usuaris="llistat" :action="modify"
    @tancar="isHidden = false" @snack="snackbarCreator($event)"></tascaform>

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
      amagat: false,
      textSnack: "",
      snackbar: false,
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
          this.llistaTasques.sort((a, b) => Number(a.Prioritat) - Number(b.Prioritat));
          return this.llistaTasques.reverse();
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
        temp.sort((a, b) => Number(a.Prioritat) - Number(b.Prioritat));
        return this.llistaTasques.reverse();

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
                    this.snackbarCreator("ERROR, Algú més esta utilitzant aquest compte o s'ha caducat la Sessió");
                    localStorage.clear();
                    this.$router.push("/");
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
    },
    snackbarCreator(input) {
            this.textSnack = input;
            this.snackbar = true;
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
.filterbtn {
  background-color: var(--honeyG);
}
#ordenar {
  padding: 11px;
  border-radius: 50px;
  width: 150px;
  text-align: center;
  cursor: pointer;
  box-shadow: 0px 3px 1px -2px var(--v-shadow-key-umbra-opacity, rgba(0, 0, 0, 0.2)), 0px 2px 2px 0px var(--v-shadow-key-penumbra-opacity, rgba(0, 0, 0, 0.14)), 0px 1px 5px 0px var(--v-shadow-key-penumbra-opacity, rgba(0, 0, 0, 0.12));
}

.superior {
  display: flex;
  width: -webkit-fill-available;
  position: absolute;
  top: 10px;
  left: 65px;
  flex-direction: row;
  flex-wrap: wrap;
  gap: 20px;
  justify-content: flex-start;
  align-items: center;
  z-index: 900;
}

.fitxa1 {
  position: absolute;
  width: -webkit-fill-available;
  height: 85%;
  margin: 5px;
  top: 10%;
  left: 6%;
  overflow-y: auto;
  border-radius: 20px;
  padding: 20px;
}

html {
  overflow: hidden;
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