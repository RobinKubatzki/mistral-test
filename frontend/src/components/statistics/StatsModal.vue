<script setup>
import { useGuestStore } from '../../stores/guestStore'
import { useUiStore } from '../../stores/uiStore'

const guestStore = useGuestStore()
const uiStore = useUiStore()

function closeModal() {
  uiStore.hideStatsModal()
}
</script>

<template>
  <Modal 
    :isVisible="uiStore.isStatsModalVisible" 
    title="Statistics" 
    size="medium"
    @close="closeModal"
  >
    <div class="stats-container">
      <div class="stats-overview">
        <h3>Overview</h3>
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-value">{{ guestStore.stats.total }}</div>
            <div class="stat-label">Total Guests</div>
          </div>
          <div class="stat-card">
            <div class="stat-value">{{ guestStore.stats.checkedIn }}</div>
            <div class="stat-label">Checked In</div>
          </div>
          <div class="stat-card">
            <div class="stat-value">{{ guestStore.stats.pending }}</div>
            <div class="stat-label">Pending</div>
          </div>
          <div class="stat-card">
            <div class="stat-value">
              {{ Math.round((guestStore.stats.checkedIn / guestStore.stats.total * 100) * 100) / 100 }}%
            </div>
            <div class="stat-label">Checkin Rate</div>
          </div>
        </div>
      </div>
      
      <div class="stats-by-category">
        <h3>By Category</h3>
        <div class="category-chart">
          <div 
            v-for="(count, category) in guestStore.stats.byCategory" 
            :key="category" 
            class="category-bar"
            :style="{ width: `${(count / guestStore.stats.total * 100)}%` }"
          >
            <span class="category-name">{{ category }}</span>
            <span class="category-count">{{ count }}</span>
          </div>
        </div>
      </div>
    </div>
    
    <template #footer>
      <button @click="closeModal" class="btn btn-secondary">Close</button>
    </template>
  </Modal>
</template>

<style scoped>
.stats-container {
  max-height: 70vh;
  overflow-y: auto;
}

.stats-overview {
  margin-bottom: 30px;
}

.stats-overview h3 {
  margin-bottom: 15px;
  color: #555;
  font-size: 1.1rem;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 15px;
}

.stat-card {
  background: #f9f9f9;
  padding: 20px;
  border-radius: 8px;
  text-align: center;
  transition: all 0.2s;

  &:hover {
    background: #f0f0f0;
    transform: translateY(-2px);
  }
}

.stat-value {
  font-size: 2rem;
  font-weight: 700;
  color: #4CAF50;
  margin-bottom: 5px;
}

.stat-label {
  font-size: 14px;
  color: #666;
}

.stats-by-category {
  margin-top: 20px;
}

.stats-by-category h3 {
  margin-bottom: 15px;
  color: #555;
  font-size: 1.1rem;
}

.category-chart {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.category-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 15px;
  background: #e8f5e9;
  border-radius: 4px;
  transition: width 0.5s ease;
  min-width: 50px;
}

.category-name {
  font-weight: 600;
  color: #333;
}

.category-count {
  background: #4CAF50;
  color: white;
  padding: 2px 8px;
  border-radius: 12px;
  font-size: 12px;
}
</style>
