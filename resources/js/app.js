
require('./bootstrap');

window.Vue = require('vue').default;
import Vue from 'vue'
import VueRouter from 'vue-router'
import Swal from 'sweetalert2'
import Loading from 'vue-loading-overlay';
import VueProgressBar from 'vue-progressbar'
import { Button, HasError, AlertError } from 'vform/src/components/bootstrap5'

Vue.use(VueProgressBar, options)
const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
      speed: '0.2s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'left',
    inverse: false
  }
  Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.use(VueRouter)
Vue.use(Loading,{color: '#bffaf3',});
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
window.Swal=Swal;
window.Toast=Toast;
import CreateInvoiceComponent from './components/CreateInvoiceComponent';
import GetInvoiceComponent from './components/GetInvoiceComponent';
Vue.component('pagination', require('laravel-vue-pagination'));
const routes=[
    { path: '/', component:CreateInvoiceComponent},
    { path: '/getInvoice/:id', component: GetInvoiceComponent }
  ]
  export const router = new VueRouter({
    base: '/',
    mode: 'history',
    routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
  });
 const app = new Vue({
    el: '#app',
    router
});
