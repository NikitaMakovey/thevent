<template>
    <div>
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Наша платформа - ваше развитие</h1>
                <p class="lead text-muted">
                    The comrade sings riddle like a rough seashell.
                    Urchin is a rainy comrade.
                    Gar, never lead a fish.
                    Misty, warm suns quietly love a weird, addled lad.
                </p>
                <p>
                    <v-btn to="/" dark class="my-2">Мероприятия</v-btn>
                    <v-btn to="/users" dark class="my-2">Пользователи</v-btn>
                </p>
            </div>
        </section>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-4" v-for="event in EVENTS" :key="event.id">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" :src="event.image" alt="Card image cap">
                            <div class="card-body">
                                <p class="card-text">{{ event.title }}</p>
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
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        mounted() {
            this.$store.dispatch('GET_EVENTS');
        },
        computed: {
            ...mapGetters(['EVENTS'])
        }
    }
</script>

<style scoped>
    .card img {
        object-fit: cover;
        width: 100%;
        height: 12rem;
    }
</style>
