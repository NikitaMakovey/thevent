import axios from 'axios';

export default {
    state: {
        USER_TOPICS: null,
        TOPICS: null
    },
    getters: {
        USER_TOPICS: state => { return state.USER_TOPICS },
        TOPICS: state => { return state.TOPICS }
    },
    mutations: {
        REFRESH_USER_TOPICS: (state, data) => {
            state.USER_TOPICS = data;
        },
        REFRESH_TOPICS: (state, data) => {
            state.USER_TOPICS = data;
        },
    },
    actions: {
        GET_TOPICS(context, config) {
            return new Promise((resolve, reject) => {
                axios.get('/api/auth/user/topics', config)
                    .then(({data}) => {
                        context.commit('REFRESH_USER_TOPICS', data.topics);
                        resolve(data.topics);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        GET_ALL_TOPICS(context) {
            return new Promise((resolve, reject) => {
                axios.get('/api/v1/topics')
                    .then(({data}) => {
                        context.commit('REFRESH_TOPICS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        }
    }
}
