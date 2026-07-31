import { useGuestStore } from '../stores/guestStore'
import { onMounted } from 'vue'

export function useGuests() {
  const guestStore = useGuestStore()

  onMounted(() => {
    guestStore.fetchGuests()
  })

  return {
    ...guestStore
  }
}
