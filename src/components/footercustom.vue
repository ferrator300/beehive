<template>
    <v-footer class="d-flex flex-column" id="footer" app>
    <div class="px-4 py-2 bg-black text-center w-100">
      {{ new Date().getFullYear() }} ®BeeHive
      <router-link to="/about">Avís legal</router-link>
    </div>
  </v-footer>
  
</template>

<script>
import { RouterLink } from 'vue-router';

export default {
    name: 'toolbarComp',
}
</script>

<style>
#footer{
  width: 100%;
  padding:0%;
}
nav{
    padding: 0%;
}
.v-navigation-drawer {
  border-style: none;
  box-shadow: 1px 1px 11px 0px black;
}
.v-navigation-drawer__content{
  background-color: var(--honeyH);
}
.bg-teal{
  background-color: var(--honeyH) !important;
}
.bg-black{
  background-color: var(--honeyD) !important;
}
</style>