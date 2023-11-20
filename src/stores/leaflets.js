import { defineStore } from "pinia";

export const useLeafletStore = defineStore('useLeafletStore', {
  state: () => ({
    data: {
      leaflets: [],
      loading: false
    },
  }),
  actions: {
    setLeaflet(data) {
      this.data.leaflets = data
    },
    setSpinner(data) {
      this.data.loading = data
    }
  }
})