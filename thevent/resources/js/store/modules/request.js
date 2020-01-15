import axios from 'axios';

export default {
    state: {
        REQUEST_STEP: localStorage.getItem('REQUEST_STEP') || 1,
        REQUEST_SKILLS: null,
        REQUEST_ID : localStorage.getItem('REQUEST_ID') || null
    },
    getters: {
        REQUEST_STEP: state => { return state.REQUEST_STEP },
        REQUEST_SKILLS: state => { return state.REQUEST_SKILLS },
        REQUEST_ID: state => { return state.REQUEST_ID },
    },
    mutations: {
        SET_REQUEST_STEP: (state, data) => {
            localStorage.setItem('REQUEST_STEP', data);
            state.REQUEST_STEP = data;
        },
        UNSET_REQUEST_STEP: (state) => {
            localStorage.setItem('REQUEST_STEP', 1);
            state.REQUEST_STEP = 1;
        },
        REFRESH_SKILLS: (state, data) => {
            state.REQUEST_SKILLS = data;
        },
        SET_REQUEST_ID: (state, data) => {
            localStorage.setItem('REQUEST_ID', data);
            state.REQUEST_ID = data;
        },
        UNSET_REQUEST_ID: (state, data) => {
            localStorage.removeItem('REQUEST_ID');
        }
    },
    actions: {
        GET_ALL_SKILLS(context) {
            return new Promise((resolve, reject) => {
                axios.get('/api/v1/skills')
                    .then(({data}) => {
                        context.commit('REFRESH_SKILLS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        SET_REQUEST_STEP(context, payload) {
            return new Promise((resolve) => {
                context.commit('SET_REQUEST_STEP', payload);
                resolve(payload);
            });
        },
        UNSET_REQUEST_STEP(context) {
            return new Promise((resolve) => {
                context.commit('UNSET_REQUEST_STEP');
                resolve(1);
            });
        },
        SET_REQUEST_ID(context, payload) {
            return new Promise((resolve) => {
                context.commit('SET_REQUEST_ID', payload);
                resolve(payload);
            });
        },
        UNSET_REQUEST_ID(context) {
            return new Promise((resolve) => {
                context.commit('UNSET_REQUEST_ID');
                resolve(1);
            });
        }
    }
}
