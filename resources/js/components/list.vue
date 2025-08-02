<template>
  <div class="d-flex h-100 w-100 d-flex-column">
    <!-- <el-button type="primary">Primary</el-button> -->
    <div>
      <el-button class="m-4" type="primary" @click="addVisible = true">新增</el-button>
    </div>
    <div class="d-flex h-100 w-100  ">
      <div class="flex-1 m-4">
        <el-table ref="multipleTable" :data="userTable" border style="width: 98%; " :height="500">

          <el-table-column label="序号" width="55" align="center">
            <template #default="scope">
              {{ scope.$index + 1 }}
            </template>
          </el-table-column>
          <el-table-column prop="id" label="id" width="120" align="center">
          </el-table-column>
          <el-table-column prop="first_name" label="first_name" width="120" align="center">
          </el-table-column>
          <el-table-column prop="last_name" label="last_name" align="center">
          </el-table-column>
          <el-table-column prop="age" label="age" align="center">
          </el-table-column>
          <el-table-column prop="email" label="email" align="center">
          </el-table-column>
          <el-table-column prop="dob" label="dob" align="center">
          </el-table-column>
          <el-table-column prop="creation_date" label="creation_date" align="center">
          </el-table-column>
          <el-table-column prop="backNum" label="操作" align="center" width="150">
            <template #default="scope">
              <el-link class="m-r-4" type="primary" @click="editPre(scope.row)">编辑</el-link>
              <!-- <el-link class="m-l-2" type="primary" @click="delPre(scope.row)">删除</el-link> -->
              <el-popover :visible="visibleDle[scope.row.id]" placement="top" :width="180">
                <p>Are you sure to delete this?</p>
                <div style="text-align: right; margin: 0">
                  <el-button size="small" text @click="visibleDle[scope.row.id] = false">cancel</el-button>
                  <el-button type="danger" size="small" @click="deleteUser(scope.row)">Yes!
                  </el-button>
                </div>
                <template #reference>
                  <el-link type="primary" @click="visibleDle[scope.row.id] = true">删除</el-link>
                </template>
              </el-popover>
            </template>
          </el-table-column>
        </el-table>
        <div class="d-flex">
          <!-- <el-button @click="Previous">上一页</el-button>
            <el-button class="m-r-4" @click="Next" type="primary">下一页</el-button> -->

          <!-- <el-pagination v-model:current-page="currentPage" :page-size="5" size="'default'"
              layout="total, prev, pager, next" :total="total" @size-change="handleSizeChange"
              @current-change="handleCurrentChange" /> -->
          <div class="flex-1 "></div>
          <div class="pagination-wrapper m-r-4">
            <el-button v-for="(item, index) in links" :key="index" :disabled="!item.url"
              @click="handlePageChange(item.url)" :class="{ 'active': item.active }">
              <span>{{ item.label }}</span>
            </el-button>
          </div>


        </div>
      </div>
    </div>

    <el-dialog v-model="dialogVisible" title="编辑" width="500" draggable>
      <el-form :model="current" label-width="auto" style="height: 50%; height: 50%;" :rules="rules">
        <el-form-item prop="first_name" label="first_name">
          <el-input v-model="current.first_name" />
        </el-form-item>
        <el-form-item label="last_name">
          <el-input v-model="current.last_name" />
        </el-form-item>
        <el-form-item prop="age" label="age">
          <el-input v-model="current.age" />
        </el-form-item>
        <el-form-item prop="email" label="email">
          <el-input v-model="current.email" />
        </el-form-item>
      </el-form>

      <template #footer>
        <div class="dialog-footer">
          <el-button @click="dialogVisible = false">取消</el-button>
          <el-button type="primary" @click="editOk">
            修改
          </el-button>
        </div>
      </template>
    </el-dialog>

    <el-dialog v-model="addVisible" title="Tips" width="500" draggable>
      <div class="flex-1 m-l-2">
        <el-form :model="form" label-width="auto" style="height: 40%; height: 50%;" :rules="rules">
          <el-form-item prop="first_name" label="first_name">
            <el-input v-model="form.first_name" />
          </el-form-item>
          <el-form-item label="last_name">
            <el-input v-model="form.last_name" />
          </el-form-item>
          <el-form-item prop="age" label="age">
            <el-input v-model="form.age" />
          </el-form-item>
          <el-form-item prop="email" label="email">
            <el-input v-model="form.email" />
          </el-form-item>

        </el-form>
        <div class="text-right">
          <el-button @click="addVisible = false">取消</el-button>
          <el-button type="primary" @click="onSubmit">添加</el-button>
        </div>
      </div>
    </el-dialog>



  </div>
</template>

<script setup lang="ts">

