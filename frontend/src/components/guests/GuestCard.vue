<script setup>
import { useCheckin } from '../../composables/useCheckin'

const props = defineProps({
  guest: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['select'])

const { startCheckin } = useCheckin()

function handleSelect() {
  emit('select', props.guest)
}

function handleCheckin() {
  startCheckin(props.guest.id)
}

function getStatusClass() {
  if (props.guest.checked_in) return 'status-checked-in'
  if (props.guest.checkin_in_progress) return 'status-in-progress'
  return 'status-pending'
}

function getStatusText() {
  if (props.guest.checked_in) return 'Checked In'
  if (props.guest.checkin_in_progress) return 'In Progress'
  return 'Pending'
}
</script>

<template>
  <div class="guest-card" @click="handleSelect">
    <div class="guest-header">
      <h3 class="guest-name">{{ guest.full_name }}</h3>
      <span class="status" :class="getStatusClass()">
        {{ getStatusText() }}
      </span>
    </div>
    
    <div class="guest-details">
      <p class="guest-category">
        <strong>Category:</strong> {{ guest.category }}
      </p>
      <p class="guest-arrival">
        <strong>Arrival:</strong> {{ guest.arrival_day }}
      </p>
      <p class="guest-age" v-if="guest.age">
        <strong>Age:</strong> {{ guest.age }}
      </p>
    </div>
    
    <div class="guest-actions">
      <button 
        v-if="!guest.checked_in && !guest.checkin_in_progress" 
        @click.stop="handleCheckin"
        class="btn btn-primary btn-sm"
      >
        Start Checkin
      </button>
      <button 
        v-if="guest.checkin_in_progress" 
        class="btn btn-secondary btn-sm"
        disabled
      >
        Waiting for Signature
      </button>
      <button 
        v-if="guest.checked_in" 
        class="btn btn-secondary btn-sm"
      >
        View Details
      </button>
    </div>
  </div>
</template>

<style scoped>
.guest-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 15px;
  cursor: pointer;
  transition: all 0.2s;
  border: 1px solid transparent;

  &:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    border-color: #4CAF50;
    transform: translateY(-2px);
  }
}

.guest-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
}

.guest-name {
  margin: 0;
  font-size: 1.1rem;
  color: #333;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.status {
  padding: 4px 8px;
  border-radius: 12px;
  font-size: 12px;
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

.guest-details {
  margin-bottom: 15px;
}

.guest-details p {
  margin: 5px 0;
  font-size: 14px;
  color: #555;
}

.guest-actions {
  display: flex;
  gap: 8px;
}

.btn-sm {
  padding: 6px 12px;
  font-size: 12px;
}
</style>
