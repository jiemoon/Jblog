require('../js/bootstrap');

import Element from 'element-ui';
Vue.use(Element)

import App from './App.vue';

const app = new Vue({
    render: h => h(App)
}).$mount('#app')
