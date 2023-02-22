<template>
    <v-card id="tasca_form" v-if="isHidden">
        <v-btn id="boto" icon="mdi-close" class="user_form_close" @click="tancar()" />
        <h1 v-if="action">Modificar Tasca</h1>
        <h1 v-if="action == false">Crear Tasca</h1>
        <span class="form-content">
            <span class="from-content-vertical">
                <!--NOM-->
                <v-text-field class="formulari" v-model="informacio.Nom" label="Nom"
                    :disabled="rol === 'Tecnic'"></v-text-field>
                <!--TREBALLADOR-->
                <v-select class="formulari" :items="usuaris" v-model="informacio.Email" dense solo label="Responsable"
                    :disabled="rol === 'Tecnic'"></v-select>
            </span>
            <span class="from-content-vertical">
                <!--DESCRIPCIO-->
                <v-textarea class="formulari" v-model="informacio.Descripcio" label="Descripció"
                    :disabled="rol === 'Tecnic'"></v-textarea>
            </span>
            <span class="from-content-vertical">
                <!--PRIORITAT-->
                <v-slider class="formulari" hint="Prioritat" step="1" thumb-label="hover" max="9" min="1"
                    v-model="informacio.Prioritat" label="Prioritat" :disabled="rol === 'Tecnic'"></v-slider>
                <!--ESTAT-->
                <v-select class="formulari" :items="items" v-model="informacio.Estat" dense solo
                    label="Estat"></v-select>
            </span>
        </span>
        <span class="form-content">
            <span class="from-content-vertical">
                <v-text-field class="formulari" v-model="informacio.DataInici" type="datetime-local"
                    label="Data d'Inici" :disabled="rol === 'Tecnic'"></v-text-field>
                <v-text-field class="formulari" v-model="informacio.DataFi" type="datetime-local" label="Data Final"
                    :disabled="rol === 'Tecnic'"></v-text-field>
            </span>
            <span class="from-content-vertical">
                <v-textarea class="formulari" v-model="informacio.Comentaris" label="Comentaris"></v-textarea>
            </span>
            <span class="from-content-vertical">
                <v-btn v-if="rol !== 'Tecnic' && action" @click="actualitzarTasca()" style="margin-left:10px;"
                    color="warning">Editar Tasca</v-btn>
                <v-btn v-if="action" @click="tramitarTasca()" color="secondary" style="margin-left:10px;">Tramitar
                    Tasca</v-btn>
                <v-btn v-if="rol !== 'Tecnic' && action" color="error" @click="eliminarTasca()"
                    style="margin-left:10px;">Eliminar Tasca</v-btn>
                <v-btn v-if="action == false" @click="crearTasca()" color="success">Crear Tasca</v-btn>
            </span>
        </span>
        <v-text-field v-if="hideId" id="idTasca" type="hidden" v-bind="informacio.IdTasca"></v-text-field>
    </v-card>
</template>

