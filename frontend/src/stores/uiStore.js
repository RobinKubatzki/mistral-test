import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useUiStore = defineStore('ui', () => {
  const isStatsModalVisible = ref(false)
  const isAddGuestModalVisible = ref(false)
  const isCheckinModalVisible = ref(false)
  const currentView = ref('list') // 'list' or 'details'

  function toggleStatsModal() {
    isStatsModalVisible.value = !isStatsModalVisible.value
  }

  function showStatsModal() {
    isStatsModalVisible.value = true
  }

  function hideStatsModal() {
    isStatsModalVisible.value = false
  }

  function toggleAddGuestModal() {
    isAddGuestModalVisible.value = !isAddGuestModalVisible.value
  }

  function showAddGuestModal() {
    isAddGuestModalVisible.value = true
  }

  function hideAddGuestModal() {
    isAddGuestModalVisible.value = false
  }

  function toggleCheckinModal() {
    isCheckinModalVisible.value = !isCheckinModalVisible.value
  }

  function showCheckinModal() {
    isCheckinModalVisible.value = true
  }

  function hideCheckinModal() {
    isCheckinModalVisible.value = false
  }

  function setView(view) {
    currentView.value = view
  }

  return {
    isStatsModalVisible,
    isAddGuestModalVisible,
    isCheckinModalVisible,
    currentView,
    toggleStatsModal,
    showStatsModal,
    hideStatsModal,
    toggleAddGuestModal,
    showAddGuestModal,
    hideAddGuestModal,
    toggleCheckinModal,
    showCheckinModal,
    hideCheckinModal,
    setView
  }
})
