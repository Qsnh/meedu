require('./bootstrap');
window.Vue = require('vue');

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import mavonEditor from 'mavon-editor';
import 'mavon-editor/dist/css/index.css';

Vue.use(ElementUI);
Vue.use(mavonEditor);

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('meedu-pagination', require('./components/Pagination.vue'));
Vue.component('meedu-a', require('./components/A.vue'));
Vue.component('meedu-destroy-button', require('./components/DestroyButton.vue'));
Vue.component('meedu-upload-image', require('./components/UploadImage.vue'));
Vue.component('meedu-markdown', require('./components/Markdown.vue'));
Vue.component('meedu-course', require('./components/Course.vue'));
Vue.component('meedu-video-upload', require('./components/VideoUpload.vue'));