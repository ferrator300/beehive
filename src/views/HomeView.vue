<template>
  <toolbar></toolbar>
</template>

<script>
// @ is an alias to /src
import login from '@/components/login_form.vue'
import toolbar from '@/components/toolbar.vue'
export default {
  name: 'HomeView',
  components: {
    login,  toolbar 
  }
}
</script>
