<template>
    <div>
        <div>
            <p class="header-text">Основная информация</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <form @submit.prevent="sendInfo">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputFirstName">Имя</label>
                        <input
                            v-model="form.first_name" name="first_name"
                            type="text" class="form-control"
                            id="inputFirstName" placeholder="Имя"
                            :class="{ 'is-invalid': form.errors.has('first_name') }"
                        >
                        <has-error :form="form" field="first_name"></has-error>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputSecondName">Фамилия</label>
                        <input
                            v-model="form.second_name" name="second_name"
                            type="text" class="form-control"
                            id="inputSecondName" placeholder="Фамилия"
                            :class="{ 'is-invalid': form.errors.has('second_name') }"
                        >
                        <has-error :form="form" field="second_name"></has-error>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputThirdName">Отчество</label>
                        <input
                            v-model="form.third_name" name="third_name"
                            type="text" class="form-control"
                            id="inputThirdName" placeholder="Отчество"
                            :class="{ 'is-invalid': form.errors.has('third_name') }"
                        >
                        <has-error :form="form" field="third_name"></has-error>
                    </div>
                </div>
                <div class="form-group">
                    <label for="datePicker">Дата рождения</label>
                    <br>
                    <v-date-picker
                        v-model="picker" locale="ru"
                        color="#000000" id="datePicker"
                        name="birth_date"
                    ></v-date-picker>
                    <has-error :form="form" field="birth_date"></has-error>
                </div>
                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-2">Пол</legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input
                                    v-model="form.sex"
                                    class="form-check-input"
                                    type="radio" name="sex"
                                    id="gridRadios1" value="1"
                                >
                                <label class="form-check-label" for="gridRadios1">
                                    Мужской
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    v-model="form.sex"
                                    class="form-check-input"
                                    type="radio" name="sex"
                                    id="gridRadios2" value="2"
                                >
                                <label class="form-check-label" for="gridRadios2">
                                    Женский
                                </label>
                            </div>
                            <has-error :form="form" field="sex"></has-error>
                        </div>
                    </div>
                </fieldset>
                <button type="submit" class="btn btn-dark">Изменить</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: '',
                picker:
                    this.$store.getters.BIRTH_DATE != 'null' ?
                        new Date(this.$store.getters.BIRTH_DATE.substr(0, 10)).toISOString().substr(0, 10) :
                        new Date().toISOString().substr(0, 10),
                form: new Form({
                    first_name: this.$store.getters.FIRST_NAME,
                    second_name: this.$store.getters.SECOND_NAME,
                    third_name: this.$store.getters.THIRD_NAME != 'null' ? this.$store.getters.THIRD_NAME : '',
                    sex: this.$store.getters.SEX,
                    birth_date: null
                })
            }
        },
        mounted() {

        },
        methods: {
            sendInfo: function () {
                this.form.birth_date = this.picker;
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.form.put('/api/auth/user/info', config)
                    .then(({data}) => {
                        if (data.message === -1) {
                            this.$store.dispatch('LOGOUT_USER')
                                .then(() => {
                                    this.$router.push({ name: 'auth.login' });
                                });
                        }
                        this.$store.dispatch('UPDATE_INFO', data)
                            .then(() => {
                                this.message = data.message;
                            });
                    })
                    // .catch(() => {
                    //     this.$store.commit('UNSET_USER');
                    //     this.$router.push({ name: 'auth.login' });
                    // })
            }
        }
    }
</script>

<style scoped>
    .message-text {
        color: lightcoral;
        font-size: 1.5rem;
    }
    .header-text {
        font-size: 2.4rem;
    }
</style>
