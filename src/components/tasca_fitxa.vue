<template>
    <svg class="hexagon" style="width:200px; height: 200px; filter: drop-shadow(5px 5px 7px black);">
        <polygon :stroke="colorFitxa" stroke-width="8" points="100,0 188,48 188,152 100,200 12,152 12,48 100,0" style="fill:var(--honeyE)" stroke-linejoin="round"></polygon>
        <text x="50%" y="40%" text-anchor="middle" alignment-baseline="middle" style="font-size: 16px; max-width: 50px;">
        <tspan class="icona" x="50%" dy="0px">{{iconesEstat}}</tspan>
        <tspan x="50%" dy="40px" style="font-weight: bold; font-size: 18px;" textLength="150" lengthAdjust="spacingAndGlyphs">{{input_data}}</tspan>
        </text>
    </svg>
</template>

<script>
import tasca_form from '@/components/tasca_form.vue'
export default {
    name: 'tasca_fitxa',
    props: ['input_data', 'prioritat', 'estat'],
    data() {
        return {
            numero: this.prioritat,
        }
    },
    components: {
        tasca_form
    }, 
    computed: {
        iconesEstat(){
        if(this.estat==="todo"){
            return "⏳";
        }
        else if(this.estat==="ongoing"){
            return "⚙️";
        }
        else if(this.estat==="done"){
            return "✅";
        }
        else{
            return "➕"; 
        }

    },
    colorFitxa() {
      switch (this.prioritat) {
        case "1":
        case "2":
          return "lightgreen";
        case "3":
        case "4":
          return "gold";
        case "5":
        case "6":
          return "orange";
        case "7":
        case "8":
          return "red";
        case "9":
          return "black";
      }
    },
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
    colorBorder(){
        if(this.est==="todo"){
            return "yellow";
        }
        else if(this.est==="ongoing"){
            return "red";
        }
        else{
            return "green";
        }

    },
    }
}
</script>

<style>
.icona {
    font-size: 3em;
}
.hexagon {
    transition: all 0.5s ease-in-out;
    cursor: pointer;
}
.hexagon:hover{
    scale: 1.1;
}
</style>