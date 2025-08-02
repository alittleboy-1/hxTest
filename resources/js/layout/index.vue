<template>
  <el-container>
    <el-aside class="h-100">
      <sidebar />
    </el-aside>
    <el-container>
      <el-header></el-header>
      <el-main>
        <router-view />
      </el-main>
    </el-container>
  </el-container>
</template>

<script setup>
import Sidebar from './Sidebar.vue'
</script>

<style scoped>
.el-container {
  height: 100vh;
}


.el-container ul {
  height: 100%;
}
</style>
