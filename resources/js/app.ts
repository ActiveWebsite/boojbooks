require('./bootstrap');

import { Component, Prop, Vue } from 'vue-property-decorator';
import vuetify from './plugins/vuetify';
import router from './router';
import App from './components/App';

const app = new Vue({
  router,
  vuetify,
  render: h => h(App),
}).$mount('#main');
