import swal from 'sweetalert';

window.flashSuccess = function (message) {
    swal('成功', message, 'success');
};
window.flashWarning = function (message) {
    swal('警告', message, 'warning');
};
window.flashError = function (message) {
    swal('失败', message, 'error');
};