import Swal from 'sweetalert2';

window.flashSuccess = function (message) {
    Swal.fire('成功', message, 'success');
};
window.flashWarning = function (message) {
    Swal.fire('警告', message, 'warning');
};
window.flashError = function (message) {
    Swal.fire('失败', message, 'error');
};