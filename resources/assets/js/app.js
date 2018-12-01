require('./bootstrap');
window.Vue = require('vue');

import mavonEditor from 'mavon-editor';
import 'mavon-editor/dist/css/index.css';

Vue.use(mavonEditor);

Vue.component('meedu-destroy-button', require('./components/DestroyButton.vue'));
// Vue.component('meedu-upload-image', require('./components/UploadImage.vue'));
Vue.component('meedu-markdown', require('./components/Markdown.vue'));
Vue.component('meedu-course', require('./components/Course.vue'));
Vue.component('meedu-video-upload', require('./components/VideoUpload.vue'));