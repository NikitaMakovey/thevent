<template>
    <div class="album">
        <v-container
            id="scroll-target"
            style="max-height: 85vh"
            class="overflow-y-auto"
        >
            <div class="row" style="height: 85vh">
                <v-col cols="12">
                    <v-row>
                        <p class="message-text">{{ message }}</p>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <form @submit.prevent="postMainModerator">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail">Email потенциального главного модератора</label>
                                        <input
                                            v-model="form.email" name="email"
                                            type="email" class="form-control"
                                            id="inputEmail" placeholder="Email"
                                            :class="{ 'is-invalid': form.errors.has('email') }"
                                        >
                                        <has-error :form="form" field="email"></has-error>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-dark">Назначить</button>
                            </form>
                        </v-col>
                    </v-row>
                </v-col>
            </div>
        </v-container>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: '',
                form: new Form({
                    email: '',
                })
            }
        },
        methods: {
            postMainModerator: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let path = '/api/auth/dashboard/admin/main-moderators';
                this.form.post(path, config)
                    .then(({data}) => {
                        this.message = data.message;
                        this.form.email = '';
                    });
            }
        }
    }
</script>

<style scoped>
    .message-text {
        color: lightcoral;
        font-size: 1rem;
    }
</style>
