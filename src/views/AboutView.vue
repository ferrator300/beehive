<template id="avislegal">
  <div class="about">
    <h1>Avis Legal i Política de Privacitat </h1>
    <br>
    <router-link id="tornar" to="/portada">
      <v-btn rounded="pill" size="large">Tornar a la Pàgina Princial</v-btn>
    </router-link>
    <br>
    <br>
    <h3>A través d'aquest lloc web no es demanen dades de caràcter personal de les persones usuàries sense el seu coneixement, ni se cedeixen a tercers.<br><br>

  Amb la finalitat d'oferir-vos el millor servei i amb l'objecte de facilitar-ne l'ús, s'analitzen el nombre de pàgines visitades, el nombre de visites, així com l'activitat de les persones visitants i la seva freqüència d'utilització. A aquest efecte, l‟Agència Espanyola de Protecció de Dades (BeeHive) utilitza la informació estadística elaborada pel Proveïdor de Serveis d‟Internet.<br><br>
	
  BeeHive no utilitza galetes per recollir informació de les persones usuàries, ni registra les adreces IP d'accés. Únicament s'utilitzen cookies pròpies, de sessió, amb finalitat tècnica (aquelles que permeten la navegació a través del lloc web i la utilització de les diferents opcions i serveis que hi existeixen).<br><br>
	
  El portal del qual és titular BeeHive conté enllaços a llocs web de tercers, les polítiques de privadesa dels quals són alienes a la de BeeHive. En accedir a aquests llocs web vostè pot decidir si accepta les seves polítiques de privadesa i de cookies. Amb caràcter general, si navega per internet vostè pot acceptar o rebutjar les galetes de tercers des de les opcions de configuració del seu navegador.</h3>
  
  <img id="imatge" src="@/assets/abella.png">
  </div>
</template>
<style>

.about{
  width: 100%;
  height: 100%;
  background-color: var(--honeyF);
  overflow-y: auto;
  height: 800px; /* altura fija en píxeles */
}
#imatge{
  width:250px;
  height:250px;
}
#tornar{
  font-size: 20px;
}
#avislegal{
  overflow: auto;
}
</style>
