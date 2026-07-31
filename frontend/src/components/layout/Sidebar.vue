<script setup>
import { useUiStore } from '../../stores/uiStore'

const uiStore = useUiStore()
</script>

<template>
  <aside class="sidebar">
    <nav class="sidebar-nav">
      <router-link to="/" class="nav-item" active-class="active">
        <i class="nav-icon">🏠</i> Dashboard
      </router-link>
      <router-link to="/guests" class="nav-item" active-class="active">
        <i class="nav-icon">👥</i> Guests
      </router-link>
    </nav>
    <div class="sidebar-footer">
      <button @click="uiStore.setView(uiStore.currentView === 'list' ? 'details' : 'list')" class="view-toggle">
        {{ uiStore.currentView === 'list' ? 'Show Details' : 'Show List' }}
      </button>
    </div>
  </aside>
</template>

<style scoped>
.sidebar {
  width: 250px;
  background: white;
  border-right: 1px solid #ddd;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.sidebar-nav {
  flex: 1;
  padding: 20px 0;
}

.nav-item {
  display: flex;
  align-items: center;
  padding: 12px 20px;
  color: #333;
  text-decoration: none;
  transition: all 0.2s;
  border-left: 3px solid transparent;

  &:hover {
    background: #f5f5f5;
  }

  &.active {
    background: #e8f5e9;
    border-left-color: #4CAF50;
    color: #4CAF50;
    font-weight: 600;
  }
}

.nav-icon {
  margin-right: 10px;
  font-size: 1.2rem;
}

.sidebar-footer {
  padding: 20px;
  border-top: 1px solid #ddd;
}

.view-toggle {
  width: 100%;
  padding: 10px;
  background: #f5f5f5;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.2s;

  &:hover {
    background: #e0e0e0;
  }
}
</style>
