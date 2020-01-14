<template>
    <div>
        <div>
            <p class="header-text">Интересующие темы</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <form @submit.prevent="sendTopics">
                <div class="form-row topics-field">
                    <div
                        class="form-group col-md-6 checkbox-topic"
                        v-for="(topic, i) in form.topics" :key="topic.id"
                    >
                        <div class="form-check">
                            <input
                                class="form-check-input" type="checkbox"
                                :id="'gridCheck' + i" v-model="form.topics[i].topic_id"
                            >
                            <label class="form-check-label" :for="'gridCheck' + i">
                                {{ topic.name }}
                            </label>
                        </div>
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
                    topics: null
                })
            }
        },
        mounted() {
            let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
            let config = {
                headers: {
                    Authorization: token
                }
            };
            this.$store.dispatch('GET_TOPICS', config)
                .then((data) => {
                    console.log(data);
                    this.form.topics = data;
                })
        },
        methods: {
            sendTopics: function () {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.form.put('/api/auth/user/topics', config)
                    .then(({data}) => {
                        if (data.message === -1) {
                            this.$store.dispatch('LOGOUT_USER')
                                .then(() => {
                                    this.$router.push({ name: 'auth.login' });
                                });
                        }
                        console.log(data);
                        this.message = data.message;
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
    .topics-field {
        margin-bottom: 1rem;
    }
    .checkbox-topic {
        margin-bottom: 0 !important;
    }
    .message-text {
        color: lightcoral;
        font-size: 1.5rem;
    }
    .header-text {
        font-size: 2.4rem;
    }
</style>
