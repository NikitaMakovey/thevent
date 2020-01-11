<template>
    <v-app id="inspire" class="auth-field">
        <v-content>
            <v-container class="fill-height" fluid>
                <router-view></router-view>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        name: "MainComponent"
    }
</script>

<style scoped>
    .auth-field {
        background-color: rgba(120, 101, 66, 0.22);
    }
</style>
