<template>
  <!-- 添加meta存在性检查 -->
  <el-sub-menu v-if="hasChildren" :index="item.path">
    <template #title>
      <el-icon v-if="item.meta && item.meta.icon">
        <component :is="item.meta.icon" />
      </el-icon>
      <span>{{ item.meta?.title }}</span>
    </template>
    <sidebar-item v-for="child in item.children" :key="child.path" :item="child" />
  </el-sub-menu>

  <el-menu-item v-else :index="item.path">
    <el-icon v-if="item.meta && item.meta.icon">
      <component :is="item.meta.icon" />
    </el-icon>
    <template #title>{{ item.meta?.title }}</template>
  </el-menu-item>
</template>

<script setup>
import { computed } from 'vue' // 添加缺失的computed导入

const props = defineProps({
  item: {
    type: Object,
    required: true
  }
})

// 修正后的计算属性
const hasChildren = computed(() => {
  return props.item.children && props.item.children.length > 0
})
</script>