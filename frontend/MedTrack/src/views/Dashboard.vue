<script setup>
import { onMounted, ref } from 'vue'
import API from '@/api'

const treatments = ref([])

onMounted(async () => {
  const res = await API.get('/treatments')
  treatments.value = res.data
})
</script>

<template>
  <div>
    <h2>Your Treatments</h2>
    <ul>
      <li v-for="t in treatments" :key="t.id">{{ t.title }}</li>
    </ul>
  </div>
</template>
