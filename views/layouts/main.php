<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use app\assets\AppAsset;

AppAsset::register($this);
$session = Yii::$app->session;
if(! $session->isActive) {
	$session->open();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--responsive min width-->
    <meta id="vp" name="viewport" content="width=device-width, initial-scale=1">
    <script>
        if (screen.width < 500) {
            var mvp = document.getElementById('vp');
            mvp.setAttribute('content', 'width=500');
        }
    </script>
    <title><?php echo $this->params['title']; ?></title>
    <meta name="description" content="<?php echo $this->params['description']; ?>">
    <meta name="author" content="Eugeny Genov/Dmitry Timoshenko">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/css/slick.css">
    <link rel="stylesheet" type="text/css" href="/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.fancybox.css">
    <link rel="stylesheet" type="text/css" href="/css/easyResponsiveTabs.css">
    <link rel="stylesheet" type="text/css" href="/vendors/bootstrap-toastr/toastr.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/remodal.css">
    <link rel="stylesheet" type="text/css" href="/css/remodal-default-theme.css">

    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css">
   <script type="text/javascript" src="/js/jquery-2.2.2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/css/middleware.css">
</head>

<body>
<script type="text/x-config">
    {
        "msgs": {
            "timeout_saved_advert": "Объявления не было сохранено по причине ограничения сайта на сохранения одного объявления раз в 5 минут.",
            "invalid_data": "Неверные данные передаются на сервер",
            "not_found": "Не найдено.",
            "undefined_user": "Пользователь не найден",
            "already_exists_user_login": "Пользователь с таким логином существует",
            "already_exists_user_email": "Пользователь с таким e-mail существует",
            "not_enough_money": "Недостаточно денег на счету",
            "invalid_term_cond":"Вы должны согласиться с правилами сервиса",
            "invalid_username":"Логин состоит из латиницы, цифр, нижнее подчёркивание и тире",
            "invalid_username_min":"В логине должно быть минимум 5 символов",
            "invalid_username_max":"В логине должно быть максимум 20 символов",
            "invalid_password":"Некорректно указан пароль",
            "invalid_password_min":"В пароле должно быть минимум 6 символов",
            "invalid_password_max":"В пароле должно быть максимум 100 символов",
            "invalid_city": "Выберите пож-та города из выпадающего списка",
            "invalid_price": "Нужно ввести цену или поставить договорную цену",
            "invalid_phone": "Вы не ввели Ваш телефон",
            "invalid_email": "Вы не ввели Ваш email",
            "invalid_state": "Вы не выбрали состояние",
            "invalid_view": "Выберите вид предлагаемого товара (услуги)",
            "invalid_description": "Нужно ввести описание",
            "invalid_description_min":"Минимальная длина описания 5 символов",
            "invalid_descriptione_max":"Максимальная длина описания 2000 символов",
            "invalid_curr_password": "Текущий пароль указан неверно",
            "invalid_confirm_password": "Подтверждение пароля указано неверно",
            "invalid_passwords_dont_match": "Пароли не совпадают",
            "success_edited_advert": "Объявление успешно сохранено",
            "success_added_advert": "Объявление успешно добавлено",
            "ads_undefined": "Объявление не найдено.",
            "success_edit_profile": "Профиль успешно обновлён.",
            "please_auth": "Пожалуйста авторизуйтесь или зарегистрируйтесь.",
            "send_msg_to_self": "Нельзя отправить сообщение себе.",
            "important_auth": "Необходимо авторизоваться / зарегистрироваться, чтобы открыть больше функций на сайте.",
            "success_msg": "Сообщение успешно отправлено. Следите за новыми сообщениями в Вашем профиле.",
            "fail_msg": "Сообщение не отправилось. Проверьте данные.",
            "advert_not_found": "Объявление не найдено.",
            "timeout_callback": "Сообщение не было отправлено по причине ограничения сайта на отправку одного сообщения раз в 5 минут.",
            "timeout_callback_into_acc": "Сообщение не было отправлено по причине ограничения сайта на отправку одного сообщения раз в 5 секунд.",
            "fail_edit_profile": "Профиль не обновлён. Попробуйте чуть позже.",
            "invalid_title": "Некорректно введён заголовок.",
            "invalid_title_product": "Некорректно введён заголовок.",
            "invalid_min_message":"Сообщение не должно быть меньше 10 симв.",
            "invalid_price_min":"Минимальная сумма 10",
            "invalid_price_max":"Максимальная сумма 1 000 000",
            "invalid_title_min":"Минимальная длина заголовка 5 символов",
            "invalid_title_max":"Максимальная длина заголовка 150 символов",
            "invalid_min_price_min":"Минимальная сумма 10",
            "invalid_category_product":"Выберите категорию",
            "invalid_desc_product":"Описание не должно быть меньше 20 симв.",
            "invalid_pass_confirm":"Пароли не совпадают",
            "not_saved_profile":"Профиль не был сохранён",
            "session_expired":"Сессия авторизации истекла",
            "diapazone_price":"Сумма не входит в диапазон"
        }
    }
</script>
<?php //$this->beginBody() ?>

<div class="preloader">
    <div class="load">
        <div class="on"></div>
        <div class="on"></div>
        <div class="on"></div>
        <div class="on"></div>
    </div>
</div>

<div class="hdMsg" data-hdmsg="true">
    <div class="hdMsg__wrap">
        <div class="hdMsg__msg"></div>
        <div class="hdMsg__bgSymb">
            <span class="hdMsg__symb"></span>
        </div>
    </div>
</div>

<input type="hidden" id="token_user"
       value="<?php echo isset($this->params["token"]) ? $this->params["token"] : 0; ?>">
<input type="hidden" id="user_id"
       value="<?php echo isset($this->params["user_id"]) ? $this->params["user_id"] : 0; ?>">

<div class="wrapper <?php if(isset($this->params["is_index"]) && $this->params["is_index"] !== true) {
	echo 'wrapper-pages';
} ?>">
    <header class="header <?php if(isset($this->params["is_index"]) && $this->params["is_index"] === true) {
		echo 'container-fluid';
	} ?>">

        <div class="container">
            <div class="header-top">
                <a href="/" class="logo">
                    <img src="/img/logo.png" alt="">
                </a>
                <div class="sign-add">
                    <div class="sign">
						<?php if(isset($_SESSION['token'])) {
						    $profile = $this->params["profile_user"]; ?>
                            <a href="/sign-out" class="btn-link">
                                <span class="icon-box">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                </span>
                                <span class="btn-text">Выйти<?php //echo isset($this->params['Translations']['sign_out'] ) ? $this->params['Translations']['sign_out'] : $this->params['Language'] . "_" . "sign_out";  ?></span>
                            </a>
                            <a href="/profile" class="btn-link">
                                <span class="icon-box profile-cmsgs">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <?php if($profile['count_message']){ ?>
                                    <span class="profile-cmsgs__counter <?php
                                        echo ($profile['count_message'] > 99) ? "profile-cmsgs__counter--big" : "";
                                    ?>"><?php echo $profile['count_message']; ?></span>
                                    <?php } ?>
                                </span>
                                <span class="btn-text">Профайл<?php //echo isset($this->params['Translations']['private_office'] ) ? $this->params['Translations']['private_office'] : $this->params['Language'] . "_" . "profile";  ?></span>
                            </a>

						<?php } else { ?>
                            <a href="/auth-reg/signup" class="btn-link">
                                <span class="icon-box">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </span>
                                <span class="btn-text">Регистрация<?php //echo isset($this->params['Translations']['sign_up'] ) ? $this->params['Translations']['sign_up'] : $this->params['Language'] . "_" . "sign_up";  ?></span>
                            </a>
                            <a href="/auth-reg/login" class="btn-link">
                                <span class="icon-box">
                                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                                </span>
                                <span class="btn-text">Вход<?php //echo isset($this->params['Translations']['sign_out'] ) ? $this->params['Translations']['sign_in'] : $this->params['Language'] . "_" . "sign_in";  ?></span>
                            </a>
						<?php } ?>
                    </div>

                    <div class="add">
                        <!--<a href="" class="btn">-->
						<?php if($this->params["is_login"]) { ?>
                        <a href="/edit-advert/new" class="btn">
							<?php } else { ?>
                            <a href="/auth-reg/login" class="btn">
								<?php } ?>
                                <i class="fa fa-plus plus" aria-hidden="true"></i>
                                <span>Подать объявление</span>
                            </a>
                    </div>
                </div>
            </div>
        </div>

		<?php if(isset($this->params["is_index"]) && $this->params["is_index"] === true) { ?>

            <div class="header-slider container-fluid">
                <div class="main-slider">
					<?php if(isset($this->params["content"]) && isset($this->params["content"]["main-slider"])) {
						$str = '';
						foreach($this->params["content"]["main-slider"] as $val) {
							if(isset($val) && isset($val["html"])) {
								$str .= $val["html"];
							}
						}
						echo $str;
					} ?>
                </div>
            </div>

		<?php } ?>

        <div class="header-bottom container-fluid">
            <div class="container">
                <form id="form-search" method="get" action="/search" class="form form-search row">
                    <div class="form-group form-group-input">
                        <input type="search" class="input-search" name="query" placeholder="Пример: вагонка"
                               value="<?php if(isset($_GET["query"]) && isset($_GET["query"]) && $_GET["query"] != "") {
							       echo $_GET["query"];
						       } ?>">
                    </div>
                    <div class="form-group form-group-select">
                        <div class="form-cities">
                            <div class="form-cities__wrap-control">
                                <input placeholder="Искать по всей стране" name="nameCity" type="text" value="<?php echo $_GET['nameCity']; ?>" class="js-cities-control form-cities__control">
                                <input type="hidden" name="city" value="<?php echo $_GET['city']; ?>" class="js-city-id">
                            </div>
                            <div class="form-cities__wrap-list">
                                <ul class="form-cities__list js-city-container">
                                    <li class="form-cities__placeholder">(Ничего не найдено)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-btn">
                        <button class="btn  btn-search" type="submit">
                            <i class="fa fa-search icon-white"></i>
                            <span class="btn-search-text">Найти</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </header>


    <aside id="modal_send_messge" class="modal modal_send_messge">
        <div>
            <div class="form-group row">
                <label class="col-2 col-sm-2 col-md-2 col-form-label">Загаловок сообщения*</label>
                <div class="col-10 col-sm-10 col-md-10">
                    <input type="text" id="title_message_to_send" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-sm-2 col-md-2 col-form-label">Текст сообщения</label>
                <div class="col-10 col-sm-10 col-md-10">
                    <textarea rows="5" id="message_to_send" class="form-control" required></textarea>
                </div>
            </div>

            <div class="margiv-top-10">
                <button onclick="send_message()" class="btn btn-send">Отправить</button>
                <button onclick="close_modal()" class="btn btn-close">Закрыть</button>
            </div>
        </div>
    </aside>


    <div class="wrap">
        <div class="container">
			<?php echo $content ?>
        </div>
    </div>


    <footer class="footer container-fluid clearfix">
        <div class=" footer-mask">
            <div class="container footer-content">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 social-pay hidden-sm hidden-xs">
                        <div class="logo">
                            <a href="#"><img src="/img/logo-inverse.png" alt=""></a>
                        </div>
                        <div class="social">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                        <div class="pay-method">
                            <ul>
                                <li>
                                    <a href="#">
                                        <img src="/img/footer/vs.png" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="/img/footer/mc.png" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 contacts">
                        <div class="title">
                            <h4>Контакты</h4>
                        </div>
                        <ul class="list list-contact  list-news">
                            <li>Казахстан, Астана ул. Радужная 49</li>
                            <li><a href="tel:+385 (0)1 123 321"><i class="fa fa-phone"></i> +385 (0)1 123 321</a></li>
                            <li><a href="tel:+385 (0)1 123 321"><i class="fa fa-phone"></i> +385 (0)1 123 321</a></li>
                            <li><a href="mailto:info@my-website.com"><i class="fa fa-envelope"></i> info@my-website.com</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6  info">
                        <div class="title">
                            <h4>Информация</h4>
                        </div>
                        <ul class="list list-news">
                            <li>
                                <a href="/garanty" class="title">Гарантия возврата</a>
                            </li>
                            <li>
                                <a href="/question" class="title">Вопрос-ответ</a>
                            </li>
                            <li>
                                <a href="/advertising" class="title">Реклама на сайте</a>
                            </li>
                            <li>
                                <a href="#modal-feedback" class="title">Обратная связь</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container text-center">
                    <span class=""><a href="webtool.team">Webtool © 2017</a></span>
                </div>
            </div>
        </div>
    </footer>

    <!--modal-feedback-->
    <div class="remodal remodal-feedback" data-remodal-id="modal-feedback">
        <div class="remodal-inner">
            <button data-remodal-action="close" class="remodal-close" id="remodal-close"></button>
            <div class="title">Обратная связь</div>
            <div class="subtitle"> Если у Вас возникли вопросы, предложения или пожелания о сайте, <br> заполните форму
                и мы рассмотрим Вашу заявку в ближайшее время
            </div>

            <div class="form-feedback" id="form-feedback">
                <div class="form-group">
                    <label>Ваше имя :</label>
                    <input type="text" id="name" name="name" class="js-vn" data-type="name" placeholder="Имя " value=""
                           required="">
                </div>
                <div class="form-group">
                    <label>Электронная почта :</label>
                    <input type="email" id="email" name="email" class="js-vn" data-type="email" placeholder="Email"
                           value="" required="">
                </div>
                <div class="form-group">
                    <label>Сообщение :</label>
                    <textarea name="text" id="message" name="message" class="js-vn" data-type="message"
                              placeholder="Текст" value="" required=""></textarea>
                </div>

                <input type="hidden" name="formData" class="control-label" value="Обратная связь">

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-submit-feedback">Отправить</button>
                </div>
            </div>
        </div>
    </div>
    <!--modal-feedback-->

    <div id="hellopreloader">
        <div id="hellopreloader_preload"></div>
    </div>
</div>

<script type="text/javascript">

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


</script>

<script type="text/javascript" src="/js/underscore-min.js"></script>
<script src="/vendors/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/notification.js"></script>

<script type="text/javascript" src="/js/slick.min.js"></script>
<script type="text/javascript" src="/js/select2.min.js"></script>

<script type="text/javascript" src="/js/jquery.fancybox.js"></script>
<script type="text/javascript" src="/js/easyResponsiveTabs.js"></script>
<script type="text/javascript" src="/js/plugins.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script type="text/javascript" src="/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/js/dropzone.js"></script>
<script type="text/javascript" src="/js/remodal.min.js"></script>


</body>

</html>