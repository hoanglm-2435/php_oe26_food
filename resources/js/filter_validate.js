$(function () {
    $('.sort-by').change(function () {
        $('#form-sort').submit();
    })
});
$(document).ready(function() {
    $('#password, #new-password').on('keyup', function () {
        var newPassword = $('#new-password').val();
        var password = $('#password').val();
        if (newPassword !== '' && password !== '') {
            if (newPassword == password) {
                $('#message-newpass').html('Do not duplicate the same password!').css('color', 'red');
            } else {
                $('#message-newpass').html('');
            }
        } else {
            $('#message-confirm').html('');
        }
    });
    $('#password, #new-password, #confirm-password').on('keyup', function () {
        var newPassword = $('#new-password').val();
        var confirmPassword = $('#confirm-password').val();
        if (confirmPassword !== '' && newPassword !== '') {
            if (newPassword == confirmPassword) {
                $('#message-confirm').html('Matching password.').css('color', 'green');
            } else {
                $('#message-confirm').html('Not Matching password!').css('color', 'red');
            }
        } else {
            $('#message-confirm').html('');
        }
    });
    $('#phone').on('keyup', function () {
        if (!$.isNumeric($('#phone').val())) {
            $('#message-phone').html('Phone is numeric!').css('color', 'red');
        } else {
            $('#message-phone').html('');
        }
    });
});
