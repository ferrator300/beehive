<template>
    <toolbar></toolbar>
    <div class="fitxa">
        <h1>Gestió d'usuaris</h1>
        <div class="content">
            <div class="create">
                <img src="@/assets/LOGO_Admin.png" @click="createUser()"/>
                <img src="@/assets/LOGO_Tecnic.png" />
            </div>
            <v-card class="list">
                <v-table>
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
                        </tr>
                    </thead>
                    <tbody v-for="user in llistat" :key="user">
                        <tr id="usuari">
                            <td>{{ user.Nom }}</td>
                            <td>{{ user.Email }}</td>
                            <td v-if="user.Rol == 'Gestor'"><img src="@/assets/LOGO_Admin.png"/></td>
                            <td v-if="user.Rol == 'Tecnic'"><img src="@/assets/LOGO_Tecnic.png"/></td>
                            <td><v-btn icon="mdi-pencil" size="x-small" @click="modifyUser(user)"/></td>
                        </tr>
                    </tbody>
                </v-table>
            </v-card>
        </div>
    </div>
    <userForm :input_data="userFormData" v-if="showForm" @tancar="showForm = false" :action="modify"></userForm>
    <footercustom></footercustom>
</template>

<script>
import createUser from '@/components/usuari_fitxa.vue'
import userForm from '@/components/usuari_form.vue'
import toolbar from '@/components/toolbar.vue'
import footercustom from '@/components/footercustom.vue'
export default {
    name: 'UserView',
    props: [],
    data() {
        return {
            llistat: {},
            rol: localStorage.getItem('rol'),
            showForm: false,
            userFormData: {},
            modify : false
        }
    },
    components: {
        createUser,
        userForm,
        toolbar,
        footercustom
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

            Crida al component de formulari de modificació d’usuari segons el valor del parametre id

            Parameters:
                id - identificador de l'usuari que volem modificar
        */
        modifyUser(id) {
            console.log(id)
            this.showForm = true;
            this.userFormData = id;
            this.modify = true;
        }
    },
    mounted() {
        this.getListUsers();
    }
}
</script>

<style>
.fitxa {
    position: absolute;
    width: -webkit-fill-available;
    height: 90%;
    top: 0%;
    left: 5%;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    flex-wrap: wrap;
}

div.content {
    display: flex;
    flex-direction: row;
    flex-grow: 5;
    gap: 100px;
    padding: 25px;
}

div.content .create {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

div.create img {
    widows: 30%;
    height: 30%;
    scale: 0.8;
    filter: drop-shadow(5px 5px 7px black);
    transition: all 0.5s;
    cursor: pointer;
}

div.create img:hover {
    scale: 0.9;
}

div.content .list {
    flex-grow: 5;
    padding: 10px;
    height: 80%;
    align-self: center;
    overflow-y: auto;
}
#list td, th {
    text-align: center !important;
    vertical-align: middle !important;
}
#usuari img {
    width: 40px;
    height: auto;
    vertical-align: middle;
}
</style>