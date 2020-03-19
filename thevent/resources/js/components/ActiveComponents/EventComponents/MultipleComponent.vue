<template>
    <div>
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Наша платформа - ваше развитие</h1>
                <p class="lead text-muted">
                    Принимай участие в мероприятиях и становись лучше!
                    Хочешь стать не просто участником? Присылай нам заявку, и мы её рассмотрим!
                    С нами ты можешь стать кем угодно - всё зависит от тебя.
                </p>
            </div>
        </section>
        <v-row class="px-10 justify-center">
            <v-menu
                bottom
                origin="center center"
                transition="scale-transition"
                class="justify-center"
            >
                <template v-slot:activator="{ on }">
                    <v-btn
                        text
                        dark
                        v-on="on"
                        color="#50575B"
                        class="responsive--text"
                    >
                        {{ ACTIVE_TOPIC }}
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item
                        @click="getTopic(0, 'Все мероприятия')"
                        class="route__style"
                    >
                        <v-list-item-title class="responsive--text">Все мероприятия</v-list-item-title>
                    </v-list-item>
                    <v-list-item
                        v-for="item in TOPICS"
                        :key="item.id"
                        @click="getTopic(item.id, item.name)"
                        class="route__style"
                    >
                        <v-list-item-title class="responsive--text">{{ item.name }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
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
    import {mapGetters} from 'vuex';
    import axios from 'axios';

    export default {
        data() {
            return {
                activeId: 0,
                activeTopic: 'Все мероприятия',
                events: {}
            }
        },
        methods: {
            getResults(page = 1) {
                if (this.activeId) {
                    axios.get('/api/v1/topics/' + this.activeId + '/events?page=' + page)
                        .then(({data}) => {
                            this.events = data;
                        });
                } else {
                    axios.get('/api/v1/events?page=' + page)
                        .then(({data}) => {
                            this.events = data;
                        });
                }
            },
            getTopic: function(id, content) {
                this.activeTopic = content;
                this.activeId = id;
                if (id === 0) {
                    axios.get('/api/v1/events')
                        .then(({data}) => {
                            this.events = data;
                        });
                    //this.$store.dispatch('GET_EVENTS');
                } else {
                    axios.get('/api/v1/topics/' + id + '/events')
                        .then(({data}) => {
                            this.events = data;
                        });
                    //this.$store.dispatch('GET_TOPIC_EVENTS', id);
                }
            }
        },
        mounted() {
            //this.$store.dispatch('GET_EVENTS');
            this.$store.dispatch('GET_ALL_TOPICS');
            axios.get('/api/v1/events')
                .then(({data}) => {
                    this.events = data;
                });
            this.getResults();
        },
        computed: {
            ...mapGetters(['EVENTS', 'TOPICS']),
            /**
             * @return {string}
             */
            ACTIVE_TOPIC() { return this.activeTopic }
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
