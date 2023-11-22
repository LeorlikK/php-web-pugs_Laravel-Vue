export default {
    data() {
        return {
            textConfirm: '',
            question: false,
            objQuestion: null,
        }
    },
    methods: {
        confirm(obj, textConfirm){
            this.textConfirm = textConfirm
            this.question = true
            this.objQuestion = obj
        }
    }
}
