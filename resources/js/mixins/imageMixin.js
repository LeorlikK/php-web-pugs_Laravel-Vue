export default {
    methods: {
        changeShowImage(value) {
            this.showImage = value
        },
        changeImage(event) {
            this.file = event.target.files[0]
            if (this.file) {
                this.avatar = URL.createObjectURL(this.file);
            }
        },
    }
}
