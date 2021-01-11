// @ts-nocheck
import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
  {
    path: '/home',
    name: 'Home',
    meta: { dashboard: false },
    component: () => import(/* webpackChunkName: "Home" */ '../components/Home.vue'),
  },
  {
    path: '/book-list',
    name: 'BookList',
    meta: { dashboard: false },
    component: () => import(/* webpackChunkName: "BookList" */ '../components/BookList.vue'),
  },
];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
});

export default router;
