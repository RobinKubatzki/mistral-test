import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import GuestsView from '../views/GuestsView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/guests',
    name: 'guests',
    component: GuestsView
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
