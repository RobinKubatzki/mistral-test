import { useGuestStore } from '../stores/guestStore'
import { useUiStore } from '../stores/uiStore'

export function useCheckin() {
  const guestStore = useGuestStore()
  const uiStore = useUiStore()

  const startCheckin = async (guestId) => {
    const success = await guestStore.startCheckin(guestId)
    if (success) {
      uiStore.showCheckinModal()
    }
    return success
  }

  const completeCheckin = async (guestId, signatureData) => {
    const success = await guestStore.completeCheckin(guestId, signatureData)
    if (success) {
      uiStore.hideCheckinModal()
    }
    return success
  }

  const cancelCheckin = async (guestId) => {
    // Implementation for canceling checkin
    const index = guestStore.guests.findIndex(g => g.id === guestId)
    if (index !== -1) {
      guestStore.guests[index].checkin_in_progress = false
    }
    uiStore.hideCheckinModal()
  }

  return {
    startCheckin,
    completeCheckin,
    cancelCheckin
  }
}
