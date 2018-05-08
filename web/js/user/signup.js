function validation_form_signup($form) {
    var result = true;
    var $login = $form.find(".js-login");
    var $email = $form.find(".js-email");
    var $repeat = $form.find(".js-repeat");
    var $pass = $form.find(".js-pass");
    var $term = $form.find(".js-term");
    $login.removeClass("error");
    var error = validation.username($login.val());
    if (error) {
        $login.addClass("error");
        result = false;
        $('html, body').animate({
            scrollTop: $login.offset().top - 100
        }, 800);
    } else {
        $email.removeClass("error");
        error = validation.email($email.val());
        if (error) {
            $email.addClass("error");
            result = false;
            $('html, body').animate({
                scrollTop: $email.offset().top - 100
            }, 800);
        } else {
            $pass.removeClass("error");
            error = validation.password($pass.val());
            if (error) {
                $pass.addClass("error");
                result = false;
                $('html, body').animate({
                    scrollTop: $pass.offset().top - 100
                }, 800);
            } else {
                $pass.removeClass("error");
                $repeat.removeClass("error");
                error = validation.confirmPassword($pass.val(), $repeat.val());
                if (error) {
                    $pass.addClass("error");
                    $repeat.addClass("error");
                    result = false;
                } else {
                    if ($term.prop("checked") != true) {
                        result = false;
                        error = "invalid_term_cond";
                    }
                }
            }
        }
    }
    if (error) {
        ViewMessage(error, "error");
    }
    return result;
}

function validation_form_signin($form) {
    var result = true;
    var $login = $form.find(".js-login");
    var $pass = $form.find(".js-pass");
    $login.removeClass("error");
    var error = validation.username($login.val());
    if (error) {
        $login.addClass("error");
        result = false;
        $('html, body').animate({
            scrollTop: $login.offset().top - 100
        }, 800);
    } else {
        $pass.removeClass("error");
        error = validation.password($pass.val());
        if (error) {
            $pass.addClass("error");
            result = false;
            $('html, body').animate({
                scrollTop: $pass.offset().top - 100
            }, 800);
        }
    }
    if (error) {
        ViewMessage(error, "error");
    }
    return result;
}

function signup(e) {
    e.preventDefault();
    var $form = $(this);
    if (validation_form_signup($form)) {
        $.ajax({
            type: "POST",
            url: $form.attr('action'),
            dataType: "json",
            data: $form.serialize(),
            success: function(data, textStatus) {
                if (data.result == true) {
                    setTimeout(function() {
                        window.location.replace("/auth-reg/login");
                    }, 2000);
                }
                return ViewMessageFromData($form, data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Notification.showError(thrownError, "Ошибка");
            }
        });
    }
}

function signin(e) {
    e.preventDefault();
    var $form = $(this);
    if (validation_form_signin($form)) {
        $.ajax({
            type: "POST",
            url: $form.attr('action'),
            dataType: "json",
            data: $form.serialize(),
            success: function(data, textStatus) {
                if (data != undefined && data.result != undefined) {
                    if (data.result == true) {
                        if ($form.find('.js-remember').prop('checked')) {
                            createCookie("login", $form.find('.js-login').val(), 10);
                            createCookie("password", $form.find('.js-pass').val(), 10);
                            createCookie("remember", $form.find('.js-remember').prop('checked'), 10);
                        }
                        window.location.replace("/sign-in");
                    }
                    return ViewMessageFromData($form, data);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Notification.showError(thrownError, "Ошибка");
            }
        });
    }
}

$(document).ready(function() {
    var $currentScript = $('#signup-script');
    $('#signup-form-container').on("submit", signup);

    $('#login-form-container').on("submit", signin);

    if ($currentScript.data('page') == 'login') {
        $("#login_form_email").val(readCookie("login"));
        $("#login_form_pass").val(readCookie("password"));
        if (readCookie("remember")) {
            $('#check-remember').prop('checked', true);
        }
    }
});