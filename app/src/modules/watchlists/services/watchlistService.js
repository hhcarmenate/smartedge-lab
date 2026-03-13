import api from "@/lib/api/axios.js";

export const getWatchlists = () => {
    return api.get('/api/v1/watchlists')
}

export const getWatchlistById = (id) => {
    return api.get(`/api/v1/watchlists/${id}`)
}

export const createWatchlist = (payload) => {
    return api.post('/api/v1/watchlists', payload)
}

export const fetchBySymbol = (query, limit) => {
    return api.get('/api/v1/symbols/search', {
        params: {
            query,
            limit
        }
    } )
}

export const addTickerToWatchlist = (ticker, id) => {
    return api.post(`/api/v1/watchlists/${id}/items`, { ticker })
}

export const deleteWatchlist = (id) => {
    return api.delete(`/api/v1/watchlists/${id}`)
}

export const deleteWatchlistItem = (itemId) => {
    return api.delete(`/api/v1/watchlist-items/${itemId}`)
}
