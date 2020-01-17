<template>
<div>
    <header>
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-4">
                        <h4 class="text-white">О нас</h4>
                        <p class="text-muted">
                            Instead of blending ripe hollandaise sauce with strudel,
                            use half a kilo adobo sauce and a dozen and a half teaspoons dill basin.
                            With walnuts drink ricotta.
                            To the smooth oysters add noodles, rice, ground beef lassi and quartered chicory.
                            Crush a handfull bok choys, melon, and anise in a large cooker over medium heat,
                            simmer for six minutes and soak with some zucchini.
                        </p>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-4">
                        <ul class="list-unstyled">
                            <li>
                                <router-link to="/" class="text-white">
                                    <span class="title">Мероприятия</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/users" class="text-white">
                                    <span class="title">Участники</span>
                                </router-link>
                            </li>
                            <template v-if="ACCESS_TOKEN">
                                <li>
                                    <router-link to="/user" class="text-white">
                                        <span class="title">Профиль</span>
                                    </router-link>
                                </li>
                                <li>
                                    <router-link to="/recommendations" class="text-white">
                                        <span class="title">Рекомендации</span>
                                    </router-link>
                                </li>
                                <li>
                                    <router-link to="/calendar" class="text-white">
                                        <span class="title">Календарь</span>
                                    </router-link>
                                </li>
                                <li>
                                    <router-link to="/request" class="text-white">
                                        <span class="title">Организовать мероприятие</span>
                                    </router-link>
                                </li>
                                <template v-if="DASHBOARD_ACCESS == 1">
                                    <li>
                                        <router-link to="/dashboard" class="text-white">
                                            <span class="title">Приборная панель</span>
                                        </router-link>
                                    </li>
                                </template>
                                <li>
                                    <v-btn dark class="text-white pa-0 ma-0" @click="logout">
                                        <span class="title">Выйти</span>
                                    </v-btn>
                                </li>
                            </template>
                            <template v-else>
                                <li>
                                    <router-link to="/auth/login" class="text-white">
                                        <span class="title">Войти</span>
                                    </router-link>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark box-shadow">
            <div class="container d-flex justify-content-between">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    <strong>ThEvent</strong>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
      </div>
    </header>

    <main role="main">
        <router-view></router-view>
    </main>

    <footer class="text-muted bg-dark">
      <div class="container">
        <p class="title basic-footer">{{ new Date().getFullYear() }} &copy; ThEvent</p>
      </div>
    </footer>
</div>

</template>

<script>
    export default {
        methods: {
            logout() {
                console.log(this.$store.getters.ACCESS_TOKEN);
                this.$store.dispatch('LOGOUT_USER').then(() => { this.$router.push({ name: 'events' }) });
            }
        },
        computed: {
            ACCESS_TOKEN() { return this.$store.getters.ACCESS_TOKEN },
            DASHBOARD_ACCESS() { return this.$store.getters.DASHBOARD_ACCESS }
        }
    }
</script>

<style scoped>
    main {
        min-height: 1400px;
    }
    @media screen and (min-width: 2000px) {
        main {
            min-height: 1800px;
        }
    }
    .basic-footer {
        color: #b8cfe0;
    }
</style>
