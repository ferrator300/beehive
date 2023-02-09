<template>
    <h1>tasca_fitxa</h1>
</template>

<script>
import tasca_form from 'tasca_form.vue'
export default {
    name: 'tasca_fitxa',
    props: ['input_data'],
    data() {
        return {
            
        }
    },
    components: {
        tasca_form
    },  
    methods: {
        /* 
            Function: openInfo

            Mostrem component d’informació, relacionat amb aquella tasca.

            Parameters:
                none
        */
        // openInfo() {
        //     var apikey = "";
        //     var input = "";
        //     var output = "";
        // }
    }
}
</script>

<style>
</style>