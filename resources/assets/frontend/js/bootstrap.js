import Swal from 'sweetalert2';

window.$ = require('jquery');

window.flashSuccess = function (message) {
    Swal.fire('Success', message, 'success');
};
window.flashWarning = function (message) {
    Swal.fire('Warning', message, 'warning');
};
window.flashError = function (message) {
    Swal.fire('Fail', message, 'error');
};