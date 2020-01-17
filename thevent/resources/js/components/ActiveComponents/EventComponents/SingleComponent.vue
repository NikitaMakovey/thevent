<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="10" lg="8" class="pa-0 ma-0">
            <v-card>
                <v-col cols="12">
                    <p class="event-title">{{ EVENT.title }}</p>
                </v-col>
            </v-card>
            <v-card class="my-2 px-2">
                <v-row align="center">
                    <v-col
                        class="text-left container-xs px-lg-4"
                        cols="12"
                        sm="8"
                    >
                        <div class="my-2">
                            <v-btn
                                tile outlined
                                color="#05af9a"
                                class="event-button"
                                data-toggle="modal"
                                data-target="#eventModal"
                            >
                                Готовы стать больше, чем участник?
                            </v-btn>
                        </div>
                    </v-col>
                    <v-spacer></v-spacer>
                    <v-col
                        class="text-right container-xs px-lg-4"
                        cols="12"
                        sm="4"
                    >
                        <div class="my-2">
                            <template v-if="EVENT_STATUS === 1">
                                <v-btn tile outlined disabled>ВЫ ПОДАЛИ ЗАЯВКУ</v-btn>
                            </template>
                            <template v-else-if="EVENT_STATUS === 2">
                                <v-btn tile outlined disabled>ВЫ УЧАСТВОВАЛИ</v-btn>
                            </template>
                            <template v-else>
                                <v-btn
                                    tile outlined
                                    color="#05af9a"
                                    class="event-button"
                                    @click="postRequest"
                                >
                                    ПОДАТЬ ЗАЯВКУ
                                </v-btn>
                            </template>
                        </div>
                    </v-col>
                </v-row>
            </v-card>
            <v-card
                class="my-2 px-2"
            >
                <v-row class="pa-4">
                    <v-col cols="12" sm="8" md="8" class="pa-12 divider-right">
                        <div class="px-2">
                            <div class="content-container">
                                <p class="event-text">{{ EVENT.short_description }}</p>
                            </div>
                            <div class="image-container">
                                <img :src="EVENT.image" alt="EVENT IMAGE">
                            </div>
                            <div class="content-container">
                                <p class="event-text">{{ EVENT.full_description }}</p>
                            </div>
                        </div>
                    </v-col>
                    <v-col cols="12" sm="4" md="4" class="pa-12">
                        <div class="px-2">
                            <div class="content-container">
                                <p class="info-text">
                                    <strong>Дата: </strong>{{ $moment(EVENT.event_date).format('LL') }}
                                </p>
                            </div>
                            <div class="content-container">
                                <p class="info-text">
                                    <strong>Время: </strong>
                                    {{ EVENT.start_at }} -
                                    {{ EVENT.end_at }}
                                </p>
                            </div>
                            <div class="content-container">
                                <p class="info-text">
                                    <strong>Адрес: </strong>
                                    {{ EVENT.address }}
                                </p>
                            </div>
                            <div class="content-container">
                                <p class="info-text">
                                    <strong>Контактное лицо:</strong>
                                </p>
                            </div>
                            <div class="content-container">
                                <p class="info-text">
                                    <router-link :to="{ name: 'user', params: { id: EVENT.user_id } }">
                                        {{ EVENT.second_name }} {{ EVENT.first_name }} {{ EVENT.third_name }}
                                    </router-link>
                                </p>
                            </div>
                            <div class="content-container">
                                <p class="info-text">
                                    <v-icon class="mr-1">mdi-email-check</v-icon>
                                    {{ EVENT.email }}
                                </p>
                            </div>
                            <div class="content-container">
                                <p class="info-text">
                                    <v-icon class="mr-1">mdi-phone-check</v-icon>
                                    {{ EVENT.phone_number }}
                                </p>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </v-card>
            <v-card
                class="my-2 px-2"
            >
                <v-col
                    cols="12"
                >
                    <div>
                        <p class="point-text">Начисление баллов за посещение мероприятия</p>
                    </div>
                    <v-divider></v-divider>
                    <v-simple-table>
                        <template v-slot:default>
                            <tbody>
                            <tr v-for="skill in EVENT_SKILLS" class="my-lg-3">
                                <td>
                                    <div
                                        class="ma-2 chip-container"
                                    >
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
        </v-col>
        <v-spacer></v-spacer>

        <div
                class="modal fade" id="eventModal"
                tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Хочешь стать больше, чем участник?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-5">Кем хотите стать?</legend>
                                    <div class="col-sm-7">
                                        <div class="form-check">
                                            <input
                                                v-model="form.role_id"
                                                class="form-check-input"
                                                type="radio" name="role_id"
                                                id="gridRadios1" value="3"
                                            >
                                            <label class="form-check-label" for="gridRadios1">
                                                Модератор мероприятия
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input
                                                v-model="form.role_id"
                                                class="form-check-input"
                                                type="radio" name="role_id"
                                                id="gridRadios2" value="4"
                                            >
                                            <label class="form-check-label" for="gridRadios2">
                                                Соорганизатор
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input
                                                v-model="form.role_id"
                                                class="form-check-input"
                                                type="radio" name="role_id"
                                                id="gridRadios3" value="5"
                                            >
                                            <label class="form-check-label" for="gridRadios3">
                                                Спикер
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input
                                                v-model="form.role_id"
                                                class="form-check-input"
                                                type="radio" name="role_id"
                                                id="gridRadios4" value="6"
                                            >
                                            <label class="form-check-label" for="gridRadios4">
                                                Волонтёр
                                            </label>
                                        </div>
                                        <has-error :form="form" field="role_id"></has-error>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputComment">Комментарий</label>
                                    <textarea
                                        v-model="form.comment" name="comment"
                                        type="text" class="form-control bio-field"
                                        id="inputComment" placeholder="Опишите заявку"
                                        :class="{ 'is-invalid': form.errors.has('comment') }"
                                        style="min-height: 10rem"
                                    >
                                    </textarea>
                                    <has-error :form="form" field="comment"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-outline-dark" @click="postRequestUp">Отправить</button>
                        </div>
                    </div>
                </div>
            </div>

    </v-row>
