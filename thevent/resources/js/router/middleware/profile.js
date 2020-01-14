export default function profile ({ to, next, store }) {
    if (store.getters.ACCESS_TOKEN && (store.getters.ID == to.params.id)) {
        return next({
            name: 'profile'
        });
    }
    return next();
}
