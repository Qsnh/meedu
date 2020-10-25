import Swal from 'sweetalert2';
import Player from 'xgplayer';
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
            marquee.style['right'] = randomNumber(0, width) + 'px';
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
HlsJsPlayer.install('marquee', marquee);

window._ = require('lodash');

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

window.flashSuccess = function (message) {
    Swal.fire('成功', message, 'success');
};
window.flashWarning = function (message) {
    Swal.fire('警告', message, 'warning');
};
window.flashError = function (message) {
    Swal.fire('失败', message, 'error');
};

window.Player = Player;
window.HlsJsPlayer = HlsJsPlayer;