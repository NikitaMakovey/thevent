<template>
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-4" v-for="event in events" :key="event.id">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" :src="event.image" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text">
                                <router-link
                                    :to="{ name: 'event', params: { id: event.id } }"
                                >
                                    {{ event.title }}
                                </router-link>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="title mr-1">{{ event.name }}</span>
                                <small class="text-muted">{{ $moment(event.event_date).format("LL") }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            events: Array
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
