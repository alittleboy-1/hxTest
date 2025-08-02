<template>
  <el-menu
    router
    :default-active="$route.path"
    background-color="#304156"
    text-color="#bfcbd9"
    active-text-color="#409EFF"
  >
    <sidebar-item 
      v-for="route in permissionRoutes" 
      :key="route.path" 
      :item="route"
    />
  </el-menu>
</template>

<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import SidebarItem from './SidebarItem.vue'

const router = useRouter()
const permissionRoutes = computed(() => {
  return router.options.routes.filter(route => !route.meta?.hidden)
})
</script>