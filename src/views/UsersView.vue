<template>
    <toolbar :rol="userRol" :nom="userName"></toolbar>
    <div class="fitxa">
        <h1>Gestió d'usuaris</h1>
        <div class="contentList">
            <v-card class="list">
                <v-table id="tableUsers">
                    <thead>
                        <tr>
                            <th>
                                Nom
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Rol
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="usuari" v-for="user in llistat" :key="user">
                            <td>{{ user.Nom }}</td>
                            <td>{{ user.Email }}</td>
                            <td v-if="user.Rol == 'Gestor'"><img src="@/assets/LOGO_Admin.png" /></td>
                            <td v-if="user.Rol == 'Tecnic'"><img src="@/assets/LOGO_Tecnic.png" /></td>
                            <td><v-btn class="btn" id="modifyUser" icon="mdi-pencil" size="x-small"
                                    @click="modifyUser(user)" />
                            </td>
                        </tr>
                    </tbody>
                </v-table>
            </v-card>
            <v-btn class="btn" id="createUserBtn" size="large" @click="openCreator()">Nou Usuari</v-btn>
        </div>
    </div>
    <creatorForm v-if="showCreator" @tancarRol="showCreator = false" @tecnic="createUser('Tecnic')"
        @gestor="createUser('Gestor')"></creatorForm>
    <userForm :input_data="userFormData" :rol="role" :action="modify" v-if="showForm" @tancar="showForm = false"
        @snack="snackbarCreator($event, $event1)">
    </userForm>

    <v-snackbar absolute v-model="snackbar">
        {{ textSnack }}
        <template v-slot:actions>
            <v-btn color="pink" variant="text" @click="snackbar = false">
                Close
            </v-btn>
        </template>
    </v-snackbar>

    <footercustom></footercustom>
</template>

<script>
import createUser from '@/components/usuari_fitxa.vue'
import userForm from '@/components/usuari_form.vue'
import toolbar from '@/components/toolbar.vue'
import footercustom from '@/components/footercustom.vue'
import creatorForm from '@/components/role_selector.vue'
export default {
    name: 'UserView',
    props: [],
    data() {
        return {
            llistat: {},
            showForm: false,
            showCreator: false,
            userFormData: {},
            modify: false,
            role: "",
            textSnack: "",
            snackbar: false,
            userRol: localStorage.getItem('Rol'),
            userName: localStorage.getItem('NomUsuari')
        }
    },
    components: {
        createUser,
        userForm,
        toolbar,
        footercustom,
        creatorForm
    },
    methods: {
        /* 
            Function: getListUsers()

            Crida a l’API per al llistat d’usuaris

            Parameters:
                none
        */
        getListUsers() {
            var userToken = localStorage.getItem("token_usuari");
            var input = "http://beehive.daw.institutmontilivi.cat/API/Usuari/Llistat";

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("PUT", input, false);
            xmlhttp.setRequestHeader("Content-type", "application/json");
            xmlhttp.send(JSON.stringify(userToken));
            if (xmlhttp.status == 200) {
                this.llistat = JSON.parse(xmlhttp.responseText);
            }
            else {
                alert("ERROR API: No s'ha pogut llistar usuaris de la BDD");
            }
        },

        /* 
            Function: modifyUser(id)

            Crida al component de formulari de modificació d’usuari amb els valors de l'usuari passat per paràmetre

            Parameters:
                id - Usuari que volem modificar
        */
        modifyUser(id) {
            console.log(id)
            this.showForm = true;
            this.userFormData = id;
            this.role = id.Rol;
            this.modify = true;
        },
        /* 
           Function: createUser()

           Crida al component de formulari de creació d’usuari

           Parameters:
               rol - rol de l'usuari que volem crear
       */
        createUser(rol) {
            this.showCreator = false;
            this.showForm = true;
            this.userFormData = {};
            this.role = rol;
            this.modify = false;
        },
        openCreator() {
            this.showForm = false;
            this.showCreator = true;
            this.userFormData = {};
            this.role = "";
            this.modify = false;
        },
        snackbarCreator(input) {
            this.textSnack = input;
            this.snackbar = true;
        }

    },
    mounted() {
        this.getListUsers();
        if (localStorage.getItem('Rol') != 'Admin') {
            this.$router.push("portada");
        }
        if (!localStorage.getItem("token_usuari") || localStorage.getItem('expire_time') < Date.now()) {
            localStorage.clear();
            this.$router.push("/");
        }
    }
}
</script>

<style>
.fitxa {
    position: absolute;
    width: -webkit-fill-available;
    height: 100%;
    top: 2%;
    left: 40px;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    flex-wrap: wrap;
}

div.contentList {
    display: flex;
    overflow-y: auto;
    width: -webkit-fill-available;
    flex-grow: 5;
    align-items: flex-start;
    align-content: stretch;
    justify-content: center;
    flex-grow: 5;
}

div.content .create {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.list {
    overflow-y: auto;
    width: -webkit-fill-available;
    width: 100%;
    margin: 20px;
    margin-left: 40px;
    overflow-y: auto;
    height: 80%;
}

.list,
.list table {
    background-color: var(--honeyG);
}

.btn {
    background-color: var(--honeyE);
}
@media (max-width: 800px) {
    .btn {
        left: 40%;
    }
}

.list td,
th {
    text-align: center !important;
    vertical-align: middle !important;
}

#usuari img {
    width: 40px;
    height: auto;
    vertical-align: middle;
}

#createUserBtn {
    position: fixed;
    left: 48%;
    top: 87%;
}


</style>