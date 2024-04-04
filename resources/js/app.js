import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import VModal from 'vue-js-modal'
Vue.use(VModal)

import vSelect from "vue-select";
Vue.component("v-select", vSelect);

import '~/plugins'
import '~/components'

Vue.config.productionTip = false

import Swal from 'sweetalert2/dist/sweetalert2.js'
Vue.prototype.$swal = Swal

import axios from 'axios'
Vue.prototype.$https = axios

import moment from 'moment'
import 'moment/dist/locale/nl';
moment.locale('nl');
Vue.prototype.moment = moment

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
