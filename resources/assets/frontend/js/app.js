require('./bootstrap');
window.Vue = require('vue');

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import mavonEditor from 'mavon-editor';
import 'mavon-editor/dist/css/index.css';


Vue.use(ElementUI);
Vue.use(mavonEditor);