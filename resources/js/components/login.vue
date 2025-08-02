<template>
    <div class="d-flex h-100 w-100" style="background-image: url('/img/back.webp'); background-size: cover;">
        <div class="login_body w-100 h-100  d-flex-column">
            <!-- " -->
            <el-form ref="forms" class="login_form m-t-2">
                <el-form-item>
                    <div class="w-100 text-center"
                        style="text-align: center;font-size: 25px;font-weight: 700;padding: 15px;color: #fff;">
                        系统登录
                    </div>
                </el-form-item>
                <el-form-item>

                    <el-input prefix-icon="el-icon-lock" v-model="data.username" placeholder="账号"></el-input>
                </el-form-item>
                <el-form-item>

                    <el-input type="password" prefix-icon="el-icon-lock" v-model="data.password" show-password
                        placeholder="密码"></el-input>

                </el-form-item>
                <el-form-item>
                    <el-button style="width:100%" size="medium" type="primary" @click="login">登 录</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { reactive, onMounted } from 'vue'
// do not use same name with ref
import { http } from '../request'
import { ref } from 'vue'
import { ElMessage } from 'element-plus'

import md5 from 'md5' // 添加md5导入
import { useRouter } from 'vue-router'
const data = reactive({
    username: 'admin',
    password: '123456'
})
const router = useRouter()
const login = async () => {
    if (data.username == "" || data.password == "") {
        ElMessage.error("请填写用户名密码");
        return
    }
    console.log(data.username, data.password)
    const res = await http.post('/login', {
        username: data.username,
        password: md5(data.password)
    });
    if (res.code === 200) {
        localStorage.setItem('token', res.data.token)
        localStorage.setItem('user', JSON.stringify(res.data.user))
        ElMessage.success("登录成功")
        router.push({ path: '/list' })
    } else {
        ElMessage.error(res.msg)
    }
}

</script>


<style scoped>
.login_form {
    width: 400px;
    /* 固定表单宽度 */
    padding: 20px;
    /* 添加内边距 */
    background: hsla(0, 0%, 100%, .5);
    /* 白色背景 */
    border-radius: 8px;
    /* 圆角 */
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
    /* 添加阴影 */


}

.login_body {
    display: flex;
    justify-content: center;
    /* 水平居中 */
    align-items: center;
    /* 垂直居中 */
    min-height: 100vh;
    /* 撑满整个视口高度 */

}
</style>
