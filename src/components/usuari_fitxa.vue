<template>
    <usuari_form :input_data="'test'" :rol="Tecnic" :action="UPDATE"></usuari_form>
    
</template>

<script>
import usuari_form from '@/components/usuari_form.vue'
export default {
    name: 'usuari_fitxa',
    props: ['input_data'],
    components: {
        usuari_form
    },  
}
</script>

<style>
</style>