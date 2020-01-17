require('./bootstrap');

import Vue from "vue";
import VueRouter from "vue-router";
import vuetify from "./config/vuetify";
import { store } from "./store/store";
import router from "./router/router";
import Main from './Main';
import { Form, HasError, AlertError } from 'vform';


window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.use(VueRouter);

const moment = require('moment');
require('moment/locale/ru');

Vue.use(require('vue-moment'), {
    moment
});

export const app = new Vue({
    el: '#app',
    render: h => h(Main),
    router: router,
    store: store,
    vuetify
});
