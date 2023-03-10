import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '@/views/PortadaView.vue'
import PortadaView from '@/views/HomeView.vue'
import UsersView from '@/views/UsersView.vue'
import AboutView from '@/views/AboutView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: AboutView
  },
  {
    path: '/portada',
    name: 'portada',
    component: PortadaView
  },
  {
    path: '/users',
    name: 'users',
    component: UsersView
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
