<template>
    <usuari_form :input_data="'test'" :rol="Tecnic" :action="UPDATE"></usuari_form>
    
</template>

<script>
import usuari_form from '@/components/usuari_form.vue'
export default {
    name: 'usuari_fitxa',
    props: ['input_data'],
    // data() {
    //     return {
    //         rol: 'Tecnic',
    //         action: 'UPDATE'
    //     }
    // },
    components: {
        usuari_form
    },  
    methods: {
        /* 
            Function: openInfo

            Mostrem component d’informació, relacionat amb aquella tasca.

            Parameters:
                none
        */
        // openInfo(id) {
        //     var apikey = "";
        //     var input = "";
        //     var output = "";
        // }
    }
}
</script>

<style>
</style>