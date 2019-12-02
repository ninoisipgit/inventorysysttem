
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// import 'datatables.net/js/jquery.dataTables.js';

import 'datatables.net/js/jquery.dataTables.js';

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

import CategoryComponent from './components/category.vue';
Vue.component('category', CategoryComponent);

import SupplierComponent from './components/supplier.vue';
Vue.component('supplier', SupplierComponent);

import ProductComponent from './components/product.vue';
Vue.component('product', ProductComponent);


import PriceReport from './components/brandpricereport.vue';
Vue.component('pricereport', PriceReport);

import Dashboard from './components/dashboard.vue';
Vue.component('dashboard', Dashboard);


const app = new Vue({
    el: '#app'
});
