<template>
  <div class="home">
    <div class="logo" v-bind:style="estilo">
    <img alt="Vue logo" src="../assets/LOGO_FINAL.svg">
    <h1 id="titol">BeeHive</h1>
    </div>
    <login v-if="isHidden"></login>
    <v-btn rounded="pill"  size="x-large" @click="tancar()" id="botologin">Login</v-btn>
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
    tancar()
    {
      this.isHidden = true; 
      this.estilo = {
        transform: 'translateX(-70%)',
        transition: 'transform 1s ease-in-out'
      }
    },
  }
}
</script>

<style>
  .logo img {
    position: fixed;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    height: 400px;
  }
  #botologin{
    position: fixed;
    bottom: 13%;
    left: 48%;
    color: azure;
    background-color: black;
  }
  #titol{
    position: fixed;
    bottom: 20%;
    left: 35%;
    font-size: 75px;
  }
  #copyright{
    position: fixed;
    bottom: 5%;
    left: 35%;
  }
  .home{
    width: 100%;
    height: 100%;
    background-color: var(--honeyG);
  }
  .logo{
    margin-left: 25%;
    margin-right: 25%;
    width: 50%;
    height: 100%;
  }
  
</style>
