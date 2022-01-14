import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Zhu from '../components/Zhu'
import Onec from '../components/accountediting/AccountEditing'
import Twoc from '../components/twoc/Twoc'
import Threec from '../components/Threec/Threec'
import Haitu from '../components/Haitu'
import Maps from '../components/maps/maps'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: Zhu,
    redirect:'/hai',
    children:[
      {path:'/hai',components:{right:Haitu}},
      {path:'/onec',components:{left:Onec,right:Haitu}},
      {path:'/twoc',components:{left:Twoc,right:Haitu}},
      {path:'/threec',components:{left:Threec,right:Haitu}},
    ]
  },
  {
    path:'/maps',
    component:Maps
  }
]

const router = new VueRouter({
  routes
})

export default router
