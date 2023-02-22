<template>
  <toolbar :rol="rol" :nom="nom"></toolbar>
  <div v-if="llistaTasques.length!=0" class="superior" >
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
      <h1 v-if="llistaTasques.length==0">EEP!! No tens cap Tasca assignada. Torna més Tard</h1>
    <img v-if="llistaTasques.length==0" src="https://i.pinimg.com/originals/60/48/31/60483168a0149cf0c531c5cddaa0c9ad.png">
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
  @refrescar="llistarTasques()" @tancar="isHidden = false"  @snack="snackbarCreator($event)"></tascaform>
    

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
      crearTasca: "Nova Tasca",
      crearTascaBorder: "0",
      filtre: "",
      ordre: "prioritat",
      modify: false,
      amagat: false,
      textSnack: "",
      snackbar: false,
    }
  },
  computed: {
    //Camp Computed que ens filtra i Ordena el llistat de Tasques
    //A la que faci click a qualsevol boto, mostrara el select per triar el mètode d'ordenacio, per això fem el amagat true,
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

        //Mètode que ens recupera el llistat de tasques 
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
        //Mètode que crida als 2 mètodes de llistats (LlistatUsuaris i LlistatTasques)
        llistats(){
          this.rol=localStorage.getItem("Rol");
          this.nom=localStorage.getItem("NomUsuari");
          this.llistarTasques();
          if(this.rol!='Tecnic'){
            this.getListUsers();
          }
         
        },
        //Mètode que envia la informació de la tasca al component tasca_form
        enviarTasca(infoTasca){
          this.isHidden=true
          this.tascaSeleccionada = infoTasca
          this.modify=true
        },
        //Mètode que enviem al component tasca_form buit per nova tasca
        afegirTasca(){
          this.isHidden=true
          this.tascaSeleccionada = {}
          this.modify=false
        },
        //Mètode que ens recupera un llistat d'usuaris
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
    //Mètode no utilitzat al final (utilitzat en versions anteriors)
    canvi(event) {
      this.filtre = event.target.value;
    },
    //Mètode que mostra els alert de manera maca (Inferior)
    snackbarCreator(input) {
            this.textSnack = input;
            this.snackbar = true;
        }

  },
  mounted() {
    this.llistats();
    //Si no detecta token usuari o ha acabat el temps de sessió tornem al inici
    if (!localStorage.getItem("token_usuari") || localStorage.getItem('expire_time') < Date.now()) {
      localStorage.clear();
      this.$router.push("/");
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
.fitxa1 img {
  width: auto;
  height: 500px;
  filter: drop-shadow(2px 4px 6px black);
}
html {
  overflow: hidden;
}
#creartasca polygon {
  border: none !important;
  stroke-width: 0px !important;
  fill: var(--honeyH) !important;
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