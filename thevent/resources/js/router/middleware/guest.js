export default function guest ({ next, store }) {
    if (store.getters.ACCESS_TOKEN) {
        return next({
            name: 'events'
        });
    }
    return next();
}
