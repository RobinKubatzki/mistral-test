<script setup>
import { ref, watch } from 'vue'
import { useGuestStore } from '../../stores/guestStore'
import { useUiStore } from '../../stores/uiStore'
import SignaturePad from './SignaturePad.vue'

const guestStore = useGuestStore()
const uiStore = useUiStore()

const props = defineProps({
  guestId: {
    type: Number,
    required: true
  }
})

const emit = defineEmits(['close'])

const guest = ref(null)
const isLoading = ref(false)
const error = ref(null)

async function loadGuest() {
  try {
    isLoading.value = true
    const result = await guestStore.fetchGuestById(props.guestId)
    guest.value = result
  } catch (err) {
    error.value = err.message
  } finally {
    isLoading.value = false
  }
}

async function handleSignatureSubmit(signatureData) {
  try {
    isLoading.value = true
    error.value = null
    
    const success = await guestStore.completeCheckin(props.guestId, signatureData)
    
    if (success) {
      uiStore.hideCheckinModal()
      emit('close')
    }
  } catch (err) {
    error.value = err.message
  } finally {
    isLoading.value = false
  }
}

function handleCancel() {
  uiStore.hideCheckinModal()
  emit('close')
}

watch(() => props.guestId, () => {
  loadGuest()
}, { immediate: true })
</script>

<template>
  <Modal 
    :isVisible="uiStore.isCheckinModalVisible" 
    title="Collect Signature" 
    size="large"
    @close="handleCancel"
  >
    <div v-if="isLoading" class="loading-container">
      <LoadingSpinner size="large" text="Loading guest..." />
    </div>
    
    <div v-else-if="error" class="error-message">
      <p>{{ error }}</p>
      <button @click="loadGuest" class="btn btn-secondary">Retry</button>
    </div>
    
    <div v-else-if="guest" class="checkin-content">
      <SignaturePad 
        :guest="guest" 
        @submit="handleSignatureSubmit" 
        @cancel="handleCancel"
      />
    </div>
    
    <template #footer>
      <p class="footer-note">Signature will be saved and guest will be marked as checked in</p>
    </template>
  </Modal>
</template>

<style scoped>
.checkin-content {
  height: 60vh;
  min-height: 500px;
}

.loading-container {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 300px;
}

.error-message {
  text-align: center;
  padding: 40px;
  color: #d32f2f;
}

.footer-note {
  font-size: 12px;
  color: #666;
  margin: 0;
}
</style>
