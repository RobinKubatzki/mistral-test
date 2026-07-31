<script setup>
import { ref, watch } from 'vue'
import { useGuestStore } from '../../stores/guestStore'

const props = defineProps({
  guest: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['close', 'success'])

const guestStore = useGuestStore()

const formData = ref({
  full_name: '',
  age: null,
  category: 'standard',
  arrival_day: new Date().toISOString().split('T')[0],
  note: '',
  register_id: ''
})

const categories = ['standard', 'vip', 'family', 'group', 'other']

watch(() => props.guest, (newGuest) => {
  if (newGuest) {
    formData.value = {
      full_name: newGuest.full_name || '',
      age: newGuest.age || null,
      category: newGuest.category || 'standard',
      arrival_day: newGuest.arrival_day || new Date().toISOString().split('T')[0],
      note: newGuest.note || '',
      register_id: newGuest.register_id || ''
    }
  } else {
    formData.value = {
      full_name: '',
      age: null,
      category: 'standard',
      arrival_day: new Date().toISOString().split('T')[0],
      note: '',
      register_id: ''
    }
  }
}, { immediate: true })

const isSubmitting = ref(false)
const error = ref(null)

async function handleSubmit() {
  if (isSubmitting.value) return
  
  isSubmitting.value = true
  error.value = null
  
  try {
    if (props.guest?.id) {
      // Update existing guest
      await guestStore.updateGuest(props.guest.id, formData.value)
    } else {
      // Create new guest
      await guestStore.createGuest(formData.value)
    }
    
    emit('success')
    emit('close')
  } catch (err) {
    error.value = err.message || 'An error occurred'
  } finally {
    isSubmitting.value = false
  }
}

function handleCancel() {
  emit('close')
}
</script>

<template>
  <form @submit.prevent="handleSubmit" class="guest-form">
    <div v-if="error" class="error-message">
      {{ error }}
    </div>
    
    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="full_name">Full Name *</label>
        <input 
          id="full_name" 
          v-model="formData.full_name" 
          type="text" 
          class="form-input" 
          required
          placeholder="Enter full name"
        />
      </div>
      
      <div class="form-group">
        <label class="form-label" for="register_id">Register ID *</label>
        <input 
          id="register_id" 
          v-model="formData.register_id" 
          type="text" 
          class="form-input" 
          required
          placeholder="Enter register ID"
        />
      </div>
    </div>
    
    <div class="form-row">
      <div class="form-group">
        <label class="form-label" for="age">Age</label>
        <input 
          id="age" 
          v-model.number="formData.age" 
          type="number" 
          class="form-input" 
          min="0"
          max="120"
          placeholder="Enter age"
        />
      </div>
      
      <div class="form-group">
        <label class="form-label" for="category">Category *</label>
        <select id="category" v-model="formData.category" class="form-input" required>
          <option v-for="category in categories" :key="category" :value="category">
            {{ category }}
          </option>
        </select>
      </div>
    </div>
    
    <div class="form-group">
      <label class="form-label" for="arrival_day">Arrival Day *</label>
      <input 
        id="arrival_day" 
        v-model="formData.arrival_day" 
        type="date" 
        class="form-input" 
        required
      />
    </div>
    
    <div class="form-group">
      <label class="form-label" for="note">Notes</label>
      <textarea 
        id="note" 
        v-model="formData.note" 
        class="form-input form-textarea" 
        placeholder="Enter any additional notes"
      ></textarea>
    </div>
    
    <div class="form-actions">
      <button type="button" @click="handleCancel" class="btn btn-secondary" :disabled="isSubmitting">
        Cancel
      </button>
      <button type="submit" class="btn btn-primary" :disabled="isSubmitting">
        <span v-if="isSubmitting">Saving...</span>
        <span v-else>{{ guest?.id ? 'Update Guest' : 'Add Guest' }}</span>
      </button>
    </div>
  </form>
</template>

<style scoped>
.guest-form {
  max-width: 600px;
  margin: 0 auto;
}

.error-message {
  color: #d32f2f;
  background: #ffebee;
  padding: 10px 15px;
  border-radius: 4px;
  margin-bottom: 20px;
  font-size: 14px;
}

.form-row {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin-bottom: 15px;
}

.form-group {
  margin-bottom: 15px;
}

.form-label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
  color: #555;
  font-size: 14px;
}

.form-input {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
  transition: border-color 0.2s, box-shadow 0.2s;

  &:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
  }
}

.form-textarea {
  resize: vertical;
  min-height: 100px;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 25px;
  padding-top: 20px;
  border-top: 1px solid #eee;
}

.form-actions button {
  min-width: 100px;
}
</style>
