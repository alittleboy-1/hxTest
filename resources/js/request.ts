import axios from 'axios'
import { ElMessage } from 'element-plus'
import type { InternalAxiosRequestConfig, AxiosResponse } from 'axios'

const service = axios.create({
    baseURL: "http://localhost:8085" || '/api',
    timeout: 5000
})

// 请求拦截器
service.interceptors.request.use(
    (config: InternalAxiosRequestConfig) => {
        // 此处可添加token等全局请求头
        const token = localStorage.getItem('token')
        console.log("token",token);
        if (token) {
            config.headers.token = `${token}`
        }
        return config
    },
    (error) => {
        return Promise.reject(error)
    }
)

// 响应拦截器
service.interceptors.response.use(
    (response: AxiosResponse) => {
        const res = response.data
        if (response.status !== 200) {
            ElMessage.error(res.message || '请求失败')
            return Promise.reject(new Error(res.message || 'Error'))
        }
        return res
    },
    (error) => {
        // 处理401未授权等状态码
        if (error.response?.status === 401) {
            // 这里可以跳转到登录页
            window.location.href = '/login'
        }
        ElMessage.error(error.message || '服务器错误')
        return Promise.reject(error)
    }
)

export default service

// 封装通用请求方法
export const http = {
    get<T = any>(url: string, config?: InternalAxiosRequestConfig): Promise<T> {
        return service.get(url, config)
    },

    post<T = any>(url: string, data?: object, config?: InternalAxiosRequestConfig): Promise<T> {
        return service.post(url, data, config)
    },

    put<T = any>(url: string, data?: object, config?: InternalAxiosRequestConfig): Promise<T> {
        return service.put(url, data, config)
    },

    delete<T = any>(url: string, config?: InternalAxiosRequestConfig): Promise<T> {
        return service.delete(url, config)
    }
}