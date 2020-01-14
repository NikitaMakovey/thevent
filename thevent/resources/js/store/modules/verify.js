import axios from 'axios';

export default {
    state: {
        VERIFY_MESSAGE: localStorage.getItem('VERIFY_MESSAGE') || '',
    },
    getters: {
        VERIFY_MESSAGE: state => { return state.VERIFY_MESSAGE },
    },
    mutations: {
        REFRESH_VERIFY_MESSAGE: (state, data) => {
            localStorage.setItem('VERIFY_MESSAGE', data.message);
            state.VERIFY_MESSAGE = data.message;
        },
        REMOVE_VERIFY_MESSAGE: () => {
            localStorage.removeItem('VERIFY_MESSAGE');
        },
    },
    actions: {
        SET_VERIFY_MESSAGE(context, payload) {
            return new Promise(resolve => {
                context.commit('REFRESH_VERIFY_MESSAGE', payload);
                resolve(payload.message);
            })
        },
        UNSET_VERIFY_MESSAGE(context) {
            return new Promise(resolve => {
                context.commit('REMOVE_VERIFY_MESSAGE');
                resolve(1);
            })
        }
    }
}
