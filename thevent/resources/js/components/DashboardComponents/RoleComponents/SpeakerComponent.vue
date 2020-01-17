<template>
    <div class="album">
        <v-container
            id="scroll-target"
            style="max-height: 94vh"
            class="overflow-y-auto"
        >
            <div class="row" style="height: 94vh">
                <div class="col-md-4" v-for="(event, i) in S_REQUESTS" :key="i">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" :src="event.image" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text">{{ event.title }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $moment(event.event_date).format("LL") }}</small>
                            </div>
                        </div>
                        <v-expansion-panels class="pa-0">
                            <v-expansion-panel>
                                <v-expansion-panel-header>Информация о лекции</v-expansion-panel-header>
                                <v-expansion-panel-content style="color: #495057">
                                    {{ event.comment }}
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

    export default {
        mounted() {
            let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
            let config = {
                headers: {
                    Authorization: token
                }
            };
            this.$store.dispatch('GET_S_REQUESTS', config);
        },
        computed: {
            ...mapGetters(['S_REQUESTS'])
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
