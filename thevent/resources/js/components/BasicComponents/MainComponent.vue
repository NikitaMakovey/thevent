<template>
<div>
    <header>
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-4">
                        <p class="text-white title">О нас</p>
                        <p class="text-muted title">
                            ThEvent - уникальная онлайн-платформа, на которой собраны
                            самые актуальное мероприятия! Организатор, спикер, волонтер,
                            участник - попробуй себя в любой роли! ThEvent поможет
                            воплотить самые смелые задумки в жизнь!
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
                                    <v-btn dark text class="text-white pa-0 ma-0 logout-btn" @click="logout">
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
                <router-link :to="{ name: 'events' }" class="navbar-brand d-flex align-items-center">
                    <strong>ThEvent</strong>
                </router-link>
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
    * {
        text-decoration-style: inherit !important;
    }
    main {
        min-height: 1000px;
    }
    @media screen and (min-height: 1200px) and (max-height: 1800px) {
        main {
            min-height: 1800px;
        }
    }
    .basic-footer {
        color: #b8cfe0;
    }
</style>
