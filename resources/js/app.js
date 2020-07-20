require('./bootstrap.js');
require('materialize-css/dist/js/materialize.js');
window.Vue = require('vue');

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import routes from './routes'
const router = new VueRouter({
    routes,
    mode: 'history'
})
router.beforeEach((to, from, next) => {
    if(to.meta.auth){
        console.log(localStorage.getItem('user'))
        localStorage.getItem('user') ? next() : next('/login')
    } else {
        next()
    }
})

Vue.component('spinner', require('vue-simple-spinner'))

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import App from './App.vue'
new Vue({
    router,
    render: h => h(App)
}).$mount('#app')