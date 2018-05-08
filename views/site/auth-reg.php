<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;
use app\models\Constant;

?>

<main class="main ">
    <section class="section section-auth-reg container clearfix">
        <div class="content col-sm-12">
            <div class="form-auth-reg">
                <ul class="tab-group">
                    <li class="tab <?php if($page == "login") {
						echo "active";
					} ?>"><a href="#login-form-container">Вход</a></li>
                    <li class="tab <?php if($page == "signup") {
						echo "active";
					} ?>"><a href="#signup-form-container">Регистрация</a></li>
                </ul>

                <div class="tab-content">
                    <!-- login-form -->
                    <form action="/sign_in" id="login-form-container" <?php if($page == "login") {
						echo 'style="display: block;"';
					} else {
						echo 'style="display: none;"';
					} ?>>
                        <h2 class="title">Вход</h2>
                        <div class="form-group field-wrap">
                            <label class="hidden" for="login_form_email">Ваш логин</label>
                            <input type="text" required value="" placeholder="Ваш Логин" name="login" class="js-login" id="login_form_email">
                        </div>

                        <div class="form-group field-wrap">
                            <label class="hidden" for="login_form_pass">Ваш пароль</label>
                            <input type="password" required placeholder="Ваш пароль" value="" class="js-pass" name="password" id="login_form_pass">
                        </div>

                        <div class="form-group field-wrap" id="error_message">
                        </div>

                        <div class="form-group form-group-save-remember">
                            <div class="label-box">
                                <input type="checkbox" id="check-remember" class="checkbox js-remember" name="check-remember" value="1">
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
                    </form>
                    <form action="<?php echo Url::to('/sign-up'); ?>" id="signup-form-container" <?php if($page == "signup") {
						echo 'style="display: block;"';
					} else {
						echo 'style="display: none;"';
					} ?>>
                        <h2 class="title">Регистрация</h2>

                        <div class="form-group field-wrap">
                            <label class="hidden" for="signup_form_login">Ваш логин</label>
                            <input type="text" required placeholder="Ваш логин" name="login" class="js-login" id="signup_form_login">
                        </div>

                        <div class="form-group field-wrap">
                            <label class="hidden" for="signup_form_email">E-mail</label>
                            <input type="email" required name="email" placeholder="Ваш E-mail" class="js-email" id="signup_form_email">
                        </div>

                        <div class="form-group field-wrap">
                            <label class="hidden" for="signup_form_pass">Ваш пароль</label>
                            <input type="password" required name="password" placeholder="Ваш пароль" class="js-pass" id="signup_form_pass">
                        </div>

                        <div class="form-group field-wrap">
                            <label class="hidden" for="signup_form_pass_repeat">Повторно введите пароль</label>
                            <input type="password" required name="repeat" placeholder="Повторно введите пароль" class="js-repeat" id="signup_form_pass_repeat">
                        </div>

                        <div class="form-group">
                            <div class="label-box label-box-info">
                                <input type="checkbox" id="check-term" class="checkbox js-term" value="on" name="check-term">
                                <label for="check-term" class="checkbox-label check-term-label"></label>
                                <div class="check-text">* Я соглашаюсь с <a href="/terms" class="terms-link link"> правилами
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
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script id="signup-script" defer src="<?php echo Url::to('@web/js/user/signup.js', true); ?>" data-page="<?php echo $page; ?>"></script>