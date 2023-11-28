export default {
    data() {
        return {
            errors: {
                loginError: '',
                emailError: '',
                passwordError: '',
                currentPasswordError: '',
                roleError: '',
                feedbackError: '',
                avatarError: '',
                fileError: '',
                imageError: '',
                videoError: '',
                audioError: '',
                titleError: '',
                shortError: '',
                textError: '',
            }
        }
    },
    methods: {
        saveError(errors) {
            const arrayErrors = errors.response.data.errors
            this.errors.loginError = arrayErrors.login ?? ''
            this.errors.emailError = arrayErrors.email ?? ''
            this.errors.roleError = arrayErrors.role ?? ''
            this.errors.passwordError = arrayErrors.password ?? ''
            this.errors.currentPasswordError = arrayErrors.password_confirmation ?? ''
            this.errors.feedbackError = arrayErrors.feedback ?? ''
            this.errors.avatarError = arrayErrors.avatar ?? ''
            this.errors.fileError = arrayErrors.file ?? ''
            this.errors.imageError = arrayErrors.image ?? ''
            this.errors.videoError = arrayErrors.video ?? ''
            this.errors.audioError = arrayErrors.audio ?? ''
            this.errors.titleError = arrayErrors.title ?? ''
            this.errors.shortError = arrayErrors.short ?? ''
            this.errors.textError = arrayErrors.text ?? ''
        },
        clearErrors() {
            for (let errorKey in this.errors) {
                this.errors[errorKey] = ''
            }
        }
    }
}
