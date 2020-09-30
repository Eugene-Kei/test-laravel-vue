import Vue from 'vue'
import VueRouter from 'vue-router'
import Tasks from './components/Tasks'
import Statistics from './components/Statistics'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'tasks',
        component: Tasks,
        meta: { title: 'Задачи' }
    },
    {
        path: '/statistics',
        name: 'statistics',
        component: Statistics,
        meta: { title: 'Задачи' }
    },
]

const router = new VueRouter({
    routes
})

export default router
