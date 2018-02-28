<main class="main ">
    <section class="section section-auth-reg  section-restore-pass container clearfix">
        <div class="content col-sm-12">
            <div class="form-auth-reg form-restore-pass">
                <div class="clearfix" id="form-restore-pass">
                    <input type="hidden" name="is_save" value="yes"/>
                    <h2 class="title"> Востановление пароля </h2>
                    <div class="form-group field-wrap">
                        <label>Ваш Email</label>
                        <input type="email" id="email" name="email" required autocomplete="off"/>
                    </div>
                    <div class="form-group form-group-submit">
                        <button type="submit" class="btn btn-submit btn-restore">Восстановить</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script type="text/javascript">

    function validation_form_restore() {
        var result = true;
        $("#email").removeClass("error");
        if ($.trim($("#email").val()) == "") {
            $("#email").addClass("error");
            result = false;
            $('html, body').animate({scrollTop: $("#email").offset().top - 100}, 800);
            Notification.showWarning("EMail не должен быть пустым");
        } else {
            var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;
            var mail = $("#email");
            if (mail.val().search(pattern) != 0) {
                $("#email").addClass("error");
                result = false;
                $('html, body').animate({scrollTop: $("#email").offset().top - 100}, 800);
                Notification.showWarning("Не правильный формат EMail");
            }
        }
        return result;
    }


    function restore_password() {
        if (validation_form_restore()) {
            var form_data = new FormData();
            form_data.append('email', $.trim($("#email").val()));

            $.ajax({
                type: "POST",
                url: '/restore-password',
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (data, textStatus) {
                    if (data.result == true) {
                        Notification.showSuccess(data.data);
                    } else {
                        if (data.data != undefined) {
                            Notification.showWarning( data.data);
                        }else {
                            Notification.showWarning("Возникле проблемы на сервере. Попробуйте повторить позже.");
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
        $(".btn-restore").click(function () {
            restore_password();
        });
    });
</script>