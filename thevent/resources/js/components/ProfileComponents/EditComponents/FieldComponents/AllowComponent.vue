<template>
    <div>
        <div>
            <p class="header-text">Настройка подписки на рассылку</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <form @submit.prevent="sendAllowStatus">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="form-check">
                            <input
                                class="form-check-input" type="checkbox"
                                id="gridCheck" v-model="form.allow_status"
                            >
                            <label class="form-check-label" for="gridCheck">
                                Хочу получать ежедневную рассылку о свежих событиях
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark">Отправить</button>
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
                    allow_status: this.$store.getters.ALLOW_STATUS == 'true' ? true : false
                })
            }
        },
        methods: {
            sendAllowStatus: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.form.put('/api/auth/user/allow', config)
                    .then(({data}) => {
                        if (data.message === -1) {
                            this.$store.dispatch('LOGOUT_USER')
                                .then(() => {
                                    this.$router.push({ name: 'auth.login' });
                                });
                        }
                        this.$store.dispatch('UPDATE_ALLOW_STATUS', data)
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
        font-size: 1.1rem;
    }
    .header-text {
        font-size: 2rem;
    }
</style>
