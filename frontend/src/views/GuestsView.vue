<script setup>
import { useGuests } from '../composables/useGuests'
import { useUiStore } from '../stores/uiStore'
import GuestList from '../components/guests/GuestList.vue'
import GuestDetails from '../components/guests/GuestDetails.vue'
import StatsModal from '../components/statistics/StatsModal.vue'
import GuestForm from '../components/guests/GuestForm.vue'
import CheckinModal from '../components/checkout/CheckinModal.vue'

const { selectedGuest, fetchGuests } = useGuests()
const uiStore = useUiStore()

// Load guests on mount
fetchGuests()
</script>

<template>
  <div class="guests-view">
    <div class="view-header">
      <h2>Guest Management</h2>
      <div class="view-actions">
        <button @click="uiStore.setView(uiStore.currentView === 'list' ? 'details' : 'list')" class="btn btn-secondary">
          {{ uiStore.currentView === 'list' ? 'Show Details' : 'Show List' }}
        </button>
      </div>
    </div>
    
    <div class="view-content">
      <div v-if="uiStore.currentView === 'list' || !selectedGuest" class="list-view">
        <GuestList />
      </div>
      
      <div v-else class="details-view">
        <GuestDetails :guest="selectedGuest" />
      </div>
    </div>
    
    <!-- Modals -->
    <StatsModal />
    
    <Modal 
      :isVisible="uiStore.isAddGuestModalVisible" 
      title="Add New Guest" 
      size="medium"
      @close="uiStore.hideAddGuestModal"
    >
      <GuestForm @success="uiStore.hideAddGuestModal" @close="uiStore.hideAddGuestModal" />
    </Modal>
    
    <CheckinModal 
      v-if="selectedGuest?.checkin_in_progress" 
      :guestId="selectedGuest.id" 
      @close="selectedGuest = null"
    />
  </div>
</template>

<style scoped>
.guests-view {
  height: 100%;
  display: flex;
  flex-direction: column;
}

.view-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.view-header h2 {
  margin: 0;
  color: #333;
}

.view-content {
  flex: 1;
  display: flex;
  gap: 20px;
  overflow: hidden;
}

.list-view {
  flex: 1;
  overflow: hidden;
}

.details-view {
  flex: 1;
  overflow: hidden;
}
</style>
