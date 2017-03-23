import VueRouter from 'vue-router'

import NotFound from './views/404.vue'

import NProgress from 'nprogress'//页面顶部进度条
import 'nprogress/nprogress.css'

NProgress.configure({ showSpinner: false });

const routes = [
    {
        path: '/login',
        component: require('./views/Login'),
        name: '',
        hidden: true//不显示在导航中
    },
    {
        path: '/404',
        component: NotFound,
        name: '',
        hidden: true
    },
    {
        path: '/',
        name: '统计',
        component: require('./views/Home'),
        children: [
            {
                path: '/',
                component: require('./views/statics/Overview'),
                iconCls: 'el-icon-message',
                name: '概览',
                meta: { requireAuth: true },
            },
        ]
    },
    {
        path: '/',
        name: '配置',
        component: require('./views/Home'),
        children: [
            {
                path: '/config',
                name: '站点配置',
                iconCls: 'el-icon-setting',
                component: require('./views/config/SiteConfig'),
                meta: { requireAuth: true },
            }
        ]
    },
    {
        path: '/',
        name: '文章管理',
        component: require('./views/Home'),
        children: [
            {
                path: '/article/add',
                name: '写文章',
                iconCls: 'el-icon-edit',
                component: require('./views/article/Add'),
                meta: { requireAuth: true },
            },
            {
                path: '/article',
                name: '文章列表',
                iconCls: 'el-icon-document',
                component: require('./views/article/List'),
                meta: { requireAuth: true },
            },
            {
                path: '/article/draft',
                name: '草稿箱',
                iconCls: 'el-icon-document',
                component: require('./views/article/Draft'),
                meta: { requireAuth: true },
            }
        ]
    },
    {
        path: '*',
        hidden: true,
        redirect: { path: '/404' }
    }
];

const router = new VueRouter({
    mode: 'hash',
    base: __dirname,
    routes
});

router.beforeEach((to, from, next) => {
    NProgress.start();
    if (to.matched.some(r => r.meta.requireAuth)) {
        if (sessionStorage.getItem('token')) {
            next();
        } else {
            next({
                path: '/login',
                query: {redirect: to.fullPath}
            });
        }
    } else {
        next();
    }
})

router.afterEach(transition => {
    NProgress.done();
});

export default router;
