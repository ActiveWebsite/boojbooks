import Vue from 'vue';
import Vuetify from 'vuetify';
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/dist/vuetify.min.css';

Vue.use(Vuetify, {
  customProperties: true,
  icons: {
    iconfont: 'mdi',
  },
});

export default new Vuetify();