</template>

<script>
    import {mapGetters} from 'vuex';
    import axios from 'axios';

    export default {
        data() {
            return {
                form: new Form({
                    role_id: null,
                    comment: ''
                })
            }
        },
        mounted() {
            this.$store.dispatch('GET_EVENT', { id: this.$route.params.id });
            if (this.$store.getters.ACCESS_TOKEN) {
                this.$store.dispatch('GET_STATUS', {
                    user_id: this.$store.getters.ID,
                    event_id: this.$route.params.id
                });
            }
        },
        computed: {
            ...mapGetters([
                'EVENT',
                'EVENT_ORGANIZERS',
                'EVENT_SPEAKERS',
                'EVENT_STATUS',
                'EVENT_SKILLS'
            ])
        },
        methods: {
            postRequest: function () {
                if (this.$store.getters.ACCESS_TOKEN) {
                    let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                    let config = {
                        headers: {
                            Authorization: token
                        }
                    };
                    let data = {
                        role_id: 7
                    };
                    let path = '/api/auth/events/' + this.$route.params.id + '/participate';
                    axios.post(path, data, config)
                        .then(() => {
                            this.$store.dispatch('CHANGE_STATUS', 1);
                        })
                } else {
                    this.$router.push({ name: 'auth.login' });
                }
            },
            postRequestUp: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let path = '/api/auth/events/' + this.$route.params.id + '/participate';
                this.form.post(path, config)
                    .then(() => {
                        $('#eventModal').modal('hide');
                    })
            }
        }
    }
</script>

<style scoped>
    .event-title {
        font-size: 3rem;
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
    .event-button {

    }
    @media screen and (max-width: 700px) {
        .event-button {
            font-size: 0.6rem !important;
            padding: 0.1px !important;
            width: 100% !important;
        }
        .container-xs {
            margin: 0;
            padding-bottom: 0 !important;
            padding-top: 0 !important;
            text-align: center !important;
        }
    }
    @media screen and (min-width: 2000px) {
        .event-button {
            font-size: 2rem !important;
            height: 3rem !important;
        }
    }
    .image-container img {
        object-fit: cover;
        width: 90%;
        height: 18rem;
        border-radius: 1rem;
    }
    .event-text {
        font-size: 1.4rem;
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
