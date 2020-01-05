export default function auth ({ next, store }) {
    if (!store.getters.ACCESS_TOKEN) {
        return next({
            name: 'auth.login'
        });
    }
    return next();
}
