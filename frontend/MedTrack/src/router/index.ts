// src/router/index.ts
import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/views/Login.vue'
import Dashboard from '@/views/Dashboard.vue'
import Treatments from '@/views/Treatments.vue'
import Profile from '@/views/Profile.vue'

const routes = [
  { path: '/', redirect: '/login' },
  { path: '/login', component: Login },
  {
    path: '/',
    component: Dashboard,
    children: [
      { path: '', redirect: '/treatments' },
      { path: 'treatments', component: Treatments },
      { path: 'profile', component: Profile },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
