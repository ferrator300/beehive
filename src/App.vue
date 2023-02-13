<template>
  <v-app>
    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: 'App',
  mounted() {
    if (!localStorage.getItem("token_usuari")) {
      this.$router.push("/");
    }
  }
}

</script>

<style>
:root {
  --honeyA: #241305;
  --honeyB: #8e4f17;
  --honeyC: #a86327;
  --honeyD: #d1b649;
  --honeyE: #cbbf73;
  --honeyF: #e9e978;
  --honeyG: #FFFFC6;
  --honeyH: #D58821;
}

#app {
  font-family: 'Nunito', 'Arial';
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}

h1 {
  font-family: 'Itim';
}
</style>
