<template>
    <v-stepper v-model="step">
        <v-stepper-header>
            <v-stepper-step :complete="step > 1" step="1" color="#1d2124">
                Анкета мероприятия
            </v-stepper-step>
            <v-divider></v-divider>

            <v-stepper-step :complete="step > 2" step="2" color="#1d2124">
                Навыки за посещение
            </v-stepper-step>
            <v-divider></v-divider>

            <v-stepper-step :complete="step > 3" step="3" color="#1d2124">
                Комментарий
            </v-stepper-step>
            <v-divider></v-divider>

            <v-stepper-step step="4" color="#1d2124"></v-stepper-step>
        </v-stepper-header>

        <v-stepper-items>
            <v-stepper-content step="1">
                <v-card class="mb-12">
                    <v-col cols="12">
                        <form @submit.prevent="sendEvent">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputTitle">Загаловок</label>
                                    <input
                                        v-model="formEvent.title" name="title"
                                        type="text" class="form-control"
                                        id="inputTitle" placeholder="Загаловок"
                                        :class="{ 'is-invalid': formEvent.errors.has('title') }"
                                    >
                                    <has-error :form="formEvent" field="title"></has-error>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputSD">Краткое описание</label>
                                    <textarea
                                        v-model="formEvent.short_description" name="short_description"
                                        type="text" class="form-control"
                                        id="inputSD" placeholder="Краткое описание"
                                        :class="{ 'is-invalid': formEvent.errors.has('short_description') }"
                                    >
                                    </textarea>
                                    <has-error :form="formEvent" field="short_description"></has-error>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <v-avatar
                                        color="grey"
                                        size="218"
                                        tile
                                    >
                                        <v-img :src="formEvent.image" alt="Изображение мероприятия"></v-img>
                                    </v-avatar>
                                    <label
                                        for="formImage" class="link-field"
                                    >
                                        URL изображения мероприятия
                                    </label>
                                    <input
                                        v-model="formEvent.image" name="image"
                                        type="text" class="form-control"
                                        id="formImage" placeholder="URL изображения мероприятия"
                                        :class="{ 'is-invalid': formEvent.errors.has('image') }"
                                    >
                                    <has-error :form="formEvent" field="image"></has-error>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputFD">Полное описание</label>
                                    <textarea
                                        v-model="formEvent.full_description" name="full_description"
                                        type="text" class="form-control"
                                        id="inputFD" placeholder="Полное описание"
                                        :class="{ 'is-invalid': formEvent.errors.has('full_description') }"
                                    >
                                    </textarea>
                                    <has-error :form="formEvent" field="full_description"></has-error>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputAddress">Адрес</label>
                                    <textarea
                                        v-model="formEvent.address" name="address"
                                        type="text" class="form-control"
                                        id="inputAddress" placeholder="Адрес"
                                        :class="{ 'is-invalid': formEvent.errors.has('address') }"
                                    >
                                    </textarea>
                                    <has-error :form="formEvent" field="address"></has-error>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <v-select
                                        v-model="selected"
                                        :items="topics"
                                        item-text="name"
                                        item-value="id"
                                        label="Выберите тему мероприятия"
                                        return-object
                                        single-line
                                    >
                                    </v-select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="datePicker">Дата мероприятия</label>
                                <br>
                                <v-date-picker
                                    v-model="formEvent.event_date" locale="ru"
                                    color="#000000" id="datePicker"
                                    name="event_date"
                                ></v-date-picker>
                                <has-error :form="formEvent" field="event_date"></has-error>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputStart">Время начала</label>
                                    <br>
                                    <v-time-picker
                                        v-model="formEvent.start_at" format="24hr"
                                        name="start_at" id="inputStart" color="#000000"
                                        :max="formEvent.end_at"
                                    >
                                    </v-time-picker>
                                    <has-error :form="formEvent" field="start_at"></has-error>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEnd">Время окончания</label>
                                    <br>
                                    <v-time-picker
                                        v-model="formEvent.end_at" format="24hr"
                                        name="end_at" id="inputEnd" color="#000000"
                                        :min="formEvent.start_at"
                                    >
                                    </v-time-picker>
                                    <has-error :form="formEvent" field="end_at"></has-error>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark">Отправить</button>
                        </form>
                    </v-col>
                </v-card>

                <v-btn text class="mt-1" @click="goToMain">Отмена</v-btn>
            </v-stepper-content>

            <v-stepper-content step="2">
                <v-card class="mb-12">
                    <v-col cols="12">
                        <form @submit.prevent="sendEventSkills">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <v-select
                                        v-model="selected_1"
                                        :items="skills"
                                        item-text="name"
                                        item-value="id"
                                        label="Выберите навык для мероприятия"
                                        return-object
                                        single-line
                                        class="pt-7"
                                    >
                                    </v-select>
                                </div>
                                <div class="form-group col-md-6">
                                    <v-subheader>Выберите количественную оценку</v-subheader>
                                    <v-card-text class="pa-0">
                                        <v-slider
                                            v-model="factor_1"
                                            step="10"
                                            ticks="always"
                                            tick-size="1"
                                        ></v-slider>
                                    </v-card-text>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <v-select
                                        v-model="selected_2"
                                        :items="skills"
                                        item-text="name"
                                        item-value="id"
                                        label="Выберите навык для мероприятия"
                                        return-object
                                        single-line
                                        class="pt-7"
                                    >
                                    </v-select>
                                </div>
                                <div class="form-group col-md-6">
                                    <v-subheader>Выберите количественную оценку</v-subheader>
                                    <v-card-text class="pa-0">
                                        <v-slider
                                            v-model="factor_2"
                                            step="10"
                                            ticks="always"
                                            tick-size="1"
                                        ></v-slider>
                                    </v-card-text>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <v-select
                                        v-model="selected_3"
                                        :items="skills"
                                        item-text="name"
                                        item-value="id"
                                        label="Выберите навык для мероприятия"
                                        return-object
                                        single-line
                                        class="pt-7"
                                    >
                                    </v-select>
                                </div>
                                <div class="form-group col-md-6">
                                    <v-subheader>Выберите количественную оценку</v-subheader>
                                    <v-card-text class="pa-0">
                                        <v-slider
                                            v-model="factor_3"
                                            step="10"
                                            ticks="always"
                                            tick-size="1"
                                        ></v-slider>
                                    </v-card-text>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark">Отправить</button>
                        </form>
                    </v-col>
                </v-card>

                <v-btn text class="mt-1" @click="goToMain">Отмена</v-btn>
            </v-stepper-content>

            <v-stepper-content step="3">
                <v-card class="mb-12">
                    <form @submit.prevent="sendComment">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputComment">Комментарий к заявке</label>
                                <textarea
                                    v-model="formComment.comment" name="comment"
                                    type="text" class="form-control"
                                    id="inputComment" placeholder="Комментарий к заявке"
                                    :class="{ 'is-invalid': formComment.errors.has('comment') }"
                                >
                                    </textarea>
                                <has-error :form="formComment" field="comment"></has-error>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark">Отправить</button>
                    </form>
                </v-card>

                <v-btn text class="mt-1" @click="goToMain">Отмена</v-btn>
            </v-stepper-content>

            <v-stepper-content step="4">
                <v-card class="mb-12">
                    <v-col cols="12">
                        <p class="display-1">{{ message }}</p>
                    </v-col>
                </v-card>
                <v-row align="center" justify="center">
                    <v-btn dark @click="goToMain">
                        На главную страницу
                    </v-btn>
                </v-row>
            </v-stepper-content>
        </v-stepper-items>
    </v-stepper>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data() {
            return {
                selected: { id: 0, name: 'Выберите тему мероприятия' },
                topics: [],
                selected_1: { id: 0, name: 'Выберите один из навыков мероприятия' },
                factor_1: 0,
                selected_2: { id: 0, name: 'Выберите один из навыков мероприятия' },
                factor_2: 0,
                selected_3: { id: 0, name: 'Выберите один из навыков мероприятия' },
                factor_3: 0,
                skills: [],
                message: '',
                step: this.$store.getters.REQUEST_STEP,
                formEvent: new Form({
                    'title' : '',
                    'short_description' : '',
                    'full_description' : '',
                    'image' : '',
                    'topic_id' : '',
                    'event_date' : new Date().toISOString().substr(0, 10),
                    'start_at' : null,
                    'end_at' : null,
                    'address' : ''
                }),
                formEventSkills: new Form({
                    'skills' : null,
                    'event_id' : null
                }),
                formComment: new Form({
                    'event_id' : null,
                    'comment' : ''
                })
            }
        },
        mounted() {
            this.$store.dispatch('GET_ALL_TOPICS')
                .then((data) => {
                    this.topics = data;
                    console.log(data);
                });
            this.$store.dispatch('GET_ALL_SKILLS')
                .then((data) => {
                    this.skills = data;
                    console.log(data);
                });
        },
        computed: {
            ...mapGetters(['TOPICS', 'REQUEST_SKILLS'])
        },
        methods: {
            sendEvent: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                if (this.selected.id === 0) {
                    console.log(this.formEvent.start_at);
                } else {
                    this.formEvent.topic_id = this.selected.id;
                    this.formEvent.post('/api/auth/request/event', config)
                        .then(({data}) => {
                            this.step = 2;
                            this.$store.dispatch('SET_REQUEST_STEP', 2);
                            this.$store.dispatch('SET_REQUEST_ID', data.id);
                        })
                }
            },
            sendEventSkills: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let skills = [
                    { skill_id: this.selected_1.id, skill_factor : this.factor_1 / 10 },
                    { skill_id: this.selected_2.id, skill_factor : this.factor_2 / 10 },
                    { skill_id: this.selected_3.id, skill_factor : this.factor_3 / 10 }
                ];
                console.log(skills);
                this.formEventSkills.event_id = this.$store.getters.REQUEST_ID;
                this.formEventSkills.skills = skills;
                if (
                    (skills[0].skill_id !== 0 && skills[0].skill_factor !== 0) ||
                    (skills[1].skill_id !== 0 && skills[1].skill_factor !== 0) ||
                    (skills[2].skill_id !== 0 && skills[2].skill_factor !== 0)
                ) {
                    this.formEventSkills.post('/api/auth/request/skills', config)
                        .then(() => {
                            this.step = 3;
                            this.$store.dispatch('SET_REQUEST_STEP', 3);
                        })
                }
            },
            sendComment: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.formComment.event_id = this.$store.getters.REQUEST_ID;
                this.formComment.post('/api/auth/request/comment', config)
                    .then(({data}) => {
                        this.step = 4;
                        this.$store.dispatch('SET_REQUEST_STEP', 4);
                        this.message = data.message;
                        this.$store.dispatch('UNSET_REQUEST_ID');
                        setTimeout(function () {
                            this.$router.push({ name: 'events' });
                        }, 3000);
                    })
            },
            goToMain: function () {
                this.$store.dispatch('UNSET_REQUEST_STEP');
                this.$router.push({ name: 'events' });
            }
        }
    }
</script>

<style scoped>
    .stepper-color {
        color: #1d2124;
    }
</style>
