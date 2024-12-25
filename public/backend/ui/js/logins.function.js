$(document).ready(function() {
    $('#showpassword').click(function() {
        var passwordInput = $('#pw');
        var confirmPasswordInput = $('#psw');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            confirmPasswordInput.attr('type', 'text');
        } else {
            passwordInput.attr('type', 'password');
            confirmPasswordInput.attr('type', 'password');
        }
    });
});