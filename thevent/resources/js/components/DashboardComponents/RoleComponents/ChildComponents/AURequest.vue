<template>
    <div class="album">
        <v-container
            id="scroll-target"
            style="max-height: 85vh"
            class="overflow-y-auto"
        >
            <div class="row" style="height: 85vh">
                <div class="col-md-4" v-for="(request, i) in A_REQUESTS" :key="i">
                    <div class="card mb-4 box-shadow">
                        <img
                            class="card-img-top"
                            :src="request.image"
                            alt="Card image cap"
                        >
                        <div class="card-body pa-2">
                            <p class="card-text" style="color: #1d2124">
                                {{ request.first_name }} {{ request.second_name }} {{ request.third_name }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center pa-0">
                                <div class="btn-group">
                                    <v-btn
                                        class="ma-2" tile
                                        color="indigo" dark
                                        @click="deleteRequest(request.id)"
                                    >
                                        Сократить
                                    </v-btn>
                                    <v-btn
                                        class="ma-2" tile
                                        color="success" outlined
                                        :to="{ name: 'user', params: { id: request.id } }"
                                    >
                                        Перейти
                                    </v-btn>
                                </div>
                            </div>
                        </div>
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
            this.$store.dispatch('GET_A_REQUESTS', config);
        },
        computed: {
            ...mapGetters(['A_REQUESTS'])
        },
        methods: {
            deleteRequest: function (id) {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let path = '/api/auth/dashboard/admin/main-moderators/' + id;
                axios.delete(path, config)
                    .then(() => {
                        this.$store.dispatch('GET_A_REQUESTS', config);
                    })
            }
        }
    }
</script>

<style scoped>
    * {
        text-decoration: none !important;
    }
    .card img {
        object-fit: cover;
        width: 100%;
        height: 10rem;
    }
</style>
