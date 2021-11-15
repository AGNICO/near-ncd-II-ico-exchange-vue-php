import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Profile from '../views/Profile.vue'
import Buy from '../views/Buy.vue'
import ErrorPage from '../views/ErrorPage.vue'
import SuccessPage from '../views/SuccessPage.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/profile',
    name: 'Profile',
    component: Profile
  },
  {
    path: '/buy',
    name: 'Buy',
    component: Buy,
    props: true
  },
  {
    path: '/error',
    name: 'Error',
    component: ErrorPage,
    props: true
  },
  {
    path: '/success',
    name: 'Success',
    component: SuccessPage,
    props: true
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
