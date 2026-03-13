import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from './router'

import './style.css'
import App from './App.vue'
import {initializeAuth} from "@/services/init-auth.js";

const app = createApp(App)

app.use(createPinia())
app.use(router)

await initializeAuth()

app.mount('#app')
