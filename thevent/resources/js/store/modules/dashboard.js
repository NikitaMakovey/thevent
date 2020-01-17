import axios from 'axios';

export default {
    state: {
        DB_ROLES: null,
        MM_REQUESTS: null,
        MM_REQUEST: null,
        MM_REQUEST_COMMENT: null,
        MM_REQUEST_SKILLS: null,
        EM_REQUESTS: null,
        EM_REQUEST: null,
        V_REQUESTS: null,
        V_REQUEST: null,
        O_REQUESTS: null,
        S_REQUESTS: null,
        A_REQUESTS: null,
    },
    getters: {
        DB_ROLES: state => { return state.DB_ROLES },
        MM_REQUESTS: state => { return state.MM_REQUESTS },
        MM_REQUEST: state => { return state.MM_REQUEST },
        MM_REQUEST_COMMENT: state => { return state.MM_REQUEST_COMMENT },
        MM_REQUEST_SKILLS: state => { return state.MM_REQUEST_SKILLS },
        EM_REQUESTS: state => { return state.EM_REQUESTS },
        EM_REQUEST: state => { return state.EM_REQUEST },
        V_REQUESTS: state => { return state.V_REQUESTS },
        V_REQUEST: state => { return state.V_REQUEST },
        O_REQUESTS: state => { return state.O_REQUESTS },
        S_REQUESTS: state => { return state.S_REQUESTS },
        A_REQUESTS: state => { return state.A_REQUESTS },
    },
    mutations: {
        REFRESH_DB_ROLES: (state, data) => {
            state.DB_ROLES = data;
        },
        REFRESH_MM_REQUESTS: (state, data) => {
            state.MM_REQUESTS = data;
        },
        REFRESH_MM_REQUEST: (state, data) => {
            state.MM_REQUEST = data.event;
            state.MM_REQUEST_COMMENT = data.comment.comment;
            state.MM_REQUEST_SKILLS = data.skills;
        },
        REFRESH_EM_REQUESTS: (state, data) => {
            state.EM_REQUESTS = data;
        },
        REFRESH_EM_REQUEST: (state, data) => {
            state.EM_REQUEST = data;
        },
        REFRESH_V_REQUESTS: (state, data) => {
            state.V_REQUESTS = data;
        },
        REFRESH_V_REQUEST: (state, data) => {
            state.V_REQUEST = data;
        },
        REFRESH_O_REQUESTS: (state, data) => {
            state.O_REQUESTS = data;
        },
        REFRESH_S_REQUESTS: (state, data) => {
            state.S_REQUESTS = data;
        },
        REFRESH_A_REQUESTS: (state, data) => {
            state.A_REQUESTS = data;
        },
    },
    actions: {
        GET_DB_ROLES(context, config) {
            return new Promise(resolve => {
                axios.get('/api/auth/roles', config)
                    .then(({data}) => {
                        context.commit('REFRESH_DB_ROLES', data.roles);
                        resolve(data.roles);
                    })
            })
        },
        GET_MM_REQUESTS(context, config) {
            return new Promise(resolve => {
                axios.get('/api/auth/dashboard/main-moderator/requests', config)
                    .then(({data}) => {
                        context.commit('REFRESH_MM_REQUESTS', data.events);
                        resolve(data.events);
                    })
            })
        },
        GET_MM_REQUEST(context, payload) {
            return new Promise(resolve => {
                axios.get('/api/auth/dashboard/main-moderator/requests/' + payload.id, payload.config)
                    .then(({data}) => {
                        context.commit('REFRESH_MM_REQUEST', data);
                        resolve(data);
                    })
            })
        },
        GET_EM_REQUESTS(context, config) {
            return new Promise(resolve => {
                axios.get('/api/auth/dashboard/event-moderator/events', config)
                    .then(({data}) => {
                        context.commit('REFRESH_EM_REQUESTS', data.events);
                        resolve(data);
                    })
            })
        },
        GET_EM_REQUEST(context, payload) {
            return new Promise(resolve => {
                axios.get('/api/auth/dashboard/event-moderator/events/' + payload.id, payload.config)
                    .then(({data}) => {
                        context.commit('REFRESH_EM_REQUEST', data.requests);
                        resolve(data);
                    })
            })
        },
        GET_V_REQUESTS(context, config) {
            return new Promise(resolve => {
                axios.get('/api/auth/dashboard/volunteer/events', config)
                    .then(({data}) => {
                        context.commit('REFRESH_V_REQUESTS', data.events);
                        resolve(data);
                    })
            })
        },
        GET_V_REQUEST(context, payload) {
            return new Promise(resolve => {
                axios.get('/api/auth/dashboard/volunteer/events/' + payload.id, payload.config)
                    .then(({data}) => {
                        context.commit('REFRESH_V_REQUEST', data.users);
                        resolve(data);
                    })
            })
        },
        GET_O_REQUESTS(context, config) {
            return new Promise(resolve => {
                axios.get('/api/auth/dashboard/organizer/events', config)
                    .then(({data}) => {
                        context.commit('REFRESH_O_REQUESTS', data.events);
                        resolve(data);
                    })
            })
        },
        GET_O_REQUEST(context, payload) {
            return new Promise(resolve => {
                axios.get('/api/auth/dashboard/organizer/events/' + payload.id, payload.config)
                    .then(({data}) => {
                        context.commit('REFRESH_EM_REQUEST', data.requests);
                        resolve(data);
                    })
            })
        },
        GET_S_REQUESTS(context, config) {
            return new Promise(resolve => {
                axios.get('/api/auth/dashboard/speaker/events', config)
                    .then(({data}) => {
                        context.commit('REFRESH_S_REQUESTS', data.events);
                        resolve(data);
                    })
            })
        },
        GET_A_REQUESTS(context, config) {
            return new Promise(resolve => {
                axios.get('/api/auth/dashboard/admin/main-moderators', config)
                    .then(({data}) => {
                        context.commit('REFRESH_A_REQUESTS', data.users);
                        resolve(data);
                    })
            })
        },
    }
}
