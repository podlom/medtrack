<script setup>
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
</script>

<template>
  <div>
    <h2>User Profile</h2>
    <pre>{{ auth.user }}</pre>
  </div>
</template>
