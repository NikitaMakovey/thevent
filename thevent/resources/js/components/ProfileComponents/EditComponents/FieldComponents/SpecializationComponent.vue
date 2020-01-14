<template>
    <div>
        <div>
            <p class="header-text">О себе</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <form @submit.prevent="sendBio">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputSpec">Специализация</label>
                        <input
                            v-model="form.specialization" name="specialization"
                            type="text" class="form-control"
                            id="inputSpec" placeholder="Специализация"
                            :class="{ 'is-invalid': form.errors.has('specialization') }"
                        >
                        <has-error :form="form" field="specialization"></has-error>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputBio">Био</label>
                        <textarea
                            v-model="form.info" name="info"
                            type="text" class="form-control bio-field"
                            id="inputBio" placeholder="Расскажите о себе"
                            :class="{ 'is-invalid': form.errors.has('info') }"
                        >
                        </textarea>
                        <has-error :form="form" field="info"></has-error>
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
                    specialization:
                        this.$store.getters.SPECIALIZATION != 'null' ?
                        this.$store.getters.SPECIALIZATION : '',
                    info: this.$store.getters.INFO != 'null' ?
                        this.$store.getters.INFO : '',
                })
            }
        },
        methods: {
            sendBio: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.form.put('/api/auth/user/bio', config)
                    .then(({data}) => {
                        if (data.message === -1) {
                            this.$store.dispatch('LOGOUT_USER')
                                .then(() => {
                                    this.$router.push({ name: 'auth.login' });
                                });
                        }
                        this.$store.dispatch('UPDATE_BIO', data)
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
    .bio-field {
        min-height: 10rem;
    }
    .message-text {
        color: lightcoral;
        font-size: 2rem;
    }
    .header-text {
        font-size: 2.4rem;
    }
</style>
