<template>
  <div class="home">
    <span class="portada_login">
      <div class="logo" v-bind:style="estilo">
        <img alt="Vue logo" src="@/assets/LOGO_FINAL.svg">
        <h1 id="titol">BeeHive</h1>
      </div>
      <login v-if="isHidden"></login>
    </span>
    <v-btn v-if="isHidden == false" rounded="pill" size="x-large" @click="tancar()" id="botologin">Login</v-btn>
    <h3 id="copyright">Copyright © 2023 BeeHive Tots els drets reservats</h3>
  </div>
</template>

<script>
// @ is an alias to /src
import login from '@/components/login_form.vue'

export default {
  name: 'HomeView',
  components: {
    login
  },
  data() {
    return {
      isHidden: false,
      estilo: {
        transform: 'translateX(0)'
      }
    }
  },
  methods: {
    tancar() {
      this.isHidden = true;
      this.estilo = {
        transform: 'translateX(-40%)',
        transition: 'transform 1s ease-in-out'
      };
    },
  }
}
</script>

<style>
.logo img {
  width: 200px;
}
.portada_login {
  display: flex;
  flex-direction: row;
}

#botologin {
  color: azure;
  background-color: black;
}

#titol {
  font-size: 75px;
}

#copyright {}

.home {
  background-color: var(--honeyG);
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  gap: 50px
}
</style>
