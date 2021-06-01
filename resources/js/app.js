require('./bootstrap');

window.Vue = require('vue/dist/vue');
window.Swal = require('sweetalert2');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

window.catchError = function (excp) {
    var errors = excp.response.data.errors;
    var message = '';
    console.log(excp.response.status);
    $.each(errors, function (key, idx) {
        message += '<strong>' + key + '</strong> <br>'
        $.each(idx, function (key2, idx2) {
            message += '* ' + idx2 + '<br>'
        });
    });
    if (excp.response.status == 403) {
        Swal.fire({
            icon: 'error',
            title: 'Unathorized Action',
            html: excp.response.statusText,
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Please try again.',
            html: message,
        });
    }
};

Vue.component('booking-page', require('./components/booking').default);
Vue.component('booking-confirm', require('./components/confirmBooking').default);