<script>
export default {
    hideId: true,
    name: 'tasca_form',
    props: ['input_data', 'treballadors', 'informacio', 'usuaris', 'rol', 'action'],
    data() {
        return {
            isHidden: true,
            items: ['Per Fer', 'En Progres', 'Finalitzada'],
            usuaris: this.usuaris,
            rol: localStorage.getItem("Rol"),
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
        tancar() {
            this.isHidden = false;
            this.$emit("tancar")
        },
        actualitzarTasca() {
            var nom = this.informacio.Nom;
            var desc = this.informacio.Descripcio;
            var datainici = this.informacio.DataInici;
            var datafi = this.informacio.DataFi;
            var estat = this.informacio.Estat;
            if(estat=="Per Fer")
            {
                estat="todo";
            }
            else if(estat=="En Progres")
            {
                estat="ongoing";
            }
            else if(estat=="Finalitzada")
            {
                estat="done";
            }
            var prioritat = this.informacio.Prioritat;
            var comentaris = this.informacio.Comentaris;
            var email = this.informacio.Email;
            var id = this.informacio.IdTasca;
            var tokenUsuari = localStorage.getItem("token_usuari");

            if (!nom || !desc || !datainici || !datafi || !estat || !prioritat || !email) {
                this.$emit('snack',"Has d'emplenar tots els camps!!");
                return;
            }

            var input = 'http://beehive.daw.institutmontilivi.cat/API/Tasca/Editar'

            var data = {
                id: id,
                nomTasca: nom,
                descripcio: desc,
                dataInici: datainici,
                dataFi: datafi,
                estat: estat,
                prioritat: prioritat,
                comentaris: comentaris,
                email: email,
                token: tokenUsuari
            };


            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("PUT", input, false);
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(data));
            if (xmlhttp.status == 200) {
                this.$emit('snack', "Tasca Editada Correctament");
                this.$emit('refrescar');
            }
            else {
                this.$emit('snack',"ERROR al Editar la Tasca");
            }
        },
        eliminarTasca() {
            var id = this.informacio.IdTasca;
            var tokenUsuari = localStorage.getItem("token_usuari");

            var url = 'http://beehive.daw.institutmontilivi.cat/API/Tasca/Eliminar'

            var data = {
                id: id,
                token: tokenUsuari
            };

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("PUT", url, false);
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(data));
            if (xmlhttp.status == 200) {
                this.$emit('snack', "Tasca Eliminada Correctament");
                this.$emit('refrescar');
            }
            else {
                this.$emit('snack',"ERROR al Eliminar la Tasca");
            }
        },
        tramitarTasca() {
            var id = this.informacio.IdTasca;
            var tokenUsuari = localStorage.getItem("token_usuari");
            var estat = this.informacio.Estat;
            if(estat=="Per Fer")
            {
                estat="todo";
            }
            else if(estat=="En Progres")
            {
                estat="ongoing";
            }
            else if(estat=="Finalitzada")
            {
                estat="done";
            }
            var comentaris = this.informacio.Comentaris;

            var url = 'http://beehive.daw.institutmontilivi.cat/API/Tasca/Tramit'

            var data = {
                id: id,
                estat: estat,
                token: tokenUsuari,
                comentaris: comentaris
            };

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("PUT", url, false);
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(data));
            if (xmlhttp.status == 200) {
                this.$emit('snack', "Tasca Tramitada Correctament");
                this.$emit('refrescar');
            }
            else {
                this.$emit('snack',"ERROR al Tramitar la Tasca");
            }
        },
        crearTasca() {
            var nom = this.informacio.Nom;
            var desc = this.informacio.Descripcio;
            var datainici = this.informacio.DataInici;
            var datafi = this.informacio.DataFi;
            var estat = this.informacio.Estat;
            if (estat == "Per Fer") {
                estat = "todo";
            }
            else if (estat == "En Progres") {
                estat = "ongoing";
            }
            else if (estat == "Finalitzada") {
                estat = "done";
            }
            var prioritat = this.informacio.Prioritat;
            var comentaris = this.informacio.Comentaris;
            var email = this.informacio.Email;
            var tokenUsuari = localStorage.getItem("token_usuari");

            if (!nom || !desc || !datainici || !datafi || !estat || !prioritat || !email) {
                this.$emit('snack',"Has d'emplenar tots els camps!!");
                return;
            }

            var input = 'http://beehive.daw.institutmontilivi.cat/API/Tasca/Crear'

            var data = {
                nomTasca: nom,
                descripcio: desc,
                dataInici: datainici,
                dataFi: datafi,
                estat: estat,
                prioritat: prioritat,
                comentaris: comentaris,
                email: email,
                token: tokenUsuari
            };


            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("PUT", input, false);
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(data));
            if (xmlhttp.status == 200) {
                this.$emit('snack', "Tasca Creada Correctament");
                this.$emit('refrescar');
            }
            else {
                this.$emit('snack',"ERROR al Crear la Tasca");
            }
        },

    }
}
</script>

<style>
#tasca_form {
    position: fixed;
    top: 5%;
    left: 10%;
    width: 85%;
    height: 85%;
    padding: 50px;
    overflow: auto;
    background-color: lightgoldenrodyellow;

    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 40px;
    overflow-x: hidden;
    z-index: 2000;

}

#tasca_form .v-input__control {
    width: 100%;
}

#boto {
    position: absolute;
    top: 1%;
    left: 1%;
}

@media (min-width: 800px) {
    .form-content {
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        gap: 20px
    }

    .from-content-vertical {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 100%;
        justify-content: center;
    }
}
</style>