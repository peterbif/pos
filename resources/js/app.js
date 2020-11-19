require('./bootstrap');

//window.Vue = require('vue');

import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

import { MdButton, MdContent, MdTabs } from 'vue-material/dist/components'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'

Vue.use(MdButton)
Vue.use(MdContent)
Vue.use(MdTabs)




// Install BootstrapVue
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);




//registering charge component globally
Vue.component('charge-component',
    () =>
    import ('./components/Charge.vue'),
);

const app = new Vue({
    el: '#app',

});