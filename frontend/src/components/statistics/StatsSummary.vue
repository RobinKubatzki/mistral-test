<script setup>
import { useGuestStore } from '../../stores/guestStore'

const guestStore = useGuestStore()
</script>

<template>
  <div class="stats-summary">
    <div class="summary-cards">
      <div class="summary-card">
        <div class="card-icon">👥</div>
        <div class="card-content">
          <div class="card-value">{{ guestStore.stats.total }}</div>
          <div class="card-label">Total Guests</div>
        </div>
      </div>
      
      <div class="summary-card">
        <div class="card-icon">✅</div>
        <div class="card-content">
          <div class="card-value">{{ guestStore.stats.checkedIn }}</div>
          <div class="card-label">Checked In</div>
        </div>
      </div>
      
      <div class="summary-card">
        <div class="card-icon">⏳</div>
        <div class="card-content">
          <div class="card-value">{{ guestStore.stats.pending }}</div>
          <div class="card-label">Pending</div>
        </div>
      </div>
      
      <div class="summary-card">
        <div class="card-icon">📊</div>
        <div class="card-content">
          <div class="card-value">
            {{ Math.round((guestStore.stats.checkedIn / guestStore.stats.total * 100) * 100) / 100 }}%
          </div>
          <div class="card-label">Checkin Rate</div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.stats-summary {
  margin-bottom: 20px;
}

.summary-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 15px;
}

.summary-card {
  background: white;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  gap: 15px;
  transition: all 0.2s;

  &:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
  }
}

.card-icon {
  font-size: 2rem;
}

.card-content {
  flex: 1;
}

.card-value {
  font-size: 1.5rem;
  font-weight: 700;
  color: #4CAF50;
  margin-bottom: 5px;
}

.card-label {
  font-size: 14px;
  color: #666;
}
</style>
