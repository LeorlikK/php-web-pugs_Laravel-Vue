export default {
    data() {
        return {
            path: '/storage/',
            file: null,
            fileImage: null,
            fileVideo: null,
            fileAudio: null,
            showImage: false,

            percent: 0,
            process: false
        }
    },
    methods: {
        changeShowImage(value) {
            this.showImage = value
        },
        changeFile(event) {
            this.file = event.target.files[0]
            if (this.file) {
                this.file = URL.createObjectURL(this.file);
            }
        },
        changeImage(event) {
            this.fileImage = event.target.files[0]
            if (this.fileImage) {
                this.image = URL.createObjectURL(this.fileImage);
            }
        },
        changeVideo(event) {
            this.fileVideo = event.target.files[0]
            console.log(111)
            if (this.fileVideo) {
                console.log(222)
                this.video = URL.createObjectURL(this.fileVideo);
            }
        },
        changeAudio(event) {
            this.fileAudio = event.target.files[0]
            if (this.fileAudio) {
                this.audio = URL.createObjectURL(this.fileAudio);
            }
        },
        audioUpdateVolume(event) {
            let currentDate = new Date();
            let currentYear = currentDate.getFullYear()
            currentDate.setMonth(currentYear + 1)
            document.cookie = `audio-volume=${event.target.volume}; expires=${currentDate.toUTCString()}`
        }
    },
    computed: {
        btnIsActive() {
            return this.file !== null && this.file !== undefined
        },
        imageBtnIsActive() {
            return this.fileImage !== null && this.fileImage !== undefined
        },
        videoBtnIsActive() {
            return this.fileVideo !== null && this.fileVideo !== undefined
        },
        audioBtnIsActive() {
            return this.fileAudio !== null && this.fileAudio !== undefined
        }
    },
}
