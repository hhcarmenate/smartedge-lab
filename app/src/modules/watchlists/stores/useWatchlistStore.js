import {defineStore} from "pinia";
import {
    getWatchlists,
    getWatchlistById,
    createWatchlist,
    fetchBySymbol,
    addTickerToWatchlist,
    deleteWatchlist,
    deleteWatchlistItem
} from "@/modules/watchlists/services/watchlistService.js";

export const useWatchlistStore = defineStore('watchlists', {
    state: () => ({
        watchlists: [],
        selectedWatchlist: null,
        loading: false,
        loadingSymbol: false,
        symbolsResult: []
    }),

    actions: {
        async removeSymbolFromWatchlist(itemId) {
            this.loading = true;
            try {
                await deleteWatchlistItem(itemId);
                if (this.selectedWatchlist) {
                    this.selectedWatchlist.items = this.selectedWatchlist.items.filter(item => item.id !== itemId);
                }
            } catch (error) {
                console.error('Error removing symbol from watchlist:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async addSymbolToWatchlist({ ticker, watchlistId }) {
          this.loading = true;

          try {
            await addTickerToWatchlist(ticker, watchlistId);
          } catch (error) {
            console.error('Error adding symbol to watchlist:', error);
          } finally {
            this.loading = false;
          }

        },


        async getBySymbol(payload) {
            this.loadingSymbol = true;
            const { query, limit } = payload;
            try {
                const response = await fetchBySymbol(query, limit);
                this.symbolsResult = response.data?.data || [];

                return response
            } catch (error) {
                console.error('Error fetching symbol:', error);
            } finally {
                this.loadingSymbol = false;
            }

        },

        async fetchWatchlists() {
            this.loading = true;
            try {
                const response = await getWatchlists();
                this.watchlists = response.data?.data || [];
            } catch (error) {
                console.error('Error fetching watchlists:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchWatchlistById(id) {
            this.loading = true;
            try {
                const response = await getWatchlistById(id);
                this.selectedWatchlist = response.data?.data || null;
            } catch (error) {
                console.error('Error fetching watchlist by id:', error);
                throw error;
            } finally {
                this.loading = false;
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
            this.loading = true;
            try {
                await deleteWatchlist(id);
                this.watchlists = this.watchlists.filter(w => w.id !== id);
                if (this.selectedWatchlist?.id === id) {
                    this.selectedWatchlist = null;
                }
            } catch (error) {
                console.error('Error deleting watchlist:', error);
                throw error;
            } finally {
                this.loading = false;
            }
        },
    }
})
