const cookieService = {
    setCookie: (name, value, days) => {
        const currentDate = new Date();
        currentDate.setDate(currentDate.getDate() + days);
        const expirationDate = currentDate.toUTCString();
        document.cookie = `${name}=${encodeURIComponent(JSON.stringify(value))}; expires=${expirationDate}; path=/`;
    },
    getCookie: (name) => {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([.$?*|{}()[\]\\/+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    },
    forgotCookie: (name) => {
        document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
    }
}

export default cookieService


