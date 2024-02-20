import { defineStore } from "pinia";

export const useLeafletStore = defineStore('useLeafletStore', {
  state: () => ({
    data: {
      page: '',
      url: '',
      leaflets: [],
      currentPage: 1,
      ttlItem: 1,
      itemsPerPage: 1,
      maxPageShow: 1,
      loading: false
    },
  }),
  actions: {
    setLeaflet(data) {
      this.data.leaflets = data
    },
    setPaginate(params) {
      this.currentPage = params.currentPage
      this.ttlItem = params.ttlItem
      this.itemsPerPage = params.itemsPerPage
      this.maxPageShow = params.maxPageShow
    },
    setSpinner(data) {
      this.data.loading = data
    }
  }
})