<script setup>
import { useUiStore } from '../../stores/uiStore'

const uiStore = useUiStore()
</script>

<template>
  <header class="header">
    <div class="header-content">
      <div class="logo">
        <h1>Checkin-Tool</h1>
      </div>
      <div class="header-actions">
        <button @click="uiStore.showStatsModal()" class="btn btn-secondary">
          <i class="icon">📊</i> Statistics
        </button>
        <button @click="uiStore.showAddGuestModal()" class="btn btn-primary">
          <i class="icon">+</i> Add Guest
        </button>
      </div>
    </div>
  </header>
</template>

<style scoped>
.header {
  background: white;
  border-bottom: 1px solid #ddd;
  padding: 15px 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1400px;
  margin: 0 auto;
}

.logo h1 {
  font-size: 1.5rem;
  color: #4CAF50;
  margin: 0;
}

.header-actions {
  display: flex;
  gap: 10px;
}

.header-actions button {
  padding: 10px 16px;
  font-size: 14px;
}

.icon {
  margin-right: 5px;
}
</style>
