<template>
    <div class="album">
        <v-container
            id="scroll-target"
            style="max-height: 94vh"
            class="overflow-y-auto"
        >
            <div class="row" style="height: 94vh">
                <v-col cols="12">
                    <v-row>
                        <p class="display-1">Участники мероприятия</p>
                    </v-row>
                    <template v-if="V_REQUEST.length > 0">
                        <v-row>
                            <v-btn outlined color="success" class="pa-1" @click="updateFullRequest(7)">
                                Все участвовали <v-icon>mdi-key-star</v-icon>
                            </v-btn>
                        </v-row>
                        <v-row>
                            <v-col cols="12" class="pa-2 ma-0">
                                <v-simple-table>
                                    <template v-slot:default>
                                        <thead>
                                        <tr>
                                            <th class="text-left">Участник</th>
                                            <th class="text-right">Подтверждение</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="item in V_REQUEST" :key="item.user_id">
                                            <td class="activeStyle">
                                                {{ item.second_name }} {{ item.first_name }} {{ item.third_name }}
                                            </td>
                                            <td class="activeStyleBtn text-right">
                                                <v-btn icon class="mr-8" @click="updateRequest(item.user_id, item.role_id)">
                                                    <v-icon>mdi-account-star</v-icon>
                                                </v-btn>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </template>
                                </v-simple-table>
                            </v-col>
                        </v-row>
                    </template>
                </v-col>
            </div>
        </v-container>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import axios from 'axios';

    export default {
        mounted() {
            let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
            let config = {
                headers: {
                    Authorization: token
                }
            };
            this.$store.dispatch('GET_V_REQUEST', { id: this.$route.params.id, config: config });
        },
        computed: {
            ...mapGetters(['V_REQUEST'])
        },
        methods: {
            updateFullRequest: function (role_id) {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let data = {
                    role_id: role_id
                };
                let path = '/api/auth/dashboard/volunteer/events/' + this.$route.params.id + '/update-all';
                axios.post(path, data, config)
                    .then(() => {
                        this.$store.dispatch('GET_V_REQUEST', { id: this.$route.params.id, config: config });
                    })
            },
            updateRequest: function (user_id, role_id) {
                let token = this.$store.getters.TOKEN_TYPE + ' ' + this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let data = {
                    user_id: user_id,
                    role_id: role_id
                };
                let path = '/api/auth/dashboard/volunteer/events/' + this.$route.params.id + '/update';
                axios.post(path, data, config)
                    .then(() => {
                        this.$store.dispatch('GET_V_REQUEST', { id: this.$route.params.id, config: config });
                    })
            }
        }
    }
</script>

<style scoped>
    .activeStyle {
        background-color: #ecf6f7;
        color: #21262a;
        font-size: 1rem
    }
    .activeStyleBtn {
        background-color: rgba(239, 226, 236, 0.5);
        color: #15252a;
        font-size: 1rem
    }
</style>
