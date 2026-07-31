import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useFilterStore = defineStore('filter', () => {
  const isFilterVisible = ref(false)

  function toggleFilter() {
    isFilterVisible.value = !isFilterVisible.value
  }

  function showFilter() {
    isFilterVisible.value = true
  }

  function hideFilter() {
    isFilterVisible.value = false
  }

  return {
    isFilterVisible,
    toggleFilter,
    showFilter,
    hideFilter
  }
})
