<template>
    <div class="album">
        <v-container
            id="scroll-target"
            style="max-height: 94vh"
            class="overflow-y-auto"
        >
            <v-col cols="12">
                <v-row>
                    <p class="display-1">Заявки</p>
                </v-row>
            </v-col>
            <div class="row" style="height: 90vh">
                <div class="col-md-4" v-for="(request, i) in EM_REQUEST" :key="i">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" :src="request.image" alt="Card image cap">
                        <div class="card-body pa-2">
                            <p class="card-text" style="color: #1d2124">
                                {{ request.first_name }} {{ request.second_name }} ({{ request.name }})
                            </p>
                            <div class="d-flex justify-content-between align-items-center pa-0">
                                <div class="btn-group">
                                    <v-btn
                                        class="ma-2" tile
                                        color="indigo" dark
                                        @click="deleteRequest(request.user_id, request.role_id)"
                                    >
                                        Отклонить
                                    </v-btn>
                                    <v-btn
                                        class="ma-2" tile
                                        outlined color="success"
                                        @click="updateRequest(request.user_id, request.role_id)"
                                    >
                                        Одобрить
                                    </v-btn>
                                </div>
                            </div>
                        </div>
                        <v-expansion-panels class="pa-0">
                            <v-expansion-panel>
                                <v-expansion-panel-header>Комментарий</v-expansion-panel-header>
                                <v-expansion-panel-content style="color: #495057">
                                    {{ request.comment }}
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-expansion-panels>
                    </div>
                </div>
            </div>
        </v-container>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import axios from 'axios';

    export default {
        mounted() {
            let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
            let config = {
                headers: {
                    Authorization: token
                }
            };
            this.$store.dispatch('GET_EM_REQUEST', { id: this.$route.params.id, config: config });
        },
        computed: {
            ...mapGetters(['EM_REQUEST'])
        },
        methods: {
            deleteRequest: function (user_id, role_id) {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let data = {
                    user_id: user_id,
                    role_id: role_id
                };
                let path = '/api/auth/dashboard/event-moderator/events/' + this.$route.params.id + '/delete';
                axios.post(path, data, config)
                    .then(() => {
                        this.$store.dispatch('GET_EM_REQUEST', { id: this.$route.params.id, config: config });
                    })
            },
            updateRequest: function (user_id, role_id) {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let data = {
                    user_id: user_id,
                    role_id: role_id
                };
                let path = '/api/auth/dashboard/event-moderator/events/' + this.$route.params.id + '/update';
                axios.post(path, data, config)
                    .then(() => {
                        this.$store.dispatch('GET_EM_REQUEST', { id: this.$route.params.id, config: config });
                    })
            }
        }
    }
</script>

<style scoped>
    .card img {
        object-fit: cover;
        width: 100%;
        height: 10rem;
    }
</style>
