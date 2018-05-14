<?php

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
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
    <title><?= Html::encode($this->title) ?></title>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
    <meta name="author" content="Eugeny Genov/Dmitry Timoshenko">
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
<?php $this->beginBody() ?>

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

    <?php echo $this->render('elements/header.php'); ?>

    <div class="wrap">
        <div class="container">
			<?php echo $content; ?>
        </div>
    </div>

    <?php echo $this->render('elements/footer.php'); ?>


    <section id="modal_send_messge" class="modal modal_send_messge">
        <div>
            <div class="form-group row">
                <label class="col-2 col-sm-2 col-md-2 col-form-label">Заголовок сообщения*</label>
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
    </section>

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

<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>