import { reactive, onMounted } from 'vue'
// do not use same name with ref
import { http } from '../request'
import { ref } from 'vue'
import { ElMessage } from 'element-plus'

let currentPage = ref(0);
let total = ref(10);
let links = ref([]);

let dialogVisible = ref(false);
let addVisible = ref(false);
let visibleDle = ref({});
let current = reactive({});

const validateAge = (rule: any, value: any, callback: any) => {
  if (!/^\d+$/.test(value)) {  // 使用正则表达式校验数字
    callback(new Error("年龄必须为数字"))
  } else {
    callback()
  }
}
const validateFirst = (rule: any, value: any, callback: any) => {
  if (value.length <= 1) {
    callback(new Error("用户名长度必须大于1位"))
  } else {
    callback()
  }
}
const validateEmail = (rule: any, value: any, callback: any) => {
  if (!/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(value)) {
    callback(new Error("请输入有效的邮箱地址"))
  } else {
    callback()
  }
}

let userTable = reactive([]);

let rules = reactive({
  first_name: [
    { required: true, validator: validateFirst, trigger: "change" },
  ],
  age: [
    { required: true, validator: validateAge, trigger: "change" },
  ],
  email: [
    { required: true, message: '邮箱不能为空', trigger: 'blur' },
    { validator: validateEmail, trigger: 'blur' }
  ]
})


//获取列表

let PreviousUrl = '';
let nextUrl = '';
const getList = () => {
  http.get('/list').then(res => {
    // 处理响应
    if (res.code === 200) {
      userTable.splice(0, userTable.length, ...res.data.data);
      PreviousUrl = res.data.prev_page_url;
      nextUrl = res.data.next_page_url;
      total = res.data.total;

      // 问题点：直接修改数组元素无法触发响应式更新
      links.value = res.data.links.map(s => ({
        ...s,
        label: s.label.replace(/&laquo;/g, '«').replace(/&raquo;/g, '»')
      }));
    }
  })
}
// 分页处理方法
const handlePageChange = (url: string) => {
  if (!url) return;
  console.log("url", url)
  http.get(url).then(res => {
    if (res.code === 200) {
      // links = res.data.links
      userTable.splice(0, userTable.length, ...res.data.data);
      PreviousUrl = res.data.prev_page_url;
      nextUrl = res.data.next_page_url;
      total = res.data.total;
      // 问题点：直接修改数组元素无法触发响应式更新
      links.value = res.data.links.map(s => ({
        ...s,
        label: s.label.replace(/&laquo;/g, '«').replace(/&raquo;/g, '»')
      }));
    }
  });
};

const handleSizeChange = (val) => {
  console.log(val)
}
const handleCurrentChange = (val) => {
  console.log(val)
}


const Previous = () => {
  if (PreviousUrl) {
    http.get(PreviousUrl).then(res => {
      // 处理响应
      if (res.code === 200) {
        // userTable = res.data.data;
        userTable.splice(0, userTable.length, ...res.data.data);
      }
    })
  }
}
const Next = () => {
  if (nextUrl) {
    http.get(nextUrl).then(res => {
      // 处理响应
      if (res.code === 200) {
        // userTable = res.data.data;
        userTable.splice(0, userTable.length, ...res.data.data);
      }
    });
  }
}

const form = reactive({
  first_name: '',
  last_name: '',
  age: '',
  email: '',
});

const onSubmit = () => {
  http.post('/create', form).then(res => {
    if (res.code === 200) {
      ElMessage.success("添加成功");
      addVisible.value = false;
      getList();
    }
  });
}
const editPre = (val) => {
  console.log(val)
  current = reactive({ ...val })
  dialogVisible.value = true
}
const editOk = () => {
  http.put('/update', current).then(res => {
    if (res.code == 200) {
      const index = userTable.findIndex(item => item.id === current.id)
      if (index > -1) {
        Object.assign(userTable[index], current)
      }
      dialogVisible.value = false;
      ElMessage.success('更新成功')
    }
  });
}

const deleteUser = (val) => {
  console.log(val)
  http.delete('/delete?id=' + val.id)
    .then(res => {
      if (res.code == 200) {
        ElMessage({
          message: '删除成功.',
          type: 'success',
        });
        visibleDle.value[val.id] = false; // 关闭对应弹窗
        getList(); // 刷新列表
      }
    }),
    err => {
      ElMessage({
        message: '删除失败.',
        type: 'error',
      });
    }
    ;
}

onMounted(() => {
  console.log('mounted: 实例已挂载');
  getList();
});



</script>

<style scoped>
.pagination-wrapper {
  margin-top: 20px;
  display: flex;
  gap: 5px;
}

.active {
  background-color: #409eff;
  color: white;
}
</style>
