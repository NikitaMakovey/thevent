<template>
    <div>
        <v-bottom-navigation
            :value="this.$router.currentRoute.name === 'Администратор' ? 0 : 1"
            grow
            color="teal"
            class="pa-0 mx-0 mb-1"
        >
            <v-btn :to="{ name: 'Администратор' }">
                <span class="title"> Модераторы</span>
            </v-btn>

            <v-btn :to="{ name: 'a-request-r' }">
                <span class="title">Запрос</span>
            </v-btn>
        </v-bottom-navigation>
        <div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: "OContainerRequest"
    }
</script>

<style scoped>
    * {
        text-decoration: none !important;
    }
</style>
