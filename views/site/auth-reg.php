<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\models\Constant;

?>

<main class="main ">
    <section class="section section-auth-reg container clearfix">
        <div class="content col-sm-12">
            <div class="form-auth-reg">
                <ul class="tab-group">
                    <li class="tab <?php if ( $page == "login" ) {
						echo "active";
					} ?>"><a href="#login-form-container">Вход</a></li>
                    <li class="tab <?php if ( $page == "signup" ) {
						echo "active";
					} ?>"><a href="#signup-form-container">Регистрация</a></li>
                </ul>

                <div class="tab-content">
                    <!-- login-form -->
                    <div id="login-form-container" <?php if ( $page == "login" ) {
						echo 'style="display: block;"';
					} else {
						echo 'style="display: none;"';
					} ?>>
                        <h2 class="title">Вход</h2>
                        <!--
												<div class="form-group form-group-social field-wrap">
													<div class="social-login row">
														<div class="col-sm-6">
															<a href="#" class="social-login-fb">
																<i class="fa fa-facebook "></i> Вход с Facebook
															</a>
														</div>
														<div class="col-sm-6">
															<a href="#" class="social-login-gp">
																<i class="fa fa-google-plus "></i> Вход с Google
															</a>
														</div>
													</div>
												</div>
						-->
                        <div class="form-group field-wrap">
                            <label>Ваш Логин</label>
                            <input type="text" required value="" name="login" id="login_form_email">
                        </div>

                        <div class="form-group field-wrap">
                            <label>Ваш пароль</label>
                            <input type="password" required value="" name="password" id="login_form_pass">
                        </div>

                        <div class="form-group field-wrap" id="error_message">
                        </div>

                        <div class="form-group form-group-save-remember">
                            <div class="label-box">
                                <input type="checkbox" id="check-remember" class="checkbox" name="checkbox">
                                <label for="check-remember" class="checkbox-label check-remember-label">Запомнить
                                    меня</label>
                            </div>
                            <a href="/restore-pass" class="link">Забыли пароль?</a>
                        </div>

                        <div class="form-group form-group-submit">
                            <button type="submit" class="btn btn-submit btn_signin">Войти</button>
                        </div>

                        <div class="form-group form-group-info">
                            Входя в раздел Мой профиль, вы принимаете
                            <br> <a href="/terms" target="_blank" class="terms-link link"> Условия использования
                                сайта</a>
                        </div>
                    </div>
                    <div id="signup-form-container" <?php if ( $page == "signup" ) {
						echo 'style="display: block;"';
					} else {
						echo 'style="display: none;"';
					} ?>>
                        <h2 class="title">Регистрация</h2>
                        <!--
						<div class="form-group form-group-social field-wrap">
							<div class="social-login row">
								<div class="col-sm-6">
									<a href="#" class="social-login-fb">
										<i class="fa fa-facebook "></i> Вход с Facebook
									</a>
								</div>
								<div class="col-sm-6">
									<a href="#" class="social-login-gp">
										<i class="fa fa-google-plus "></i> Вход с Google
									</a>
								</div>
							</div>
						</div>
						-->

                        <div class="form-group field-wrap">
                            <label>Ваш логин</label>
                            <input type="text" required name="login" id="signup_form_login">
                        </div>

                        <div class="form-group field-wrap">
                            <label>EMail</label>
                            <input type="email" required name="email" id="signup_form_email">
                        </div>

                        <div class="form-group field-wrap">
                            <label>Ваш пароль</label>
                            <input type="password" required name="password" id="signup_form_pass">
                        </div>

                        <div class="form-group field-wrap">
                            <label>Повторно введите пароль</label>
                            <input type="password" required name="password_repeat" id="signup_form_pass_repeat">
                        </div>

                        <div class="form-group field-wrap" id="error_message">
                        </div>

                        <div class="form-group">
                            <div class="label-box label-box-info">
                                <input type="checkbox" id="check-term" class="checkbox " name="check-term">
                                <label for="check-term" class="checkbox-label check-term-label"></label>
                                <div class="check-text">* Я соглашаюсь с <a href="/terms"
                                                                            class="terms-link link"> правилами
                                        использования сервиса</a>, а также с передачей и обработкой моих данных
                                    на данном сервисе. Я подтверждаю своё совершеннолетие и ответственность за размещение
                                    объявления
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-submit">
                            <button type="submit" class="btn btn-submit btn_signup">Зарегистрироваться</button>
                        </div>
						<?php //ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script type="text/javascript">


    function validation_form_signup() {
        var result = true;
        $("#signup_form_login").removeClass("error");
        if ($.trim($("#signup_form_login").val()) == "") {
            $("#signup_form_login").addClass("error");
            result = false;
            $('html, body').animate({scrollTop: $("#signup_form_login").offset().top - 100}, 800);
            Notification.showWarning("Логин не должен быть пустым");
        } else {
            $("#signup_form_email").removeClass("error");
            if ($.trim($("#signup_form_email").val()) == "") {
                $("#signup_form_email").addClass("error");
                result = false;
                $('html, body').animate({scrollTop: $("#signup_form_email").offset().top - 100}, 800);
                Notification.showWarning("E-mail не должен быть пустым");
            } else {
                var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;
                var mail = $("#signup_form_email");
                if (validation.email(mail.val())) {
                    $("#signup_form_email").addClass("error");
                    result = false;
                    $('html, body').animate({scrollTop: $("#signup_form_email").offset().top - 100}, 800);
                    Notification.showWarning("Не правильный формат e-mail");
                } else {
                    $("#signup_form_pass").removeClass("error");
                    if ($.trim($("#signup_form_pass").val()) == "") {
                        $("#signup_form_pass").addClass("error");
                        result = false;
                        $('html, body').animate({scrollTop: $("#signup_form_pass").offset().top - 100}, 800);
                        Notification.showWarning("Пароль не должен быть пустым");
                    } else {
                        $("#signup_form_pass_repeat").removeClass("error");
                        if ($.trim($("#signup_form_pass_repeat").val()) == "") {
                            $("#signup_form_pass_repeat").addClass("error");
                            result = false;
                            $('html, body').animate({scrollTop: $("#signup_form_pass_repeat").offset().top - 100}, 800);
                            Notification.showWarning("Введите повторно пароль");
                        } else {
                            if ($.trim($("#signup_form_pass_repeat").val()) != $.trim($("#signup_form_pass").val())) {
                                result = false;
                                Notification.showWarning("Пароли не совпадают");
                            } else {
                                if ($("#check-term").prop("checked") != true) {
                                    result = false;
                                    Notification.showWarning("Вы должны согласиться с правилами сервиса");
                                }
                            }
                        }
                    }
                }
            }
        }
        return result;
    }

    function validation_form_sigin() {
        var result = true;
        $("#login_form_email").removeClass("error");
        if ($.trim($("#login_form_email").val()) == "") {
            $("#login_form_email").addClass("error");
            result = false;
            $('html, body').animate({scrollTop: $("#login_form_email").offset().top - 100}, 800);
        } else {
            $("#login_form_pass").removeClass("error");
            if ($.trim($("#login_form_pass").val()) == "") {
                $("#login_form_pass").addClass("error");
                result = false;
                $('html, body').animate({scrollTop: $("#login_form_pass").offset().top - 100}, 800);
            }
        }
        return result;
    }

    function signup() {
        if (validation_form_signup()) {
            var form_data = new FormData();
            form_data.append('login', $.trim($("#signup_form_login").val()));
            form_data.append('email', $.trim($("#signup_form_email").val()));
            form_data.append('password', $.trim($("#signup_form_pass").val()));
            form_data.append('check-term', "on");

            $.ajax({
                type: "POST",
                url: '/sign_up',
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (data, textStatus) {
                    if (data.result == true) {
                        Notification.showSuccess("Пользователь был создан.");
                        window.location.replace("/auth-reg/login");
                    } else {
                        Notification.showWarning(data.data);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    Notification.showError(thrownError, "Ошибка");
                }
            });
        }
    }

    function signin() {
        if (validation_form_sigin()) {
            var form_data = new FormData();
            form_data.append('login', $.trim($("#login_form_email").val()));
            form_data.append('password', $.trim($("#login_form_pass").val()));
            form_data.append('check-remember', $.trim($('#check-remember').prop('checked')));
            $.ajax({
                type: "POST",
                url: '/sign_in',
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (data, textStatus) {
                    if (data != undefined && data.result != undefined) {
                        if (data.result == true) {
                            if ($('#check-remember').prop('checked')) {
                                createCookie("login", $("#login_form_email").val(), 10);
                                createCookie("password", $("#login_form_pass").val(), 10);
                                createCookie("remember", $('#check-remember').prop('checked'), 10);
                            }
                            window.location.replace("/sign-in");
                        } else {
                            Notification.showWarning(data.data);
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
        $(".btn_signup").click(function () {
            signup();
        });

        $(".btn_signin").click(function () {
            signin();
        });

		<?php if ( $page == "login" ) { ?>
        $("#login_form_email").val(readCookie("login"));
        $("#login_form_pass").val(readCookie("password"));
        if (readCookie("remember")) {
            $('#check-remember').prop('checked', true);
        }
		<?php } ?>
    });


</script>