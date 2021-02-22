/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');


import Vue from 'vue'
import draggable from 'vuedraggable'

import VueModal from '@kouts/vue-modal';
import '@kouts/vue-modal/dist/vue-modal.css';

import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
Vue.component('Modal', VueModal);

import 'bootstrap-vue/dist/bootstrap-vue.css' // Importing CSS Style
import 'bootstrap-vue/dist/bootstrap-vue-icons.min.css'


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue instance doesn't know about the ion-icon component. To tell Vue that this is an external component, you can set the following
Vue.config.ignoredElements = [/^ion-/];


//Components
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('library-list-component', require('./app/library/libraryListComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

