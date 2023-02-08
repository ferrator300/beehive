<template>
    <log_in></log_in>
</template>

<script>
import log_in from '@/components/login_form.vue'
export default {
    name: 'PortadaView',
    props: [],
    data() {
        return {
            tasques: "hola"
        }
    },
    components: {
        log_in
    },
    methods: {
        /* 
            Function: getGraph

            Obtenim un percentatge de tasques completades per mostrarles a la portada

            Parameters:
                none
        */
        // getGraph() {
        //     var apikey = "";
        //     var input = "beehive.daw.institutmontilivi.cat/API/Graph";
        //     var output = "";
        // }
    }
}
</script>