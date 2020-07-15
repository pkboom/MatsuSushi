import Errors from '@/Utils/Errors'
import { InertiaApp } from '@inertiajs/inertia-vue'
import PortalVue from 'portal-vue'
import Route from '../../vendor/tightenco/ziggy/src/js/route.js'
import vClickOutside from 'v-click-outside'
import Vue from 'vue'
import _ from 'lodash'
import './echo'

Vue.config.productionTip = false

Vue.use(InertiaApp)
Vue.use(PortalVue)
Vue.use(vClickOutside)
Vue.prototype.$route = (...args) => Route(...args).url()
Vue.prototype._ = _

const app = document.getElementById('app')
const pages = require.context('./', true, /\.vue$/i)
const shared = require.context('./Shared', true, /\.vue$/i)
shared.keys().map(key =>
  Vue.component(
    key
      .split('/')
      .pop()
      .split('.')[0],
    shared(key).default
  )
)

new Vue({
  render: h =>
    h(InertiaApp, {
      props: {
        initialPage: JSON.parse(app.dataset.page),
        resolveComponent: page => pages(`./Admin/${page}.vue`).default,
        transformProps: props => {
          return {
            ...props,
            errors: new Errors(props.errors),
          }
        },
      },
    }),
}).$mount(app)
