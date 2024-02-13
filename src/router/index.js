import { createRouter, createWebHashHistory } from 'vue-router'

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('@/views/leaflet/Index.vue'),
        children: [
            {
                path: '',
                name: 'LeafletList',
                component: () => import('@/views/leaflet/List.vue'),
            },
            {
                path: 'leaflet/:id/:nama?',
                name: 'LeafletDetail',
                component: () => import('@/views/leaflet/Detail.vue'),
            }
        ],
    },
    // {
    //     path: '/leaflet',
    //     name: 'Leaflet',
    //     component: () => import('@/views/leaflet/Index.vue'),
    //     children: [
    //         {
    //             path: '',
    //             name: 'LeafletList',
    //             component: () => import('@/views/leaflet/List.vue'),
    //         },
    //         {
    //             path: 'detail/:id',
    //             name: 'LeafletDetail',
    //             component: () => import('@/views/leaflet/Detail.vue'),
    //         },
    //     ]
    // }
]

const router = createRouter({
    history: createWebHashHistory('/'),
    routes,
    // hashbag: true,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    }
})

export default router

