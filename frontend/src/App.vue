<script setup>
import Header from './components/layout/Header.vue'
import Sidebar from './components/layout/Sidebar.vue'
</script>

<template>
  <div class="app">
    <Header />
    <div class="app-content">
      <Sidebar />
      <main class="main-content">
        <router-view />
      </main>
    </div>
  </div>
</template>

<style scoped>
.app {
  display: flex;
  flex-direction: column;
  height: 100vh;
}

.app-content {
  display: flex;
  flex: 1;
  overflow: hidden;
}

.main-content {
  flex: 1;
  padding: 20px;
  overflow-y: auto;
  background: #f5f5f5;
}
</style>
