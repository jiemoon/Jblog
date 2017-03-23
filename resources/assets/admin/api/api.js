import axios from 'axios';
import router from '../router'
import Promise from 'promise';

// axios 配置
axios.defaults.timeout = 5000;
let base = 'http://jblog.app/api/admin';
// axios.defaults.baseURL = 'https://api.github.com';

// http request 拦截器
axios.interceptors.request.use(
    config => {
        if (sessionStorage.getItem('token')) {
            config.headers.Authorization = 'Bearer ' + sessionStorage.getItem('token');
        }
        return config;
    },
    err => {
        return Promise.reject(err);
    }
);

// http response 拦截器
axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (error.response) {
            switch (error.response.status) {
                case 401:
                    // 401 清除token信息并跳转到登录页面
                    sessionStorage.setItem('token', null)
                    if(router.currentRoute.fullPath == '/login') {
                        return error.response;
                    }
                    router.push({
                        path: '/login',
                        query: {redirect: router.currentRoute.fullPath}
                    })
                case 422:
                    return error.response;
            }
        }
        // console.log(JSON.stringify(error));//console : Error: Request failed with status code 402
        // console.log(Promise.reject(error.response));
        // console.log(error.response);
        return Promise.reject(error.response.data)
    }
);

export const requestLogin = params => { return axios.post(`${base}/login`, params).then(res => res.data); };

export const addArticle = params => { return axios.post(`${base}/articles`, params); };

export const getArticleList = params => { return axios.get(`${base}/articles`, { params: params }); };

export const getUserListPage = params => { return axios.get(`${base}/user/listpage`, { params: params }); };

export const removeUser = params => { return axios.get(`${base}/user/remove`, { params: params }); };

export const editUser = params => { return axios.get(`${base}/user/edit`, { params: params }); };

