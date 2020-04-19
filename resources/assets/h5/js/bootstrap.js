import swal from 'sweetalert';

import Player from 'xgplayer';
import 'xgplayer-mp4';
import HlsJsPlayer from 'xgplayer-hls.js';

window.Player = Player;
window.HlsJsPlayer = HlsJsPlayer;

window.flashSuccess = function (message) {
    swal('成功', message, 'success');
};
window.flashWarning = function (message) {
    swal('警告', message, 'warning');
};
window.flashError = function (message) {
    swal('失败', message, 'error');
};