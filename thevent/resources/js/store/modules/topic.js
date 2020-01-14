import axios from 'axios';

export default {
    state: {
        USER_TOPICS: null
    },
    getters: {
        USER_TOPICS: state => { return state.USER_TOPICS }
    },
    mutations: {
        REFRESH_TOPICS: (state, data) => {
            state.USER_TOPICS = data;
        }
    },
    actions: {
        GET_TOPICS(context, config) {
            return new Promise((resolve, reject) => {
                axios.get('/api/auth/user/topics', config)
                    .then(({data}) => {
                        context.commit('REFRESH_TOPICS', data.topics);
                        resolve(data.topics);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        }
    }
}
