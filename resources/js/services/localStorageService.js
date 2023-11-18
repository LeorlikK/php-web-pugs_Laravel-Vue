const localStorageService = {
    setLocalStorage: (name, value) => {
        localStorage.setItem(name, JSON.stringify(value))
    },
    getLocalStorage: (name) => {
        let value = localStorage.getItem(name)

        return value ? JSON.parse(value) : undefined
    },
    forgotLocalStorage: (name) => {
        localStorage.removeItem(name)
    }
}

export default localStorageService
