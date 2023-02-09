<template>
    <v-footer class="d-flex flex-column" id="footer" app>
    <div class="px-4 py-2 bg-black text-center w-100">
      {{ new Date().getFullYear() }} ®BeeHive
      <router-link to="/">Avís legal</router-link>
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