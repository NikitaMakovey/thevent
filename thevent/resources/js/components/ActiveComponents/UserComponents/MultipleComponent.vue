<template>
    <div class="album py-5 bg-light">
        <div class="container">
            <div>
                <p class="display-4">Пользователи</p>
            </div>
            <v-divider></v-divider>
            <div class="row">
                <div class="col-md-2" v-for="user in USERS" :key="user.id">
                    <div class="card mb-2 box-shadow">
                        <img class="card-img-top" :src="user.image" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text">
                                <router-link
                                    :to="{ name: 'user', params: { id: user.id } }"
                                >
                                    {{ user.second_name }} {{ user.first_name }} {{ user.third_name }}
                                </router-link>
                            </p>
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
            this.$store.dispatch('GET_USERS');
        },
        computed: {
            ...mapGetters(['USERS'])
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
