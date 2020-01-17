<template>
    <v-container
        id="scroll-target"
        style="max-height: 94vh"
        class="overflow-y-auto"
    >
        <v-row style="height: 94vh">
            <v-col cols="12">
                <v-card>
                    <v-col cols="12" class="pa-1">
                        <p class="event-title">{{ MM_REQUEST.title }}</p>
                    </v-col>
                </v-card>
                <v-card class="my-2 px-2">
                    <v-row class="pa-4">
                        <v-col cols="12" sm="8" md="8" class="divider-right">
                            <div class="px-2">
                                <div class="content-container">
                                    <p class="event-text">{{ MM_REQUEST.short_description }}</p>
                                </div>
                                <div class="image-container">
                                    <img :src="MM_REQUEST.image" alt="EVENT IMAGE">
                                </div>
                                <div class="content-container">
                                    <p class="event-text">{{ MM_REQUEST.full_description }}</p>
                                </div>
                            </div>
                        </v-col>
                        <v-col cols="12" sm="4" md="4" class="">
                            <div class="px-2">
                                <div class="content-container">
                                    <p class="info-text">
                                        <strong>Дата: </strong>{{ $moment(MM_REQUEST.event_date).format('LL') }}
                                    </p>
                                </div>
                                <div class="content-container">
                                    <p class="info-text">
                                        <strong>Время: </strong>
                                        {{ MM_REQUEST.start_at }} -
                                        {{ MM_REQUEST.end_at }}
                                    </p>
                                </div>
                                <div class="content-container">
                                    <p class="info-text">
                                        <strong>Адрес: </strong>
                                        {{ MM_REQUEST.address }}
                                    </p>
                                </div>
                                <div class="content-container">
                                    <p class="info-text">
                                        <strong>Контактное лицо:</strong>
                                    </p>
                                </div>
                                <div class="content-container">
                                    <p class="info-text">
                                        <router-link :to="{ name: 'user', params: { id: MM_REQUEST.user_id } }">
                                            {{ MM_REQUEST.second_name }} {{ MM_REQUEST.first_name }} {{ MM_REQUEST.third_name }}
                                        </router-link>
                                    </p>
                                </div>
                                <div class="content-container">
                                    <p class="info-text">
                                        <v-icon class="mr-1">mdi-email-check</v-icon>
                                        {{ MM_REQUEST.email }}
                                    </p>
                                </div>
                                <div class="content-container">
                                    <p class="info-text">
                                        <v-icon class="mr-1">mdi-phone-check</v-icon>
                                        {{ MM_REQUEST.phone_number }}
                                    </p>
                                </div>
                            </div>
                        </v-col>
                    </v-row>
                </v-card>
                <v-card class="my-2 px-2">
                    <v-col cols="12">
                        <div>
                            <p class="point-text">Начисление баллов за посещение мероприятия</p>
                        </div>
                        <v-divider></v-divider>
                        <v-simple-table>
                            <template v-slot:default>
                                <tbody>
                                <tr v-for="skill in MM_REQUEST_SKILLS" class="my-lg-3">
                                    <td>
                                        <div class="ma-2 chip-container">
                                            {{ skill.skill_factor }}
                                            {{ skill.skill_factor % 10 === 1 ? "балл" :
                                            skill.skill_factor % 10 < 5 ? "балла" : "баллов" }}
                                        </div>
                                    </td>
                                    <td class="td-text">{{ skill.name }}</td>
                                </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </v-col>
                </v-card>
                <v-card class="my-2 px-2">
                    <v-col cols="12">
                        <p class="title">Комментарий к заявке</p>
                        <p class="title">{{ MM_REQUEST_COMMENT }}</p>
                    </v-col>
                </v-card>
                <v-card class="my-2 px-2">
                    <v-col cols="12">
                        <div class="text-center">
                            <v-btn
                                class="ma-2" tile
                                color="indigo" dark
                                @click="deleteRequest"
                            >
                                Отклонить
                            </v-btn>
                            <v-btn
                                class="ma-2" tile
                                outlined color="success"
                                @click="updateRequest"
                            >
                                Одобрить
                            </v-btn>
                        </div>
                    </v-col>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
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
            this.$store.dispatch('GET_MM_REQUEST', { id: this.$route.params.id, config: config });
        },
        computed: {
            ...mapGetters([
                'MM_REQUEST',
                'MM_REQUEST_COMMENT',
                'MM_REQUEST_SKILLS'
            ])
        },
        methods: {
            deleteRequest: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let path = '/api/auth/dashboard/main-moderator/requests/' + this.$route.params.id;
                axios.delete(path, config)
                    .then(() => {
                        this.$router.push({ name: 'Главный модератор' });
                    })
            },
            updateRequest: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let path = '/api/auth/dashboard/main-moderator/requests/' + this.$route.params.id;
                axios.post(path, null, config)
                    .then(() => {
                        this.$router.push({ name: 'Главный модератор' });
                    })
            }
        }
    }
</script>

<style scoped>
    .event-title {
        font-size: 2rem;
    }
    @media screen and (max-width: 700px) {
        .event-title {
            font-size: 1rem;
        }
    }
    @media screen and (min-width: 2000px) {
        .event-title {
            font-size: 4rem;
        }
    }
    .image-container img {
        object-fit: cover;
        width: 90%;
        height: 18rem;
        border-radius: 1rem;
    }
    .event-text {
        font-size: 1rem;
    }
    .info-text {
        font-size: 1rem;
    }
    .content-container {
        margin-top: 1rem !important;
        margin-bottom: 1rem !important;
    }
    .divider-right {
        border-right: 1px solid gray;
    }
    @media screen and (max-width: 700px) {
        .divider-right {
            border-right: none;
        }
        .event-text {
            font-size: 1rem;
        }
        .info-text {
            font-size: 1rem !important;
        }
        .image-container img {
            height: 10rem;
            border-radius: 0.5rem;
        }
    }
    @media screen and (min-width: 2000px) {
        .event-text {
            font-size: 2.5rem;
        }
        .info-text {
            font-size: 2.4rem !important;
        }
        .image-container img {
            height: 30rem;
            border-radius: 1rem;
        }
    }
    .chip-container {
        border: 1px solid #1b1e21;
        color: #1b1e21;
        border-radius: 1rem;
        font-size: 1rem;
        text-align: center;
        justify-content: center;
        align-content: center;
        max-width: 8rem;
    }
    .point-text {
        font-size: 2rem;
    }
    .td-text {
        font-size: 1rem;
    }
    @media screen and (min-width: 1800px) {
        .chip-container {
            padding: 0;
            border: 0;
            font-size: 3rem;
            max-width: 20rem;
        }
        .point-text {
            font-size: 4rem;
        }
        .td-text {
            font-size: 3rem;
        }
    }
    @media screen and (max-width: 700px) {
        .chip-container {
            border: 1px solid #1b1e21;
            color: #1b1e21;
            border-radius: 0.7rem;
            font-size: 0.6rem;
            text-align: center;
            justify-content: center;
            align-content: center;
            width: 3.2rem !important;
        }
        .point-text {
            font-size: 1rem;
        }
        .td-text {
            font-size: 0.6rem;
        }
    }
</style>
