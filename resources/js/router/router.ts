import { createRouter, createWebHistory, createWebHashHistory } from 'vue-router'


import Layout from '../layout/index.vue';
// import File1 from './components/File1.vue'
import list from '../components/list.vue'
import userList from '../components/userList.vue'
import login from '../components/login.vue'
import ExampleComponent from '../components/ExampleComponent.vue'
// const routes = [
//     {
//         path: '/list',
//         component: list,
//         name: 'list', // 添加路由名称方便跳转
//         meta: {
//             title: '列表',
//             isShow: true, // 控制当前项是否在菜单栏中渲染出来，比如你写了 login 页面的路由，但是并不希望 login在menu菜单中渲染出来，即可设为false
//         }
//     },

//     {
//         path: '/login',
//         component: login,
//         meta: { title: '登录' }
//     },
//     {

//         path: '/layout',
//         name: 'layoutIndex',
//         component: () => import('@/layout/index.vue'),
//         children: [
//             {
//                 path: '/home',
//                 name: 'homeIndex',
//                 component: () => list,
//                 meta: {
//                     isShow: true, // 控制当前项是否在菜单栏中渲染出来，比如你写了 login 页面的路由，但是并不希望 login在menu菜单中渲染出来，即可设为false
//                     title: '首页', // menu菜单项的名称，没啥好说的
//                     icon: 'menu-home' // menu菜单项的图标，我此处是与封装好的 svg 组件结合使用的
//                 }
//             },

//         ]
//     },

// ]



const routes = [
  {
    path: '/',
    component: Layout,
    redirect: '/dashboard', // 修正重定向路径
    meta: { title: "首页", icon: "", hidden: false },
    children: [
      {
        path: 'dashboard',
        component: ExampleComponent, // 使用导入的组件变量
        meta: { title: '测试页面', icon: 'Document', hidden: false }
      },
      {
        path: 'list',
        component: list,
        meta: { title: '客户列表', icon: 'Document', hidden: false }
      }
      // {
      //   path: 'userList',
      //   component: list,
      //   meta: { title: '用户列表', icon: 'Document', hidden: false }
      // }
    ]
  },
  {
    path: '/login',
    component: login,
    meta: { hidden: false, icon: 'Document' } // 隐藏登录页菜单
  }
]





const router = createRouter({
  // history: createWebHistory(),
  history: createWebHashHistory(),
  routes,
})

export default router;
