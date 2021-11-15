import { createApp } from 'vue'
import App from './App.vue'
import './assets/styles/app.css'
import store from './store'
import router from './router'
import Near from './services/near.service.js'

const app = createApp(App)

app.use(router)
app.use(store)
app.use(Near, { env: process.env.NODE_ENV || 'development' })

app.mount('#app')
