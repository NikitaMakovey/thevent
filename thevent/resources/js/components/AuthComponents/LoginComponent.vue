<template>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="6" md="6">
            <div class="card">
                <div class="card-header">Вход</div>

                <div class="card-body">
                    <form @submit.prevent="loginSubmit">
                        <input type="hidden" name="token" :value="csrf_token"/>
                        <div class="form-group">
                            <input
                                v-model="form.email" type="email" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }"
                                placeholder="Ваша почта"
                            >
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <input
                                v-model="form.password" type="password" name="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }"
                                placeholder="Пароль"
                            >
                            <has-error :form="form" field="password"></has-error>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="remember_me" id="remember" value="1"
                                           v-model="form.remember_me"
                                    >
                                    <label class="form-check-label" for="remember">
                                        Запомнить меня
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button :disabled="form.busy" type="submit" class="btn btn-auth">Войти</button>
                        <span class="subtitle-2 ml-2">
                            <router-link to="/auth/register">Ещё нет аккаунта?</router-link>
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
                    email: '',
                    password: '',
                    remember_me: false
                })
            }
        },
        methods: {
            loginSubmit() {
                let url = '/api/auth/login';
                this.form.post(url).then(({data}) => {
                    this.$store.dispatch('LOGIN_USER', data)
                        .then(() => { this.$router.push({ name: 'events' }) })
                })
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
