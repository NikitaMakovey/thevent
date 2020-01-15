import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import event from './modules/event';
import user from './modules/user';
import verify from "./modules/verify";
import topic from "./modules/topic";
import request from "./modules/request";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        event,
        user,
        verify,
        topic,
        request
    }
});
