import axios from 'axios';

export default {
    state: {
        ACCESS_TOKEN: localStorage.getItem('ACCESS_TOKEN') || null,
        TOKEN_TYPE: localStorage.getItem('TOKEN_TYPE') || null,
        ID: localStorage.getItem('ID') || null,
        FIRST_NAME: localStorage.getItem('FIRST_NAME') || null,
        SECOND_NAME: localStorage.getItem('SECOND_NAME') || null,
        EMAIL: localStorage.getItem('EMAIL') || null,
        EMAIL_VERIFIED_AT: localStorage.getItem('EMAIL_VERIFIED_AT') || null,
        PHONE_NUMBER: localStorage.getItem('PHONE_NUMBER') || null,
        IMAGE: localStorage.getItem('IMAGE') || null,
    },
    getters: {
        ACCESS_TOKEN: state => { return state.ACCESS_TOKEN },
        TOKEN_TYPE: state => { return state.TOKEN_TYPE },
        ID: state => { return state.ID },
        FIRST_NAME: state => { return state.FIRST_NAME },
        SECOND_NAME: state => { return state.SECOND_NAME },
        EMAIL: state => { return state.EMAIL },
        EMAIL_VERIFIED_AT: state => { return state.EMAIL_VERIFIED_AT },
        PHONE_NUMBER: state => { return state.PHONE_NUMBER },
        IMAGE: state => { return state.IMAGE },
    },
    mutations: {
        SET_USER: (state, data) => {
            localStorage.setItem('ACCESS_TOKEN', data.access_token);
            localStorage.setItem('TOKEN_TYPE', data.token_type);
            localStorage.setItem('ID', data.user.id);
            localStorage.setItem('FIRST_NAME', data.user.first_name);
            localStorage.setItem('SECOND_NAME', data.user.second_name);
            localStorage.setItem('EMAIL', data.user.email);
            localStorage.setItem('EMAIL_VERIFIED_AT', data.user.email_verified_at);
            localStorage.setItem('PHONE_NUMBER', data.user.phone_number);
            localStorage.setItem('IMAGE', data.user.image);
            state.ACCESS_TOKEN = data.access_token;
            state.TOKEN_TYPE = data.token_type;
            state.ID = data.user.id;
            state.FIRST_NAME = data.user.first_name;
            state.SECOND_NAME = data.user.second_name;
            state.EMAIL = data.user.email;
            state.EMAIL_VERIFIED_AT = data.user.email_verified_at;
            state.PHONE_NUMBER = data.user.phone_number;
            state.IMAGE = data.user.image;
        },
        UNSET_USER: (state) => {
            localStorage.removeItem('ACCESS_TOKEN');
            localStorage.removeItem('TOKEN_TYPE');
            localStorage.removeItem('ID');
            localStorage.removeItem('FIRST_NAME');
            localStorage.removeItem('SECOND_NAME');
            localStorage.removeItem('EMAIL');
            localStorage.removeItem('EMAIL_VERIFIED_AT');
            localStorage.removeItem('PHONE_NUMBER');
            localStorage.removeItem('IMAGE');
            state.ACCESS_TOKEN = null;
            state.TOKEN_TYPE = null;
            state.ID = null;
            state.FIRST_NAME = null;
            state.SECOND_NAME = null;
            state.EMAIL = null;
            state.EMAIL_VERIFIED_AT = null;
            state.PHONE_NUMBER = null;
            state.IMAGE = null;
        }
    },
    actions: {
        LOGIN_USER(context, payload) {
            return new Promise((resolve, reject) => {
                if (payload.access_token) {
                    const access_token = payload.access_token;
                    const token_type = payload.token_type;
                    const user = payload.user;
                    const data = {
                        access_token: access_token,
                        token_type: token_type,
                        user: user
                    };
                    context.commit('SET_USER', data);
                    resolve(data);
                } else {
                    reject(null);
                }
            });
        },
        LOGOUT_USER(context) {
            axios.defaults.headers.common['Authorization'] =
                context.getters.TOKEN_TYPE + ' ' + context.getters.ACCESS_TOKEN;

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
        }
    }
}
