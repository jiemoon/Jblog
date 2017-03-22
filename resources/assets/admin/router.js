import VueRouter from 'vue-router'
import NProgress from 'nprogress'//页面顶部进度条
import 'nprogress/nprogress.css'

NProgress.configure({ showSpinner: false });

const routes = [
    {
        path: '/login',
        component: require('./pages/Login'),
        hidden: true//不显示在导航中
    },
    {
        path: '/',
        name: '统计',
        component: require('./pages/Home'),
        children: [
            {
                path: '/',
                component: require('./pages/statics/Overview'),
                iconCls: 'el-icon-message',
                name: '概览',
                meta: { requireAuth: true },
            },
        ]
    },
    {
        path: '/',
        name: '配置',
        component: require('./pages/Home'),
        children: [
            {
                path: '/config',
                name: '站点配置',
                iconCls: 'el-icon-setting',
                component: require('./pages/config/SiteConfig'),
                meta: { requireAuth: true },
            }
        ]
    },
    {
        path: '/',
        name: '文章管理',
        component: require('./pages/Home'),
        children: [
            {
                path: '/article',
                name: '文章列表',
                iconCls: 'el-icon-document',
                component: require('./pages/article/List'),
                meta: { requireAuth: true },
            }
        ]
    },
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
