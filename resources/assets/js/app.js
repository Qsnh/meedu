require('./bootstrap');
window.Vue = require('vue');

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use(ElementUI);

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('meedu-pagination', require('./components/Pagination.vue'));
Vue.component('meedu-a', require('./components/A.vue'));
Vue.component('meedu-destroy-button', require('./components/DestroyButton.vue'));