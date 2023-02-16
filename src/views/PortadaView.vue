<template>
  <div class="home">
    <span class="portada_login">
      <div class="logo" v-bind:style="estilo">
        <img alt="Vue logo" src="@/assets/LOGO_FINAL.svg">
        <h1 id="titol">BeeHive</h1>
        <v-btn rounded="pill" size="x-large" @click="tancar()" id="botologin">Login</v-btn>
      </div>
      <login v-if="isHidden"></login>
    </span>
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
        transform: 'rotate(0deg)'
      }
    }
  },
  methods: {
    tancar() {
      this.isHidden = true;
      this.estilo = {
        opacity: '0',
        transition: 'all 0.5s ease-in-out'
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
  position: fixed;
}

#copyright {
  position: fixed;
    top: 90%;
}

#botologin {
  color: azure;
  background-color: black;
}

#titol {
  font-size: 75px;
}

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
