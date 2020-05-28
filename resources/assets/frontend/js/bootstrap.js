import swal from 'sweetalert';
import Player from 'xgplayer';
import 'xgplayer-mp4';
import HlsJsPlayer from 'xgplayer-hls.js';

let marquee = function () {
    let player = this;
    let util = Player.util;
    let root = player.root;
    let randomNumber = (n, m) => {
        return Math.floor(Math.random() * (m - n + 1) + n);
    };
    if (typeof player.config.marquee !== 'undefined' && typeof player.config.marquee.value !== 'undefined') {

        let randomMarquee = () => {
            let str = Math.random().toString(36).slice(-6);
            let marquee = util.createDom('xg-' + str, player.config.marquee.value, {}, '');
            marquee.style['color'] = '#00000';
            marquee.style['position'] = 'absolute';
            marquee.style['z-index'] = randomNumber(100, 1111);
            let height = root.offsetHeight;
            height = height > 50 ? (height - 30) : height;
            let width = root.offsetWidth;
            width = width > 50 ? (width - 30) : width;
            marquee.style['top'] = randomNumber(0, height) + 'px';
            marquee.style['right'] = randomNumber(0, height) + 'px';
            root.appendChild(marquee);
            setTimeout(() => {
                marquee.remove();
            }, 2000);
        };

        randomMarquee();
        setInterval(() => {
            randomMarquee();
        }, 2100);
    }
}
Player.install('marquee', marquee);

window._ = require('lodash');
window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

window.flashSuccess = function (message) {
    swal('成功', message, 'success');
};
window.flashWarning = function (message) {
    swal('警告', message, 'warning');
};
window.flashError = function (message) {
    swal('失败', message, 'error');
};

window.Player = Player;
window.HlsJsPlayer = HlsJsPlayer;