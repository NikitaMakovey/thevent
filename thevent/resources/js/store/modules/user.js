import axios from 'axios';

export default {
    state: {
        USERS: null,
        USER_INFO: null,
        USER_EVENTS: null,
        USER_SKILLS: null
    },
    getters: {
        USERS: state => { return state.USERS },
        USER_INFO: state => { return state.USER_INFO },
        USER_EVENTS: state => { return state.USER_EVENTS },
        USER_SKILLS: state => { return state.USER_SKILLS }
    },
    mutations: {
        REFRESH_USERS: (state, data) => {
            state.USERS = data;
        },
        REFRESH_USER: (state, data) => {
            state.USER_INFO = data.user;
            state.USER_EVENTS = data.events;
            state.USER_SKILLS = data.skills;
        }
    },
    actions: {
        GET_USERS(context) {
            return new Promise((resolve, reject) => {
                axios.get('/api/v1/users')
                    .then(({data}) => {
                        context.commit('REFRESH_USERS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        GET_USER(context, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/v1/users/' + payload.id)
                    .then(({data}) => {
                        context.commit('REFRESH_USER', data);
                        resolve(data.skills);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        }
    }
}
