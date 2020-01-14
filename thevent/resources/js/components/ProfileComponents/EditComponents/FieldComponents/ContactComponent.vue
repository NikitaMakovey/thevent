<template>
    <div>
        <div>
            <p class="header-text">Контактная информация</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <form @submit.prevent="sendContacts">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail">Email</label>
                        <input
                            v-model="form.email" name="email"
                            type="email" class="form-control"
                            id="inputEmail" placeholder="Имя"
                            :class="{ 'is-invalid': form.errors.has('email') }"
                        >
                        <has-error :form="form" field="email"></has-error>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputPhoneNumber">Номер телефона</label>
                        <input
                            v-model="form.phone_number" name="phone_number"
                            type="text" class="form-control"
                            id="inputPhoneNumber" placeholder="Отчество"
                            :class="{ 'is-invalid': form.errors.has('phone_number') }"
                        >
                        <has-error :form="form" field="phone_number"></has-error>
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
                    email: this.$store.getters.EMAIL,
                    phone_number: this.$store.getters.PHONE_NUMBER
                })
            }
        },
        methods: {
            sendContacts: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.form.put('/api/auth/user/contacts', config)
                    .then(({data}) => {
                        if (data.message === -1) {
                            this.$store.dispatch('LOGOUT_USER')
                                .then(() => {
                                    this.$router.push({ name: 'auth.login' });
                                });
                        }
                        this.$store.dispatch('UPDATE_CONTACTS', data)
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
        font-size: 2rem;
    }
    .header-text {
        font-size: 2.4rem;
    }
</style>
