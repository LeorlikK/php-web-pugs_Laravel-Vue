import './bootstrap';
import '../css/reset.css';
import '../css/app.css';
import {createApp} from "vue";
import App from './Pages/App.vue'
import router from "./router.js";
import components from './components.js'
import store from "@/store";
import {authService} from "@/services/authService.js";
import Vobserver from "@/directives/Vobserver";

const app = createApp(App)
components.forEach((component) => {
    app.component(component.name, component)
})
app.directive('observer', Vobserver)

app.use(store)
authService().checkAuth().finally(() => {
    app.use(router)
    app.mount('#app')
})



