import './bootstrap';
import {createApp} from "vue";
import App from './Pages/App.vue'
import router from "./router.js";
import components from './components.js'
import store from "@/store";
import {authService} from "@/services/authService.js";

const app = createApp(App)
components.forEach((component) => {
    app.component(component.name, component)
})
app.use(store)
authService().checkAuth().finally(() => {
    app.use(router)
    app.mount('#app')
})



