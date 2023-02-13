<template>
    <svg class="hexagon" style="width:200px; height: 200px; filter: drop-shadow(5px 5px 7px black);">
        <polygon stroke="black" stroke-width="5px" points="100,0 188,48 188,152 100,200 12,152 12,48 100,0" :style="{fill: colorFitxa()}"></polygon>
        <text x="50%" y="50%" text-anchor="middle" alignment-baseline="middle" style="font-size: 16px;">
        <tspan x="50%" dy="0px">{{input_data}}</tspan>
        <tspan x="50%" dy="50px">{{prioritat}}</tspan>
        </text>
    </svg>
</template>

<script>
import tasca_form from '@/components/tasca_form.vue'
export default {
    name: 'tasca_fitxa',
    props: ['input_data', 'prioritat'],
    data() {
        return {
            numero: this.prioritat
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
        colorFitxa() {
      switch (this.numero) {
        case "0":
          return "var(--honeyA)"
        case "1":
        case "2":
          return "var(--honeyE)";
        case "3":
        case "4":
          return "var(--honeyD)";
        case "5":
        case "6":
          return "var(--honeyC)";
        case "7":
        case "8":
          return "var(--honeyB)";
        case "9":
          return "var(--honeyB)";
        default:
          return 'gray';
      }
    }
    }
}
</script>

<style>
</style>