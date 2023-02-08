<template>
    
    <v-layout id="toolbar">
      <v-navigation-drawer
        expand-on-hover
        disable-resize-watcher
        rail
      >
        <v-list>
          <v-list-item
            prepend-avatar="../assets/LOGO_Admin.png"
            title="UserGestor"
            subtitle="El que tengo aqui colgado"
          ></v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list density="compact" nav>
          <v-list-item prepend-icon="mdi-folder" title="My Files" value="myfiles"></v-list-item>
          <v-list-item prepend-icon="mdi-account-multiple" title="Shared with me" value="shared"></v-list-item>
          <v-list-item prepend-icon="mdi-star" title="Starred" value="starred"></v-list-item>
        </v-list>
      </v-navigation-drawer>

      <v-main style="height: 250px"></v-main>
    </v-layout>

    <v-footer class="d-flex flex-column" id="footer">
    <div class="bg-teal d-flex w-100 align-center px-4">
      <strong>Get connected with us on social networks!</strong>

      <v-spacer></v-spacer>

      <v-btn
        v-for="icon in icons"
        :key="icon"
        class="mx-4"
        :icon="icon"
        variant="plain"
        size="small"
      ></v-btn>
    </div>

    <div class="px-4 py-2 bg-black text-center w-100">
      {{ new Date().getFullYear() }} — <strong>Vuetify</strong>
    </div>
  </v-footer>
  
</template>

<script>
export default {
    name: 'toolbarComp',
    props: ['rol'],
    data() {
        return {
            
        }
    },
    components: {
    },  
    methods: {
        /* 
            Function: checkRol

            Comprovació del rol de l’usuari

            Parameters:
                none
        */
        // checkRol() {
        //     var apikey = "";
        //     var input = "";
        //     var output = "";
        // },

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
  background-color: #e9e978;
}
.bg-black{
  background-color: #d58821 !important;
}
</style>