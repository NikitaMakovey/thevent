<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="10" lg="8" class="pa-0 ma-0">
            <v-card
                class="py-0"
            >
                <v-col
                    cols="12 py-0"
                >
                    <p class="edit-title">Редактирование профиля</p>
                </v-col>
            </v-card>
            <v-card
                class="my-2"
            >
                <v-col
                    cols="12"
                >
                    <v-row>
                        <v-col cols="12" sm="4" md="4" class="pa-12 divider-right">
                            <v-list rounded>
                                <v-list-item-group v-model="item" color="primary">
                                    <v-list-item
                                        v-for="(item, i) in items"
                                        :key="i"
                                        :to="{ name: item.route }"
                                        exact
                                    >
                                        <v-list-item-icon class="mr-1">
                                            <v-icon v-text="item.icon"></v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-content>
                                            <v-list-item-title v-text="item.text"></v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-col>
                        <v-col cols="12" sm="8" md="8" class="pa-12">
                            <router-view></router-view>
                        </v-col>
                    </v-row>
                </v-col>
            </v-card>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    export default {
        data() {
            return {
                item: 1,
                items: [
                    { text: 'Основная информация', icon: 'mdi-account', route: 'edit.info' },
                    { text: 'Контакты', icon: 'mdi-phone-log', route: 'edit.contacts' },
                    { text: 'Фотография', icon: 'mdi-file-image', route: 'edit.photo' },
                    { text: 'О себе', icon: 'mdi-worker', route: 'edit.specialization' },
                    { text: 'Подтверждение почты', icon: 'mdi-email-edit', route: 'edit.verify' },
                    { text: 'Интересы', icon: 'mdi-cards-heart', route: 'edit.topics' },
                    { text: 'Подписка на рассылку', icon: 'mdi-send-check', route: 'edit.allow' },
                    { text: 'Пароль', icon: 'mdi-lock-question', route: 'edit.password' },
                ]
            }
        }
    }
</script>

<style scoped>
    * {
        text-decoration: none !important;
    }
    .edit-title {
        font-size: 3rem;
    }
    .divider-right {
        border-right: 1px solid gray;
    }
    @media screen and (max-width: 700px) {
        .edit-title {
            font-size: 1rem;
        }
        .divider-right {
            border-right: none;
            border-bottom: 1px solid gray;
        }
    }
    @media screen and (min-width: 2000px) {
        .edit-title {
            font-size: 4rem;
        }
    }
</style>
