import { defineStore } from 'pinia'
import {
  getWatchlists,
  getWatchlistById,
  createWatchlist,
  fetchBySymbol,
  addTickerToWatchlist,
  deleteWatchlist,
  deleteWatchlistItem,
} from '@/modules/watchlists/services/watchlistService.js'

export const useWatchlistStore = defineStore('watchlists', {
  state: () => ({
    watchlists: [],
    selectedWatchlist: null,
    loading: false,
    loadingAdd: false,
    loadingRemove: false,
    loadingSymbol: false,
    symbolsResult: [],
  }),

  actions: {
    async fetchWatchlists() {
      this.loading = true
      try {
        const response = await getWatchlists()
        this.watchlists = response.data?.data || []
      } catch (error) {
        console.error('Error fetching watchlists:', error)
      } finally {
        this.loading = false
      }
    },

    async fetchWatchlistById(id) {
      this.loading = true
      try {
        const response = await getWatchlistById(id)
        this.selectedWatchlist = response.data?.data || null
      } catch (error) {
        console.error('Error fetching watchlist by id:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    async createWatchlist(payload) {
      this.loading = true
      try {
        const response = await createWatchlist(payload)
        this.watchlists.unshift(response.data.data)
        return response.data.data
      } catch (error) {
        console.error('Failed to create watchlist', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    async deleteWatchlist(id) {
      this.loading = true
      try {
        await deleteWatchlist(id)
        this.watchlists = this.watchlists.filter(w => w.id !== id)
        if (this.selectedWatchlist?.id === id) {
          this.selectedWatchlist = null
        }
      } catch (error) {
        console.error('Error deleting watchlist:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    async addSymbolToWatchlist({ ticker, watchlistId }) {
      this.loadingAdd = true
      try {
        await addTickerToWatchlist(ticker, watchlistId)
        if (this.selectedWatchlist?.id == watchlistId) {
          const refreshed = await getWatchlistById(watchlistId)
          this.selectedWatchlist = refreshed.data?.data || this.selectedWatchlist
        }
      } catch (error) {
        console.error('Error adding symbol to watchlist:', error)
        throw error
      } finally {
        this.loadingAdd = false
      }
    },

    async removeSymbolFromWatchlist(itemId) {
      this.loadingRemove = true
      try {
        await deleteWatchlistItem(itemId)
        if (this.selectedWatchlist) {
          this.selectedWatchlist.items = this.selectedWatchlist.items.filter(item => item.id !== itemId)
        }
      } catch (error) {
        console.error('Error removing symbol from watchlist:', error)
        throw error
      } finally {
        this.loadingRemove = false
      }
    },

    async getBySymbol({ query, limit }) {
      this.loadingSymbol = true
      try {
        const response = await fetchBySymbol(query, limit)
        this.symbolsResult = response.data?.data || []
        return response
      } catch (error) {
        console.error('Error fetching symbol:', error)
      } finally {
        this.loadingSymbol = false
      }
    },
  },
})
