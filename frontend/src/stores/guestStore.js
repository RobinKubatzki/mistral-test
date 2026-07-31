import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api/v1'

export const useGuestStore = defineStore('guest', () => {
  const guests = ref([])
  const selectedGuest = ref(null)
  const isLoading = ref(false)
  const error = ref(null)
  const filters = ref({
    search: '',
    category: '',
    checked_in: '',
    arrival_day: ''
  })

  const filteredGuests = computed(() => {
    return guests.value.filter(guest => {
      const matchesSearch = filters.value.search 
        ? guest.full_name.toLowerCase().includes(filters.value.search.toLowerCase())
        : true
      
      const matchesCategory = filters.value.category 
        ? guest.category === filters.value.category
        : true
      
      const matchesCheckedIn = filters.value.checked_in !== ''
        ? guest.checked_in === (filters.value.checked_in === 'true')
        : true
      
      const matchesArrivalDay = filters.value.arrival_day
        ? guest.arrival_day === filters.value.arrival_day
        : true
      
      return matchesSearch && matchesCategory && matchesCheckedIn && matchesArrivalDay
    })
  })

  const categories = computed(() => {
    const uniqueCategories = new Set(guests.value.map(g => g.category))
    return Array.from(uniqueCategories)
  })

  const arrivalDays = computed(() => {
    const uniqueDays = new Set(guests.value.map(g => g.arrival_day))
    return Array.from(uniqueDays).sort()
  })

  const stats = computed(() => {
    const total = guests.value.length
    const checkedIn = guests.value.filter(g => g.checked_in).length
    const pending = total - checkedIn
    const byCategory = {}
    
    guests.value.forEach(guest => {
      byCategory[guest.category] = (byCategory[guest.category] || 0) + 1
    })
    
    return {
      total,
      checkedIn,
      pending,
      byCategory
    }
  })

  async function fetchGuests() {
    try {
      isLoading.value = true
      error.value = null
      
      const response = await axios.get(`${API_BASE_URL}/guests`)
      guests.value = response.data
    } catch (err) {
      error.value = err.message
      console.error('Error fetching guests:', err)
    } finally {
      isLoading.value = false
    }
  }

  async function fetchGuestById(id) {
    try {
      isLoading.value = true
      error.value = null
      
      const response = await axios.get(`${API_BASE_URL}/guests/${id}`)
      selectedGuest.value = response.data
      return response.data
    } catch (err) {
      error.value = err.message
      console.error('Error fetching guest:', err)
      return null
    } finally {
      isLoading.value = false
    }
  }

  async function createGuest(guestData) {
    try {
      isLoading.value = true
      error.value = null
      
      const response = await axios.post(`${API_BASE_URL}/guests`, guestData)
      guests.value.push(response.data)
      return response.data
    } catch (err) {
      error.value = err.message
      console.error('Error creating guest:', err)
      return null
    } finally {
      isLoading.value = false
    }
  }

  async function updateGuest(id, guestData) {
    try {
      isLoading.value = true
      error.value = null
      
      const response = await axios.put(`${API_BASE_URL}/guests/${id}`, guestData)
      const index = guests.value.findIndex(g => g.id === id)
      if (index !== -1) {
        guests.value[index] = response.data
      }
      selectedGuest.value = response.data
      return response.data
    } catch (err) {
      error.value = err.message
      console.error('Error updating guest:', err)
      return null
    } finally {
      isLoading.value = false
    }
  }

  async function deleteGuest(id) {
    try {
      isLoading.value = true
      error.value = null
      
      await axios.delete(`${API_BASE_URL}/guests/${id}`)
      guests.value = guests.value.filter(g => g.id !== id)
      if (selectedGuest.value?.id === id) {
        selectedGuest.value = null
      }
      return true
    } catch (err) {
      error.value = err.message
      console.error('Error deleting guest:', err)
      return false
    } finally {
      isLoading.value = false
    }
  }

  async function startCheckin(guestId) {
    try {
      isLoading.value = true
      error.value = null
      
      await axios.post(`${API_BASE_URL}/checkin/start/${guestId}`)
      const index = guests.value.findIndex(g => g.id === guestId)
      if (index !== -1) {
        guests.value[index].checkin_in_progress = true
      }
      return true
    } catch (err) {
      error.value = err.message
      console.error('Error starting checkin:', err)
      return false
    } finally {
      isLoading.value = false
    }
  }

  async function completeCheckin(guestId, signatureData) {
    try {
      isLoading.value = true
      error.value = null
      
      await axios.post(`${API_BASE_URL}/checkin/complete/${guestId}`, { signature_data: signatureData })
      const index = guests.value.findIndex(g => g.id === guestId)
      if (index !== -1) {
        guests.value[index].checked_in = true
        guests.value[index].checkin_in_progress = false
        guests.value[index].checkin_date = new Date().toISOString()
      }
      return true
    } catch (err) {
      error.value = err.message
      console.error('Error completing checkin:', err)
      return false
    } finally {
      isLoading.value = false
    }
  }

  function setFilters(newFilters) {
    filters.value = { ...filters.value, ...newFilters }
  }

  function clearFilters() {
    filters.value = {
      search: '',
      category: '',
      checked_in: '',
      arrival_day: ''
    }
  }

  function selectGuest(guest) {
    selectedGuest.value = guest
  }

  return {
    guests,
    selectedGuest,
    isLoading,
    error,
    filters,
    filteredGuests,
    categories,
    arrivalDays,
    stats,
    fetchGuests,
    fetchGuestById,
    createGuest,
    updateGuest,
    deleteGuest,
    startCheckin,
    completeCheckin,
    setFilters,
    clearFilters,
    selectGuest
  }
})
