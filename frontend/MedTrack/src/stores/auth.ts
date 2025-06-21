// src/stores/auth.ts
import { defineStore } from 'pinia'
import API from '@/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as any,
    token: localStorage.getItem('token'),
  }),
  actions: {
    async login(email: string, password: string) {
      const res = await API.post('/login', { email, password })
      this.token = res.data.token
      localStorage.setItem('token', this.token!)
      await this.fetchUser()
    },
    async logout() {
      this.token = null
      this.user = null
      localStorage.removeItem('token')
    },
    async fetchUser() {
      const res = await API.get('/me')
      this.user = res.data
    }
  },
})
