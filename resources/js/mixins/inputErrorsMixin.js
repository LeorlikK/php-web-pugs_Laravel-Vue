export default {
    methods: {
        saveError(errors) {
            const arrayErrors = errors.response.data.errors
            this.errors.loginError = arrayErrors.login ?? ''
            this.errors.emailError = arrayErrors.email ?? ''
            this.errors.passwordError = arrayErrors.password ?? ''
            this.errors.currentPasswordError = arrayErrors.password_confirmation ?? ''
            this.errors.avatarError = arrayErrors.avatar ?? ''
        }
    }
}
