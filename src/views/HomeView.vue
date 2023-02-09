<template>
  <toolbar :rol="rol"></toolbar>
  <div class="fitxa">
    <tascafitxa v-for="na in n" :input_data="na"></tascafitxa>
  </div>
  <footercustom></footercustom>
</template>

<script>
// @ is an alias to /src
import login from '@/components/login_form.vue'
import toolbar from '@/components/toolbar.vue'
import tascafitxa from '@/components/tasca_fitxa.vue'
import footercustom from '@/components/footercustom.vue'
export default {
  name: 'HomeView',
  components: {
    login,  toolbar, tascafitxa, footercustom
  },
  data() {
    return {
      n : ['a', 'b', 'c', 'd', 'e', 'f', 'g', '2', '3', '4', '5', '6']
    }
  }
}
</script>

<style>
.fitxa {
  position: absolute;
  width: -webkit-fill-available;
  height: -webkit-fill-available;
  margin: 20px;
  top: 10%;
  left: 10%;
  display: flex;
  overflow-y: auto;
  gap: 20px;
  flex-wrap: wrap;
}
html {
  overflow: hidden;
}
</style>