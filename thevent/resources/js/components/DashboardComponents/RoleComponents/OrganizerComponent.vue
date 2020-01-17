<template>
    <div class="album">
        <v-container
            id="scroll-target"
            style="max-height: 94vh"
            class="overflow-y-auto"
        >
            <div class="row" style="height: 94vh">
                <div class="col-md-4" v-for="event in O_REQUESTS" :key="event.event_id">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" :src="event.image" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text">{{ event.title }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <v-btn
                                        type="button" class="btn btn-sm btn-outline-secondary"
                                        :to="{ name: 'o-request-r', params: { id: event.event_id } }"
                                    >
                                        Просмотреть
                                    </v-btn>
                                </div>
                                <small class="text-muted">{{ $moment(event.event_date).format("LL") }}</small>
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

    export default {
        mounted() {
            let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
            let config = {
                headers: {
                    Authorization: token
                }
            };
            this.$store.dispatch('GET_O_REQUESTS', config);
        },
        computed: {
            ...mapGetters(['O_REQUESTS'])
        }
    }
</script>

<style scoped>
    .card img {
        object-fit: cover;
        width: 100%;
        height: 9rem;
    }
</style>
