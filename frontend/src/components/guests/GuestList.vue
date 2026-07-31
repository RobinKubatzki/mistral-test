<script setup>
import { useGuests } from '../../composables/useGuests'
import { useUiStore } from '../../stores/uiStore'
import GuestCard from './GuestCard.vue'
import GuestFilter from './GuestFilter.vue'

const { filteredGuests, isLoading, error, selectGuest } = useGuests()
const uiStore = useUiStore()

function handleGuestSelect(guest) {
  selectGuest(guest)
  uiStore.setView('details')
}
</script>

<template>
  <div class="guest-list">
    <GuestFilter />
    
    <div v-if="isLoading" class="loading-container">
      <LoadingSpinner size="large" text="Loading guests..." />
    </div>
    
    <div v-else-if="error" class="error-message">
      <p>Error loading guests: {{ error }}</p>
      <button @click="fetchGuests" class="btn btn-secondary">Retry</button>
    </div>
    
    <div v-else-if="filteredGuests.length === 0" class="no-guests">
      <p>No guests found matching your filters.</p>
    </div>
    
    <div v-else class="guests-grid">
      <GuestCard 
        v-for="guest in filteredGuests" 
        :key="guest.id" 
        :guest="guest" 
        @select="handleGuestSelect"
      />
    </div>
  </div>
</template>

<style scoped>
.guest-list {
  height: 100%;
  display: flex;
  flex-direction: column;
}

.loading-container {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

.error-message {
  text-align: center;
  padding: 40px;
  color: #d32f2f;
  background: #ffebee;
  border-radius: 8px;
}

.no-guests {
  text-align: center;
  padding: 40px;
  color: #666;
}

.guests-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  flex: 1;
  overflow-y: auto;
}
</style>
