<script setup>
import { ref, onMounted, watch } from 'vue'

const props = defineProps({
  guest: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['submit', 'cancel'])

const canvas = ref(null)
const context = ref(null)
const isDrawing = ref(false)
const signatureData = ref(null)
const lastX = ref(0)
const lastY = ref(0)

function initCanvas() {
  if (!canvas.value) return
  
  context.value = canvas.value.getContext('2d')
  context.value.strokeStyle = '#000000'
  context.value.lineWidth = 3
  context.value.lineCap = 'round'
  context.value.lineJoin = 'round'
  
  clearCanvas()
  
  // Set canvas size to match its display size
  resizeCanvas()
}

function resizeCanvas() {
  if (canvas.value) {
    const rect = canvas.value.getBoundingClientRect()
    canvas.value.width = rect.width
    canvas.value.height = rect.height
    if (context.value) {
      context.value.strokeStyle = '#000000'
      context.value.lineWidth = 3
      context.value.lineCap = 'round'
      context.value.lineJoin = 'round'
    }
  }
}

function clearCanvas() {
  if (context.value && canvas.value) {
    context.value.clearRect(0, 0, canvas.value.width, canvas.value.height)
  }
  signatureData.value = null
}

function startDrawing(e) {
  isDrawing.value = true
  const pos = getPosition(e)
  lastX.value = pos.x
  lastY.value = pos.y
}

function draw(e) {
  if (!isDrawing.value) return
  
  const pos = getPosition(e)
  
  context.value.beginPath()
  context.value.moveTo(lastX.value, lastY.value)
  context.value.lineTo(pos.x, pos.y)
  context.value.stroke()
  
  lastX.value = pos.x
  lastY.value = pos.y
}

function endDrawing() {
  isDrawing.value = false
  
  if (canvas.value) {
    signatureData.value = canvas.value.toDataURL('image/png')
  }
}

function getPosition(e) {
  if (!canvas.value) return { x: 0, y: 0 }
  
  const rect = canvas.value.getBoundingClientRect()
  const clientX = e.clientX || (e.touches && e.touches[0]?.clientX) || 0
  const clientY = e.clientY || (e.touches && e.touches[0]?.clientY) || 0
  
  return {
    x: clientX - rect.left,
    y: clientY - rect.top
  }
}

function handleSubmit() {
  if (signatureData.value) {
    emit('submit', signatureData.value)
  }
}

function handleCancel() {
  emit('cancel')
}

function handleClear() {
  clearCanvas()
}

onMounted(() => {
  initCanvas()
  window.addEventListener('resize', resizeCanvas)
})

watch(() => props.guest, () => {
  clearCanvas()
})
</script>

<template>
  <div class="signature-pad">
    <div class="guest-info">
      <h3>Sign for: {{ guest.full_name }}</h3>
      <p>Category: {{ guest.category }}</p>
      <p>Arrival: {{ guest.arrival_day }}</p>
      <p v-if="guest.note" class="note">Note: {{ guest.note }}</p>
    </div>
    
    <div class="canvas-container">
      <canvas 
        ref="canvas" 
        @touchstart="startDrawing" 
        @touchmove="draw" 
        @touchend="endDrawing"
        @mousedown="startDrawing" 
        @mousemove="draw" 
        @mouseup="endDrawing"
        @mouseleave="endDrawing"
      ></canvas>
      <p class="instruction">Please sign above with your finger or stylus</p>
    </div>
    
    <div class="signature-actions">
      <button @click="handleClear" class="btn btn-secondary" :disabled="!signatureData">
        Clear
      </button>
      <button @click="handleCancel" class="btn btn-danger">
        Cancel
      </button>
      <button 
        @click="handleSubmit" 
        class="btn btn-primary" 
        :disabled="!signatureData"
      >
        Submit Signature
      </button>
    </div>
  </div>
</template>

<style scoped>
.signature-pad {
  display: flex;
  flex-direction: column;
  height: 100%;
  max-width: 800px;
  margin: 0 auto;
}

.guest-info {
  background: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 20px;
}

.guest-info h3 {
  margin: 0 0 10px 0;
  color: #333;
}

.guest-info p {
  margin: 5px 0;
  color: #666;
  font-size: 14px;
}

.note {
  font-style: italic;
  color: #888;
}

.canvas-container {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin: 20px 0;
  min-height: 300px;
}

canvas {
  border: 2px solid #333;
  background: white;
  width: 100%;
  max-width: 800px;
  height: 400px;
  touch-action: none;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  cursor: crosshair;
}

.instruction {
  margin-top: 15px;
  color: #666;
  font-size: 14px;
  text-align: center;
}

.signature-actions {
  display: flex;
  gap: 15px;
  justify-content: center;
  margin-top: 20px;
}

.signature-actions button {
  padding: 12px 24px;
  font-size: 16px;
  min-width: 120px;
}
</style>
