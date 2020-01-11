import axios from 'axios';

export default {
    state: {
        EVENTS: null,
        EVENT: null,
        EVENT_ORGANIZERS: null,
        EVENT_SPEAKERS: null,
    },
    getters: {
        EVENTS: state => { return state.EVENTS },
        EVENT: state => { return state.EVENT },
        EVENT_ORGANIZERS: state => { return state.EVENT_ORGANIZERS },
        EVENT_SPEAKERS: state => { return state.EVENT_SPEAKERS }
    },
    mutations: {
        REFRESH_EVENTS: (state, data) => {
            state.EVENTS = data;
        },
        REFRESH_EVENT: (state, data) => {
            state.EVENT = data.event;
            state.EVENT_ORGANIZERS = data.orginizers;
            state.EVENT = data.event;
        },
    },
    actions: {
        GET_EVENTS(context) {
            return new Promise((resolve, reject) => {
                axios.get('/api/v1/events')
                    .then(({data}) => {
                        context.commit('REFRESH_EVENTS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        }
    }
}
