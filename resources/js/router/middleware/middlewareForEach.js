export function nextMiddleware(index, middleware, to, from, next) {
    const currentMiddleware = middleware[index];

    if (!currentMiddleware) {
        document.title = to.meta.title
        return next();
    }

    currentMiddleware({
        to,
        from,
        next: (result) => {
            if (result === false) {
                return next({ name: to.meta.redirectRoute });
            }

            nextMiddleware(index + 1, middleware, to, from, next);
        }
    });
}
