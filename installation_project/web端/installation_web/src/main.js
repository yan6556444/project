import Vue from 'vue'
import App from './App.vue'
import router from './router'
import './plugins/element.js'
import './assets/css/ol.js'
import './assets/css/ol.css'
import './assets/css/style.css'
import './assets/css/font/iconfont.css'
import Globals from './assets/js/global.js'

import axios from 'axios'

Vue.config.productionTip = false
Vue.prototype.$http = axios;

Vue.prototype.$appsrc=Globals;

new Vue({
  router,
  data: function(){
          return {
              URL: 'http://localhost:9092/online_chart/index.php',
          }
      },
  render: h => h(App)
}).$mount('#app')
