require('./bootstrap');

import 'normalize.css'
import 'font-awesome/scss/font-awesome.scss'
import Element from 'element-ui';
import App from './App.vue';
import router from './router';

Vue.use(VueRouter)
Vue.use(Element)
const app = new Vue({
    router: router,
    render: h => h(App)
}).$mount('#app')
