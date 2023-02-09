<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/LOGO_FINAL.png">
    <h1>BeeHive</h1>
    <login></login>
  </div>
</template>

<script>
// @ is an alias to /src
import login from '@/components/login_form.vue'

export default {
  name: 'HomeView',
  components: {
    login
  }
}
</script>

<style>
</style>
