<template>
    <div>
        <v-row class="px-10 justify-center mt-4">
            <p class="display-1">
                Рекомендованные мероприятия
            </p>
        </v-row>
        <v-divider></v-divider>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-4" v-for="event in events.data" :key="event.id">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" :src="event.image" alt="Card image cap">
                            <div class="card-body">
                                <p class="card-text">{{ event.title }}</p>
                                <p class="card-text topic-color">{{ event.name }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <v-btn
                                            type="button" class="btn btn-sm btn-outline-secondary"
                                            :to="{ name: 'event', params: { id: event.id } }"
                                        >
                                            Перейти
                                        </v-btn>
                                    </div>
                                    <small class="text-muted">{{ $moment(event.event_date).format("LL") }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <v-divider></v-divider>
                <div class="pa-0 ma-0">
                    <div class="pa-0 ma-0">
                        <pagination
                            size="large"
                            align="center"
                            :data="events"
                            @pagination-change-page="getResults"
                        ></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                events: {}
            }
        },
        methods: {
            getResults(page = 1) {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                axios.get('/api/auth/recommend?page=' + page, config)
                    .then(({data}) => {
                        this.events = data;
                    });
            }
        },
        mounted() {
            let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
            let config = {
                headers: {
                    Authorization: token
                }
            };
            axios.get('/api/auth/recommend', config)
                .then(({data}) => {
                    this.events = data;
                });
            this.getResults();
        }
    }
</script>

<style scoped>
    .card img {
        object-fit: cover;
        width: 100%;
        height: 12rem;
    }
    .topic-color {
        color: #6574cd;
    }
</style>
