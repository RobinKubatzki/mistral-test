<script setup>
import { useGuestStore } from '../../stores/guestStore'
import { useCheckin } from '../../composables/useCheckin'

const guestStore = useGuestStore()
const { startCheckin } = useCheckin()

const props = defineProps({
  guest: {
    type: Object,
    required: true
  }
})

function formatDate(dateString) {
  if (!dateString) return 'N/A'
  return new Date(dateString).toLocaleString()
}
</script>

<template>
  <div class="guest-details">
    <div class="details-header">
      <h2 class="guest-name">{{ guest.full_name }}</h2>
      <span class="status" :class="getStatusClass()">
        {{ getStatusText() }}
      </span>
    </div>
    
    <div class="details-grid">
      <div class="detail-item">
        <label>Register ID</label>
        <p>{{ guest.register_id }}</p>
      </div>
      <div class="detail-item">
        <label>Category</label>
        <p>{{ guest.category }}</p>
      </div>
      <div class="detail-item">
        <label>Age</label>
        <p>{{ guest.age || 'N/A' }}</p>
      </div>
      <div class="detail-item">
        <label>Arrival Day</label>
        <p>{{ guest.arrival_day }}</p>
      </div>
      <div class="detail-item">
        <label>Checked In</label>
        <p>{{ guest.checked_in ? 'Yes' : 'No' }}</p>
      </div>
      <div class="detail-item">
        <label>Checkin Date</label>
        <p>{{ formatDate(guest.checkin_date) }}</p>
      </div>
    </div>
    
    <div v-if="guest.note" class="notes-section">
      <h4>Notes</h4>
      <p class="note-content">{{ guest.note }}</p>
    </div>
    
    <div class="actions-section">
      <button 
        v-if="!guest.checked_in && !guest.checkin_in_progress" 
        @click="startCheckin(guest.id)"
        class="btn btn-primary"
      >
        Start Checkin
      </button>
      <button 
        v-if="guest.checkin_in_progress" 
        class="btn btn-warning"
        disabled
      >
        Waiting for Signature
      </button>
      <button class="btn btn-secondary">Edit</button>
      <button class="btn btn-danger">Delete</button>
    </div>
  </div>
</template>

<style scoped>
.guest-details {
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 25px;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.details-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 1px solid #eee;
}

.guest-name {
  margin: 0;
  font-size: 1.5rem;
  color: #333;
}

.status {
  padding: 6px 12px;
  border-radius: 16px;
  font-size: 14px;
  font-weight: 600;
}

.status-checked-in {
  background: #e8f5e9;
  color: #2e7d32;
}

.status-in-progress {
  background: #e3f2fd;
  color: #1565c0;
}

.status-pending {
  background: #fff3e0;
  color: #e65100;
}

.details-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 15px;
  margin: 20px 0;
  flex: 1;
}

.detail-item {
  label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #777;
    margin-bottom: 5px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  p {
    margin: 0;
    font-size: 16px;
    color: #333;
  }
}

.notes-section {
  margin-top: 20px;
  padding-top: 20px;
  border-top: 1px solid #eee;
}

.notes-section h4 {
  margin-bottom: 10px;
  color: #555;
}

.note-content {
  padding: 10px;
  background: #f9f9f9;
  border-radius: 4px;
  border-left: 3px solid #4CAF50;
}

.actions-section {
  display: flex;
  gap: 10px;
  margin-top: 20px;
  padding-top: 20px;
  border-top: 1px solid #eee;
}
</style>
