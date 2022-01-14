import Vue from 'vue'
import App from './App.vue'
import router from './router'
import './plugins/element.js'
import './assets/css/ol.js'
import './assets/css/ol.css'
import './assets/css/style.css'
import './assets/css/font/iconfont.css'

import axios from 'axios'

Vue.config.productionTip = false
Vue.prototype.$http = axios;
new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
