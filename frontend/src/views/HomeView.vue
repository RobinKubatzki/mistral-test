<script setup>
import { useGuests } from '../composables/useGuests'
import { useUiStore } from '../stores/uiStore'
import GuestList from '../components/guests/GuestList.vue'
import GuestDetails from '../components/guests/GuestDetails.vue'
import StatsSummary from '../components/statistics/StatsSummary.vue'
import StatsModal from '../components/statistics/StatsModal.vue'
import GuestForm from '../components/guests/GuestForm.vue'
import CheckinModal from '../components/checkout/CheckinModal.vue'

const { selectedGuest, fetchGuests } = useGuests()
const uiStore = useUiStore()

// Load guests on mount
fetchGuests()
</script>

<template>
  <div class="home-view">
    <StatsSummary />
    
    <div class="main-content">
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
.home-view {
  height: 100%;
  display: flex;
  flex-direction: column;
}

.main-content {
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
