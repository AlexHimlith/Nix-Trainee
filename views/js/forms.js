$(document).ready(function () {
    $('#form_registration').submit(function (e) {
        $(".error").remove();
        let valid = true;
        let nick = $('#nick').val();
        let email = $('#email').val();
        let pass1 = $('#pass1').val();
        let pass2 = $('#pass2').val();

        if (!nickValid(nick)) {
            valid = false;
        }
        if (!emailValid(email)) {
            valid = false;
        }
        if (!passValid(pass1, pass2)) {
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });

    $('#form_profile').submit(function (e) {
        $(".error").remove();
        let valid = true;
        let name = $('#name').val();
        let surname = $('#surname').val();
        let nick = $('#nick').val();
        let email = $('#email').val();
        let pass1 = $('#pass1').val();
        let pass2 = $('#pass2').val();
        let datebirth = $('#datebirth').val();
        let place = $('#place').val();

        if (name.length != 0) {
            if (!nameValid(name)) {
                valid = false;
            }
        }
        if (surname.length != 0) {
            if (!nameValid(surname)) {
                valid = false;
            }
        }
        if (!nickValid(nick)) {
            valid = false;
        }
        if (!emailValid(email)) {
            valid = false;
        }
        if (pass1.length != 0) {
            if (!passValid(pass1, pass2)) {
                valid = false;
            }
        }
        if (datebirth.length != 0) {
            if (!dateValid(datebirth)) {
                valid = false;
            }
        }
        if (place.length != 0) {
            if (!placeValid(place)) {
                valid = false;
            }
        }

        if (!valid) {
            e.preventDefault();
        }
    });

    function nameValid(name) {
        if (name.length>32) {
            $('#name').after('<span class="error">Name and surname length must be less than 32 characters</span>');
            return false;
        }
        else {
            let regExName = /^[A-Za-z']+$/;
            if (!regExName.test(name)) {
                $(".error").remove();
                $('#name').after('<span class="error">Name and surname can consist of English characters</span>');
                return false;
            }
        }
        return true;
    }

    function nickValid(nick) {
        if (nick.length<1) {
            $('#nick').after('<span class="error">This field is required</span>');
            return false;
        }
        else {
            if (nick.length>16) {
                $('#nick').after('<span class="error">Nick length must be less than 16 characters</span>');
                return false;
            }
            else {
                let regExNick = /^[A-Za-z0-9]+$/;
                if (!regExNick.test(nick)) {
                    $('#nick').after('<span class="error">Nickname can consist of English characters and numbers</span>');
                    return false;
                }
            }
        }
        return true;
    }

    function emailValid(email) {
        if (email.length<1) {
            $('#email').after('<span class="error">This field is required</span>');
            return false;
        }
        else {
            if (email.length>32) {
                $('#email').after('<span class="error">E-mail length must be less than 32 characters</span>');
                return false;
            }
            else {
                let regExMail = /^[A-Za-z0-9_.]+@[a-z.]+$/;
                if (!regExMail.test(email)) {
                    $('#email').after('<span class="error">Enter correct e-mail</span>');
                    return false;
                }
            }
        }
        return true;
    }

    function passValid(pass1, pass2) {
        if (pass1.length<6) {
            $('#pass1').after('<span class="error">Password length must be more than 6 characters</span>');
            return false;
        }
        else {
            if (pass1 !== pass2) {
                $('#pass2').after('<span class="error">Password mismatch</span>');
                return false;
            }
        }
        return true;
    }

    function dateValid(datebirth) {
        //let rexExDate = /^[0-3]{1}[0-9]{1}.[0-1]{1}[0-9]{1}.[0-9]{2,4}$/;
        let rexExDate = /^[0-9]{2,4}-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}$/;
        if (!rexExDate.test(datebirth)) {
            $('#datebirth').after('<span class="error">Enter the correct date</span>');
            return false;
        }
        return true;
    }

    function placeValid(place) {
        if (place.length>32) {
            $('#place').after('<span class="error">Place length must be less than 32 characters</span>');
            return false;
        }
        else {
            let regExPlace = /^[A-Za-z']+$/;
            if (!regExPlace.test(place)) {
                $('#place').after('<span class="error">Place can consist of English characters</span>');
                return false;
            }
        }
        return true;
    }
});