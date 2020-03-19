import axios from 'axios';

export default {
    state: {
        DASHBOARD_ACCESS: localStorage.getItem('DASHBOARD_ACCESS') || null,
        ACCESS_TOKEN: localStorage.getItem('ACCESS_TOKEN') || null,
        TOKEN_TYPE: localStorage.getItem('TOKEN_TYPE') || null,
        ID: localStorage.getItem('ID') || null,
        FIRST_NAME: localStorage.getItem('FIRST_NAME') || null,
        SECOND_NAME: localStorage.getItem('SECOND_NAME') || null,
        THIRD_NAME: localStorage.getItem('THIRD_NAME') || null,
        EMAIL: localStorage.getItem('EMAIL') || null,
        EMAIL_VERIFIED_AT: localStorage.getItem('EMAIL_VERIFIED_AT') || null,
        PHONE_NUMBER: localStorage.getItem('PHONE_NUMBER') || null,
        IMAGE: localStorage.getItem('IMAGE') || null,
        SEX: localStorage.getItem('SEX') || null,
        BIRTH_DATE: localStorage.getItem('BIRTH_DATE') || null,
        SPECIALIZATION: localStorage.getItem('SPECIALIZATION') || null,
        INFO: localStorage.getItem('INFO') || null,
        ALLOW_STATUS: localStorage.getItem('ALLOW_STATUS') || null,
    },
    getters: {
        ACCESS_TOKEN: state => { return state.ACCESS_TOKEN },
        DASHBOARD_ACCESS: state => { return state.DASHBOARD_ACCESS },
        TOKEN_TYPE: state => { return state.TOKEN_TYPE },
        ID: state => { return state.ID },
        FIRST_NAME: state => { return state.FIRST_NAME },
        SECOND_NAME: state => { return state.SECOND_NAME },
        THIRD_NAME: state => { return state.THIRD_NAME },
        EMAIL: state => { return state.EMAIL },
        EMAIL_VERIFIED_AT: state => { return state.EMAIL_VERIFIED_AT },
        PHONE_NUMBER: state => { return state.PHONE_NUMBER },
        IMAGE: state => { return state.IMAGE },
        SEX: state => { return state.SEX },
        BIRTH_DATE: state => { return state.BIRTH_DATE },
        SPECIALIZATION: state => { return state.SPECIALIZATION },
        INFO: state => { return state.INFO },
        ALLOW_STATUS: state => { return state.ALLOW_STATUS },
    },
    mutations: {
        SET_USER: (state, data) => {
            localStorage.setItem('DASHBOARD_ACCESS', data.dashboard_access);
            localStorage.setItem('ACCESS_TOKEN', data.access_token);
            localStorage.setItem('TOKEN_TYPE', data.token_type);
            localStorage.setItem('ID', data.user.id);
            localStorage.setItem('FIRST_NAME', data.user.first_name);
            localStorage.setItem('SECOND_NAME', data.user.second_name);
            localStorage.setItem('THIRD_NAME', data.user.third_name);
            localStorage.setItem('EMAIL', data.user.email);
            localStorage.setItem('EMAIL_VERIFIED_AT', data.user.email_verified_at);
            localStorage.setItem('PHONE_NUMBER', data.user.phone_number);
            localStorage.setItem('IMAGE', data.user.image);
            localStorage.setItem('SEX', data.user.sex);
            localStorage.setItem('BIRTH_DATE', data.user.birth_date);
            localStorage.setItem('SPECIALIZATION', data.user.specialization);
            localStorage.setItem('INFO', data.user.info);
            state.DASHBOARD_ACCESS = data.dashboard_access;
            state.ACCESS_TOKEN = data.access_token;
            state.TOKEN_TYPE = data.token_type;
            state.ID = data.user.id;
            state.FIRST_NAME = data.user.first_name;
            state.SECOND_NAME = data.user.second_name;
            state.THIRD_NAME = data.user.third_name;
            state.EMAIL = data.user.email;
            state.EMAIL_VERIFIED_AT = data.user.email_verified_at;
            state.PHONE_NUMBER = data.user.phone_number;
            state.IMAGE = data.user.image;
            state.SEX = data.user.sex;
            state.BIRTH_DATE = data.user.birth_date;
            state.SPECIALIZATION = data.user.specialization;
            state.INFO = data.user.info;
        },
        UNSET_USER: (state) => {
            localStorage.removeItem('DASHBOARD_ACCESS');
            localStorage.removeItem('ACCESS_TOKEN');
            localStorage.removeItem('TOKEN_TYPE');
            localStorage.removeItem('ID');
            localStorage.removeItem('FIRST_NAME');
            localStorage.removeItem('SECOND_NAME');
            localStorage.removeItem('THIRD_NAME');
            localStorage.removeItem('EMAIL');
            localStorage.removeItem('EMAIL_VERIFIED_AT');
            localStorage.removeItem('PHONE_NUMBER');
            localStorage.removeItem('IMAGE');
            localStorage.removeItem('SEX');
            localStorage.removeItem('BIRTH_DATE');
            localStorage.removeItem('SPECIALIZATION');
            localStorage.removeItem('INFO');
            state.DASHBOARD_ACCESS = null;
            state.ACCESS_TOKEN = null;
            state.TOKEN_TYPE = null;
            state.ID = null;
            state.FIRST_NAME = null;
            state.SECOND_NAME = null;
            state.THIRD_NAME = null;
            state.EMAIL = null;
            state.EMAIL_VERIFIED_AT = null;
            state.PHONE_NUMBER = null;
            state.IMAGE = null;
            state.SEX = null;
            state.BIRTH_DATE = null;
            state.SPECIALIZATION = null;
            state.INFO = null;
        },
        UPDATE_INFO: (state, data) => {
            localStorage.setItem('FIRST_NAME', data.first_name);
            localStorage.setItem('SECOND_NAME', data.second_name);
            localStorage.setItem('THIRD_NAME', data.third_name);
            localStorage.setItem('SEX', data.sex);
            localStorage.setItem('BIRTH_DATE', data.birth_date);
            state.FIRST_NAME = data.first_name;
            state.SECOND_NAME = data.second_name;
            state.THIRD_NAME = data.third_name;
            state.SEX = data.sex;
            state.BIRTH_DATE = data.birth_date;
        },
        UPDATE_CONTACTS: (state, data) => {
            localStorage.setItem('EMAIL', data.email);
            localStorage.setItem('EMAIL_VERIFIED_AT', data.email_verified_at);
            localStorage.setItem('PHONE_NUMBER', data.phone_number);
            state.EMAIL = data.email;
            state.EMAIL_VERIFIED_AT = data.email_verified_at;
            state.PHONE_NUMBER = data.phone_number;
        },
        UPDATE_PHOTO: (state, data) => {
            localStorage.setItem('IMAGE', data.image);
            state.IMAGE = data.image;
        },
        UPDATE_BIO: (state, data) => {
            localStorage.setItem('SPECIALIZATION', data.specialization);
            localStorage.setItem('INFO', data.info);
            state.SPECIALIZATION = data.specialization;
            state.INFO = data.info
        },
        UPDATE_EMAIL: (state, data) => {
            localStorage.setItem('EMAIL_VERIFIED_AT', data.email_verified_at);
            state.EMAIL_VERIFIED_AT = data.email_verified_at;
        },
        UPDATE_ALLOW_STATUS: (state, data) => {
            localStorage.setItem('ALLOW_STATUS', data.allow_status);
            state.ALLOW_STATUS = data.allow_status;
        }
    },
    actions: {
        LOGIN_USER(context, payload) {
            return new Promise((resolve, reject) => {
                if (payload.access_token) {
                    const dashboard_access = payload.dashboard_access;
                    const access_token = payload.access_token;
                    const token_type = payload.token_type;
                    const user = payload.user;
                    const data = {
                        dashboard_access: dashboard_access,
                        access_token: access_token,
                        token_type: token_type,
                        user: user
                    };
                    context.commit('SET_USER', data);
                    axios.defaults.headers.common['Authorization'] = data.token_type + ' ' + data.access_token;
                    resolve(data);
                } else {
                    reject(null);
                }
            });
        },
        LOGOUT_USER(context) {
            axios.defaults.headers.common['Authorization']
                = context.getters.TOKEN_TYPE + ' ' + context.getters.ACCESS_TOKEN;
            if (context.getters.ACCESS_TOKEN) {
                return new Promise((resolve, reject) => {
                    axios.get('/api/auth/logout')
                        .then(response => {
                            context.commit('UNSET_USER');
                            delete axios.defaults.headers.common['Authorization'];
                            resolve(response);
                        })
                        .catch(error => {
                            reject(error)
                        });
                });
            }
        },
        UPDATE_INFO(context, payload) {
            return new Promise(resolve => {
                context.commit('UPDATE_INFO', payload);
                resolve(1);
            });
        },
        UPDATE_CONTACTS(context, payload) {
            return new Promise(resolve => {
                context.commit('UPDATE_CONTACTS', payload);
                resolve(1);
            });
        },
        UPDATE_PHOTO(context, payload) {
            return new Promise(resolve => {
                context.commit('UPDATE_PHOTO', payload);
                resolve(1);
            });
        },
        UPDATE_BIO(context, payload) {
            return new Promise(resolve => {
                context.commit('UPDATE_BIO', payload);
                resolve(1);
            });
        },
        UPDATE_EMAIL(context, payload) {
            return new Promise(resolve => {
                context.commit('UPDATE_EMAIL', payload);
                resolve(1);
            });
        },
        UPDATE_ALLOW_STATUS(context, payload) {
            return new Promise(resolve => {
                context.commit('UPDATE_ALLOW_STATUS', payload);
                resolve(1);
            });
        }
    }
}
