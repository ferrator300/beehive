<template>
    <v-card id="user_form">
        <v-btn icon="mdi-close" class="user_form_close" @click="close()" />
        <h2>Crear usuari</h2><br>
        <div class="create_rol">
            <span>
                <h2>Gestor</h2>
                <img src="@/assets/LOGO_Admin.png" @click="sendRol('Gestor')" />
            </span>
            <span>
                <h2>Tecnic</h2>
                <img src="@/assets/LOGO_Tecnic.png" @click="sendRol('Tecnic')" />
            </span>
        </div>
    </v-card>

</template>

<script>
export default {
    name: 'rol_selector',
    props: ['input_data'],
    data() {
        return {
            act: this.action
        }
    },
    components: {
    },
    methods: {
        /* 
            Function: sendRol

            Envia al creador d'usuaris el rol que hem seleccionat

            Parameters:
                rol - rol que assignarem a l'usuari creat
        */
        sendRol(rol) {
            if (rol == 'Gestor')
                this.$emit('gestor');
            else
                this.$emit('tecnic');
        },
        close() {
            this.$emit('tancarRol');
        }
    }
}
</script>

<style>
#user_form {
    position: fixed;
    top: 15%;
    left: 20%;
    width: 70%;
    height: 70%;
    padding: 50px;
}

.create_rol {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: flex-end;
}

.user_form_close {
    left: 50%;
    position: relative;
}

div.create_rol img {
    widows: 30%;
    height: 30%;
    scale: 0.8;
    filter: drop-shadow(5px 5px 7px black);
    transition: all 0.4s;
    cursor: pointer;
}

div.create_rol img:hover {
    scale: 0.85;
}

.form_user_btn {
    display: flex;
    justify-content: center;
    gap: 30px;
}
</style>