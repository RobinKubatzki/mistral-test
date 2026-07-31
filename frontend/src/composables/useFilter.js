import { useGuestStore } from '../stores/guestStore'
import { useFilterStore } from '../stores/filterStore'

export function useFilter() {
  const guestStore = useGuestStore()
  const filterStore = useFilterStore()

  const applyFilters = (filters) => {
    guestStore.setFilters(filters)
  }

  const clearFilters = () => {
    guestStore.clearFilters()
  }

  const toggleFilterVisibility = () => {
    filterStore.toggleFilter()
  }

  return {
    filters: guestStore.filters,
    filteredGuests: guestStore.filteredGuests,
    categories: guestStore.categories,
    arrivalDays: guestStore.arrivalDays,
    isFilterVisible: filterStore.isFilterVisible,
    applyFilters,
    clearFilters,
    toggleFilterVisibility
  }
}
