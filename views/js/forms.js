$(document).ready(function () {
    $('#form_registration').submit(function (e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });

    function validateForm() {
        $(".error").remove();
        let valid = true;
        let nick = $('#nick').val();
        let email = $('#email').val();
        let pass1 = $('#pass1').val();
        let pass2 = $('#pass2').val();
        if (nick.length<1) {
            $('#nick').after('<span class="error">This field is required</span>');
            valid = false;
        }
        else {
            if (nick.length>16) {
                $('#nick').after('<span class="error">Nick length must be less than 16 characters</span>');
                valid = false;
            }
            else {
                let regExNick = /^[A-Za-z0-9]+$/;
                if (!regExNick.test(nick)) {
                    $('#nick').after('<span class="error">Nickname can consist of English characters and numbers</span>');
                    valid = false;
                }
            }
        }
        if (email.length<1) {
            $('#email').after('<span class="error">This field is required</span>');
            valid = false;
        }
        else {
            if (email.length>32) {
                $('#email').after('<span class="error">E-mail length must be less than 32 characters</span>');
                valid = false;
            }
            else {
                    let regExMail = /^[A-Za-z0-9_.]+@[a-z]+.[a-z]{1,3}$/;
                    if (!regExMail.test(email)) {
                        $('#email').after('<span class="error">Enter correct e-mail</span>');
                        valid = false;
                    }
            }
        }
        if (pass1.length<6) {
            $('#pass1').after('<span class="error">Password length must be more than 6 characters</span>');
            valid = false;
        }
        else {
            if (pass1 !== pass2) {
                $('#pass2').after('<span class="error">Password mismatch</span>');
                valid = false;
            }
        }
        return valid;
    }
});