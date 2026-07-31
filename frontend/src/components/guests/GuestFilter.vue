<script setup>
import { useFilter } from '../../composables/useFilter'

const { 
  filters, 
  categories, 
  arrivalDays, 
  applyFilters, 
  clearFilters 
} = useFilter()

const filterData = {
  search: '',
  category: '',
  checked_in: '',
  arrival_day: ''
}

function apply() {
  applyFilters({
    search: filterData.search,
    category: filterData.category,
    checked_in: filterData.checked_in,
    arrival_day: filterData.arrival_day
  })
}

function clear() {
  filterData.search = ''
  filterData.category = ''
  filterData.checked_in = ''
  filterData.arrival_day = ''
  clearFilters()
}
</script>

<template>
  <div class="guest-filter">
    <div class="filter-row">
      <div class="filter-group">
        <label class="filter-label">Search</label>
        <input 
          v-model="filterData.search" 
          type="text" 
          class="filter-input" 
          placeholder="Search by name..."
          @keyup.enter="apply"
        />
      </div>
      
      <div class="filter-group">
        <label class="filter-label">Category</label>
        <select v-model="filterData.category" class="filter-input">
          <option value="">All Categories</option>
          <option v-for="category in categories" :key="category" :value="category">
            {{ category }}
          </option>
        </select>
      </div>
      
      <div class="filter-group">
        <label class="filter-label">Checkin Status</label>
        <select v-model="filterData.checked_in" class="filter-input">
          <option value="">All Statuses</option>
          <option value="true">Checked In</option>
          <option value="false">Not Checked In</option>
        </select>
      </div>
      
      <div class="filter-group">
        <label class="filter-label">Arrival Day</label>
        <select v-model="filterData.arrival_day" class="filter-input">
          <option value="">All Days</option>
          <option v-for="day in arrivalDays" :key="day" :value="day">
            {{ day }}
          </option>
        </select>
      </div>
    </div>
    
    <div class="filter-actions">
      <button @click="apply" class="btn btn-primary">Apply Filters</button>
      <button @click="clear" class="btn btn-secondary">Clear</button>
    </div>
  </div>
</template>

<style scoped>
.guest-filter {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  margin-bottom: 20px;
}

.filter-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 15px;
  margin-bottom: 15px;
}

.filter-group {
  display: flex;
  flex-direction: column;
}

.filter-label {
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 5px;
  color: #555;
}

.filter-input {
  padding: 8px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
  transition: border-color 0.2s;

  &:focus {
    outline: none;
    border-color: #4CAF50;
  }
}

.filter-actions {
  display: flex;
  gap: 10px;
  justify-content: flex-end;
}

.filter-actions button {
  padding: 8px 16px;
  font-size: 14px;
}
</style>
