<template>
    <div>
        <v-bottom-navigation
            :value="this.$router.currentRoute.name === 'o-request-r' ? 0 : 1"
            grow
            color="teal"
            class="pa-0 mx-0 mb-1"
        >
            <v-btn :to="{ name: 'o-request-r' }">
                <span class="title">Заявки</span>
            </v-btn>

            <v-btn :to="{ name: 'o-request-m' }">
                <span class="title">Участники</span>
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
