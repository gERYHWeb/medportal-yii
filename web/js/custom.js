function gotoPage(item) {
    var form_data = new FormData();
    form_data.append('page', item);
    $.ajax({
        type: "POST",
        url: '/change-page',
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function (data, textStatus) {
            $.pjax.reload({container: '#container_advert', async: false});
            setTimeout(event_button, 1000);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            Notification.showError(thrownError, "Ошибка");
        }
    });
}

function validation_feedback_form() {
    var result = true;
    $("#name").removeClass("error");
    if ($.trim($("#name").val()) == "") {
        $("#name").addClass("error");
        result = false;
        $('html, body').animate({scrollTop: $("#name").offset().top}, 800);
    } else {
        $("#email").removeClass("error");
        if ($.trim($("#email").val()) == "") {
            $("#email").addClass("error");
            result = false;
            $('html, body').animate({scrollTop: $("#email").offset().top}, 800);
        } else {
            var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;
            var mail = $("#email");
            if (mail.val().search(pattern) != 0) {
                $("#email").addClass("error");
                result = false;
                $('html, body').animate({scrollTop: $("#email").offset().top - 100}, 800);
                Notification.showWarning("Не правильный формат EMail");
            } else {
                $("#message").removeClass("error");
                if ($.trim($("#message").val()) == "") {
                    $("#message").addClass("error");
                    result = false;
                    $('html, body').animate({scrollTop: $("#message").offset().top}, 800);
                }
            }
        }
    }
    return result;
}

function send_feedback() {
    if (validation_feedback_form()) {
        var form_data = new FormData();

        form_data.append('name', $("#name").val());
        form_data.append('email', $("#email").val());
        form_data.append('message', $("#message").val());

        $.ajax({
            type: "POST",
            url: '/feedback',
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (data, textStatus) {
                if (data != undefined && data.result != undefined) {
                    if (data.result == true) {
                        Notification.showSuccess("Сообщение было отправлено");
                        $("#name").val("");
                        $("#email").val("");
                        $("#message").val("");
                        $("#remodal-close").click();
                    } else {
                        if (data.data != undefined && data.data != "") {
                            Notification.showWarning(data.data);
                        } else {
                            Notification.showWarning("Возникли проблемы, обратитесь к администратору сайта");
                        }
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Notification.showError(thrownError, "Ошибка");
            }
        });
    }
}

$(document).ready(function () {
    $(".btn-submit-feedback").click(function () {
        send_feedback();
    });
});