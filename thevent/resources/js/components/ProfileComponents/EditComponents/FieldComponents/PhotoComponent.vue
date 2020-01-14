<template>
    <div>
        <div>
            <p class="header-text">Фотография профиля</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <form @submit.prevent="sendPhoto">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <v-avatar
                            color="grey"
                            size="218"
                            tile
                        >
                            <v-img :src="form.image" alt="Фото профиля"></v-img>
                        </v-avatar>
                        <label
                            for="formImage" class="link-field"
                        >
                            URL фотографии профиля
                        </label>
                        <input
                            v-model="form.image" name="image"
                            type="text" class="form-control"
                            id="formImage" placeholder="URL фотографии профиля"
                            :class="{ 'is-invalid': form.errors.has('image') }"
                        >
                        <has-error :form="form" field="image"></has-error>
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
                    image: this.$store.getters.IMAGE
                })
            }
        },
        methods: {
            sendPhoto: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.form.put('/api/auth/user/photo', config)
                    .then(({data}) => {
                        if (data.message === -1) {
                            this.$store.dispatch('LOGOUT_USER')
                                .then(() => {
                                    this.$router.push({ name: 'auth.login' });
                                });
                        }
                        this.$store.dispatch('UPDATE_PHOTO', data)
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
    .link-field {
        margin-top: 1rem;
    }
    .message-text {
        color: lightcoral;
        font-size: 2rem;
    }
    .header-text {
        font-size: 2.4rem;
    }
</style>
