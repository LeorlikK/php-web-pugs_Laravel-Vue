export const getCookie = (name) => {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([.$?*|{}()[\]\\/+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

export const getLocalStorage = (name) => {
    let value = localStorage.getItem(name)

    return value ? value : undefined
}

export const setLocalStorage = (name, value) => {
    localStorage.setItem(name, value)
}

export const forgotLocalStorage = (name) => {
    localStorage.removeItem(name)
}
