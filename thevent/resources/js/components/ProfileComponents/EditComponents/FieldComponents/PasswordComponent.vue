<template>
    <div>
        <div>
            <p class="header-text">Изменение пароля</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <form @submit.prevent="sendResetPassword">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputOP">Старый пароль</label>
                        <input
                            v-model="form.old_password" name="old_password"
                            type="password" class="form-control"
                            id="inputOP" placeholder="Старый пароль"
                            :class="{ 'is-invalid': form.errors.has('old_password') }"
                        >
                        <has-error :form="form" field="old_password"></has-error>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputNP">Новый пароль</label>
                        <input
                            v-model="form.new_password" name="new_password"
                            type="password" class="form-control"
                            id="inputNP" placeholder="Новый пароль"
                            :class="{ 'is-invalid': form.errors.has('new_password') }"
                        >
                        <has-error :form="form" field="new_password"></has-error>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCP">Новый пароль ещё раз</label>
                        <input
                            v-model="form.new_password_confirmation" name="new_password_confirmation"
                            type="password" class="form-control"
                            id="inputCP" placeholder="Новый пароль ещё раз"
                            :class="{ 'is-invalid': form.errors.has('new_password_confirmation') }"
                        >
                        <has-error :form="form" field="new_password_confirmation"></has-error>
                    </div>
                </div>
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
                form: new Form({
                    old_password : '',
                    new_password : '',
                    new_password_confirmation : ''
                })
            }
        },
        mounted() {

        },
        methods: {
            sendResetPassword: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.form.put('/api/auth/user/password', config)
                    .then(({data}) => {
                        if (data.message === -1) {
                            this.$store.dispatch('LOGOUT_USER')
                                .then(() => {
                                    this.$router.push({ name: 'auth.login' });
                                });
                        }
                        this.message = data.message;
                        this.form.old_password = '';
                        this.form.new_password = '';
                        this.form.new_password_confirmation = '';
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
