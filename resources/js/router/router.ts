import { createRouter, createWebHistory, createWebHashHistory } from 'vue-router'
// import File1 from './components/File1.vue'
import list from '../components/list.vue'
import login from '../components/login.vue'
const routes = [
    {
        path: '/list',
        component: list,
        name: 'list'       // 添加路由名称方便跳转
    },

    {
        path: '/login',
        component: login
    },

]

const router = createRouter({
    // history: createWebHistory(),
    history: createWebHashHistory(),
    routes,
})

export default router;
