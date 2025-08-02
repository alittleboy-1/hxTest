import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    }, server: {
        open: true,   //默认启动项目打开页面
        port: 5173,   //端口号
        host: "localhost", //主机名
        proxy: {
            '/api': {	//
                target: "0.0.0.0", // 目标地址
                ws: true,
                secure: false,
                changeOrigin: true,// 是否允许跨域代理
                pathRewrite: {
                    '^/api': '' // 重写路径
                }
            }
        }
    },


});
