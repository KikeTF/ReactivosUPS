/**
 * Created by Neptali Torres F on 28/07/2016.
 */

function btnLogout_onClick() {
    $.ajax({
        type: 'GET',
        url: 'http://localhost:8000/auth/logout',
        async: true,
        cache: false,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        error: function (e) {
            console.log(e);
        },
        success: function () {
            window.location.replace("http://localhost:8000/auth/login");
            console.log("Logout OK!!!");
        }
    });
}

jQuery(function ($) {
    $('#btnLogout').click(btnLogout_onClick);
});
