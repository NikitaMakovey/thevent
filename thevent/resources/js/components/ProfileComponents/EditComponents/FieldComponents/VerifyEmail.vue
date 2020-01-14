<template>
    <div>
        <div>
            <p class="header-text">Подтверждения почты</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <template
                v-if="email_verified_at === '' && message === ''"
            >
                <form @submit.prevent="sendVerify">
                    <button type="submit" class="btn btn-dark">Подтвердить</button>
                </form>
            </template>
            <template
                v-else-if="email_verified_at"
            >
                <p class="welcome-text">Вы уже подтвердили свой Email!</p>
            </template>
            <template v-else>
                <form @submit.prevent="sendCheck">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputCode">Код для подтверждения</label>
                            <input
                                v-model="codeForm.email" name="email"
                                type="text" class="form-control"
                                id="inputCode" placeholder="Код для подтверждения"
                                :class="{ 'is-invalid': codeForm.errors.has('email') }"
                            >
                            <has-error :form="codeForm" field="email"></has-error>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark">Отправить</button>
                </form>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: this.$store.getters.VERIFY_MESSAGE,
                email_verified_at:
                    this.$store.getters.EMAIL_VERIFIED_AT != 'null' ?
                        this.$store.getters.EMAIL_VERIFIED_AT : '',
                form: new Form({
                    name: this.$store.getters.FIRST_NAME,
                    email: this.$store.getters.EMAIL
                }),
                codeForm: new Form({
                    email: ''
                })
            }
        },
        methods: {
            sendVerify: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.form.put('/api/auth/user/verify', config)
                    .then(({data}) => {
                        if (data.message === -1) {
                            this.$store.dispatch('LOGOUT_USER')
                                .then(() => {
                                    this.$router.push({ name: 'auth.login' });
                                });
                        }
                        this.$store.dispatch('SET_VERIFY_MESSAGE', data)
                            .then(response => {
                                this.message = response;
                            });
                    })
                // .catch(() => {
                //     this.$store.commit('UNSET_USER');
                //     this.$router.push({ name: 'auth.login' });
                // })
            },
            sendCheck: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.codeForm.put('/api/auth/user/email', config)
                    .then(({data}) => {
                        if (data.message === -1) {
                            this.$store.dispatch('LOGOUT_USER')
                                .then(() => {
                                    this.$router.push({ name: 'auth.login' });
                                });
                        } else if (data.message === 'Неверный код!') {
                            this.$store.dispatch('SET_VERIFY_MESSAGE', data)
                                .then(response => {
                                    this.message = response;
                                    this.codeForm.email = '';
                                });
                        } else {
                            this.$store.dispatch('UPDATE_EMAIL', data)
                                .then(() => {
                                    this.email_verified_at = data.email_verified_at;
                                    this.message = data.message;
                                    this.$store.dispatch('UNSET_VERIFY_MESSAGE');
                                });
                        }
                    })
                // .catch(() => {
                //     this.$store.commit('UNSET_USER');
                //     this.$router.push({ name: 'auth.login' });
                // })
            },
        }
    }
</script>

<style scoped>
    .bio-field {
        min-height: 10rem;
    }
    .message-text {
        color: lightcoral;
        font-size: 1.5rem;
    }
    .welcome-text {
        color: #1d2124;
        font-size: 1.2rem;
    }
    .header-text {
        font-size: 2.4rem;
    }
</style>
