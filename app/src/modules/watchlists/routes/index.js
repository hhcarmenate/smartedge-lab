export default [
    {
        path: 'watchlists',
        name: 'watchlists.index',
        component: () => import('@/modules/watchlists/views/WatchlistsView.vue'),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: 'watchlists/create',
        name: 'watchlists.create',
        component: () => import('@/modules/watchlists/views/CreateWatchlistView.vue'),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: 'watchlists/:id',
        name: 'watchlists.show',
        component: () => import('@/modules/watchlists/views/WatchlistShowView.vue'),
        meta: {
            requiresAuth: true
        }
    }
];
