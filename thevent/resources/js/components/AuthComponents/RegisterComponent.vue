<template>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="6" md="6">
            <div class="card">
                <div class="card-header">Регистрация</div>

                <div class="card-body">
                    <form @submit.prevent="registerSubmit">
                        <input type="hidden" name="token" :value="csrf_token"/>
                        <div class="form-group">
                            <input
                                v-model="form.first_name" type="text" name="first_name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }"
                                placeholder="Ваше имя"
                            >
                            <has-error :form="form" field="first_name"></has-error>
                        </div>
                        <div class="form-group">
                            <input
                                v-model="form.second_name" type="text" name="second_name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('second_name') }"
                                placeholder="Ваша фамилия"
                            >
                            <has-error :form="form" field="second_name"></has-error>
                        </div>
                        <div class="form-group">
                            <input
                                v-model="form.email" type="email" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }"
                                placeholder="Ваша почта"
                            >
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group mb-1">
                            <input
                                v-model="form.phone_number" type="text" name="phone_number"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('phone_number') }"
                                placeholder="Ваш номер телефона (+7xxxxxxxxxx)"
                            >
                            <has-error :form="form" field="phone_number"></has-error>
                        </div>
                        <fieldset class="form-group">
                            <p class="subtitle-1 my-0">Пол</p>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input"
                                           name="sex" id="optionsRadios1" value="male"
                                           v-model="form.sex"
                                    > Мужской
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input"
                                           name="sex" id="optionsRadios2" value="female"
                                           v-model="form.sex"
                                    > Женский
                                </label>
                            </div>
                            <has-error :form="form" field="sex"></has-error>
                        </fieldset>
                        <div class="form-group">
                            <input
                                v-model="form.password" type="password" name="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }"
                                placeholder="Пароль"
                            >
                            <has-error :form="form" field="password"></has-error>
                        </div>
                        <div class="form-group">
                            <input
                                v-model="form.password_confirmation" type="password" name="password_confirmation"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                                placeholder="Пароль ещё раз"
                            >
                            <has-error :form="form" field="password_confirmation"></has-error>
                        </div>
                        <button :disabled="form.busy" type="submit" class="btn btn-auth">Зарегистрироваться</button>
                        <span class="subtitle-2 ml-2">
                            <router-link to="/auth/login">Уже есть аккаунт?</router-link>
                        </span>
                    </form>
                </div>
            </div>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    first_name: '',
                    second_name: '',
                    phone_number: '',
                    sex: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                })
            }
        },
        methods: {
            registerSubmit() {
                let url = '/api/auth/register';
                this.form.sex = this.form.sex === 'male' ? 1 : 2;
                this.form.post(url).then(({data}) => { this.$router.push({ name: 'auth.login' }) })
            }
        },
        computed: {
            csrf_token() {
                return document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
            }
        }
    }
</script>

<style scoped>
    .btn-auth
    {
        background-color: rgba(120, 101, 66, 0.22);
        color: #15252a;
    }
    .btn-auth:hover
    {
        background-color: rgba(120, 101, 66, 0.5);
        color: #fff;
    }
</style>
