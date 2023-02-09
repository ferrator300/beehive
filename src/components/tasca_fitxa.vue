<template>
    <svg class="hexagon"  id="hexagon-0-0">
            <polygon points="50,0 94,24 94,76 50,100 6,76 6,24 50,0" style="fill: yellow;"></polygon>
            <text x="17%" y="35%" text-anchor="middle" alignment-baseline="middle" style="font-size: 12px;">{{input_data}}</text>
        </svg>
</template>

<script>
import tasca_form from '@/components/tasca_form.vue'
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
h1 {
    width: 50px;
    height: 50px;
    background-color: aqua;
}
</style>