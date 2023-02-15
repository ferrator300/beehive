<template>
    <v-layout id="toolbar">
      <v-navigation-drawer
        expand-on-hover
        permanent
        rail
      >
        <v-list>
          <v-list-item
            id="avatar"
            :prepend-avatar="avatarPath"
            :title=nom
            :subtitle=rol
          ></v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list density="compact" nav>
          <router-link to="/portada">
            <v-list-item prepend-icon="mdi-home" title="Tasques" value="tasques"></v-list-item>
          </router-link>
          <router-link to="/users">
            <v-list-item prepend-icon="mdi-account-cog" title="Usuaris" value="usuaris"></v-list-item>
          </router-link>
          <router-link to="/">
            <v-list-item @click="handleLogout" prepend-icon="mdi-logout-variant" title="Sortir" value="logout"></v-list-item>
          </router-link>

        </v-list>
      </v-navigation-drawer>

      <v-main style="height: 250px"></v-main>
    </v-layout>
  
</template>

<script>
import { RouterLink } from 'vue-router';
import LOGO_Tecnic from '@/assets/LOGO_Tecnic.png';
import LOGO_Admin from '@/assets/LOGO_Admin.png';
import LOGO_Gestor from '@/assets/LOGO_Gestor.png';

export default {
    name: 'toolbarComp',
    props: ['rol', 'nom'],
    components: {
    RouterLink
},
data(){
  return{
    img: '@/assets/LOGO_Admin.png' 
    
  }
},
computed: {
  avatarPath() {
      if (this.rol === 'Tecnic') {
        return LOGO_Tecnic;
      } else if (this.rol === 'Gestor') {
        return LOGO_Admin;
      } else {
        return LOGO_Gestor;
      }
    }
  },
    methods: {
        /* 
            Function: checkRol

            Comprovació del rol de l’usuari

            Parameters:
                none
        */
        checkRol() {
            var apikey = "";
            var input = "";
            var output = "";
        },
        handleLogout() {
          localStorage.clear();
        }

        /* 
            Function: buildToolbar

            Addició d’eines al menú lateral segons el valor del paràmetre que rep rol

            Parameters:
                rol -  nivell d'accés de l'usuari ['Admin, Gestor, Tecnic']
        */
        // buildToolbar() {
        //     var apikey = "";
        //     var input = "";
        //     var output = "";
        // }
    }
}
</script>

<style>
#toolbar{
    height: 100%;
    border: none;
    background-color: none;
    z-index: unset !important;
    background-color: var(--honeyF);
    box-shadow: 1px 1px black;
}
#toolbar img {
  object-fit: contain;
}
#footer{
  width: 100%;
  padding:0%;
}
nav{
    padding: 0%;
}
.v-navigation-drawer__content{
  background-color: #d58821;
}
.bg-teal{
  background-color: #d58821 !important;
}
.v-layout{
  /* background-color: #e9e978; */
}
.bg-black{
  background-color: #d58821 !important;
}
</style>