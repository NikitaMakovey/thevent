import axios from 'axios';

export default {
    state: {
        EVENTS: null,
        EVENT: null,
        EVENT_ORGANIZERS: null,
        EVENT_SPEAKERS: null,
        EVENT_SKILLS: null,
        EVENT_STATUS: null
    },
    getters: {
        EVENTS: state => { return state.EVENTS },
        EVENT: state => { return state.EVENT },
        EVENT_ORGANIZERS: state => { return state.EVENT_ORGANIZERS },
        EVENT_SPEAKERS: state => { return state.EVENT_SPEAKERS },
        EVENT_SKILLS: state => { return state.EVENT_SKILLS },
        EVENT_STATUS: state => { return state.EVENT_STATUS },
    },
    mutations: {
        REFRESH_EVENTS: (state, data) => {
            state.EVENTS = data;
        },
        REFRESH_EVENT: (state, data) => {
            state.EVENT = data.event;
            state.EVENT_ORGANIZERS = data.organizers;
            state.EVENT_SPEAKERS = data.speakers;
            state.EVENT_SKILLS = data.skills;
        },
        REFRESH_STATUS: (state, data) => {
            state.EVENT_STATUS = data.status;
        }
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
        },
        GET_EVENT(context, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/v1/events/' + payload.id)
                    .then(({data}) => {
                        context.commit('REFRESH_EVENT', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        GET_STATUS(context, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/v1/users/' + payload.user_id + '/events/' + payload.event_id)
                    .then(({data}) => {
                        context.commit('REFRESH_STATUS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        SEND_REQUEST(context, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/v1/characters', {

                })
            });
        }
    }
}
