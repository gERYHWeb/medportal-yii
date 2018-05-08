<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\Collapse;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Breadcrumbs;
?>

<?php echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

<div class="row">
    <div class=" col-lg-9">
        <form action="/save-profile" method="post" class="form user-pro-section" id="formProfile">
            <!-- profile-details -->
            <div class=" profile-details user-info-section">
                <h2>Профайл</h2>
                <input type="hidden" name="token" value="<?php echo $this->params["token"]; ?>">
                <div class="row row-12-5">
                    <!-- form -->
                    <div class="item col-md-6 form-group form-group-input">
                        <label>Имя</label>
                        <input type="text" class="input js-first_name" name="first_name" value="<?php echo $first_name; ?>">
                    </div>

                    <div class="item col-md-6 form-group form-group-input">
                        <label>Фамилия</label>
                        <input type="text" class="input js-last_name" name="last_name" value="<?php echo $last_name; ?>">
                    </div>

                    <div class="item col-md-6 form-group form-group-input">
                        <label>Email</label>
                        <input type="email" class="input js-email" name="email" value="<?php echo $email; ?>">
                    </div>

                    <div class="item col-md-6  form-group form-group-input">
                        <label for="name-three">Телефон</label>
                        <input type="text" class="input js-phone" name="phone" value="<?php echo $phone; ?>">
                    </div>

                    <div class="item col-md-12 form-group form-group-select">
                        <label>Кто Вы</label>
                        <select name="is_private" class="form-control js-is_private select select100">
                            <option value="0" <?php if($is_private !== 1) {
								echo "selected";
							} ?> >Компания
                            </option>
                            <option value="1" <?php if($is_private == 1) {
								echo "selected";
							} ?> >Частное лицо
                            </option>
                        </select>
                    </div>

                </div>
            </div>
            <!-- profile-details -->

            <!-- change-password -->
            <div class="change-password user-info-section">
                <h2>Изменения пароля</h2>
                <div class="row">
                    <!-- form -->
                    <div class="col-md-4 form-group">
                        <label>Старый пароль</label>
                        <input type="password" name="old_password" class="input">
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Новый пароль</label>
                        <input type="password" name="new_password" class="input">
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Потверждение пароля</label>
                        <input type="password" name="repeat_password" class="input">
                    </div>
                </div>
            </div>

            <!--
            <div class="preferences-settings user-info-section">
                <h2>Preferences Settings</h2>
                <div class="form-group">
                    <div class="label-box">
                        <input type="checkbox" id="check-preferences-settings1" class="checkbox"
                               name="logged">
                        <label for="check-preferences-settings1" class="checkbox-label">Comments are enabled
                            on my ads </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label-box">
                        <input type="checkbox" id="check-preferences-settings2" class="checkbox"
                               name="receive">
                        <label for="check-preferences-settings2" class="checkbox-label">I want to receive
                            newsletter.</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label-box">
                        <input type="checkbox" id="check-preferences-settings3" class="checkbox"
                               name="want">
                        <label for="check-preferences-settings3" class="checkbox-label">I want to receive
                            advice on buying and selling. </label>
                    </div>
                </div>
            </div>
            -->

            <div class="form-group form-group-submit">
                <button id="btn_cancel" class="btn btn-inverse cancel mr-2">Отмена</button>
                <button form="formProfile" id="btn_save" class="btn update">Сохранить</button>
            </div>
        </form>
        <!-- user-pro-edit -->
    </div>
    <!-- profile -->

    <!-- sidebar-right-info -->
    <div class="col-lg-3  text-center">
        <div class="recommended-cta">
            <div class="cta">
                <!-- single-cta -->
                <div class="single-cta">
                    <!-- cta-icon -->
                    <div class="cta-icon icon-secure">
                        <img src="/img/profile/1.png" alt="Icon" class="img-responsive">
                    </div>
                    <!-- cta-icon -->

                    <h4>Secure Trading</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                </div>
                <!-- single-cta -->

                <!-- single-cta -->
                <div class="single-cta">
                    <!-- cta-icon -->
                    <div class="cta-icon icon-support">
                        <img src="/img/profile/2.png" alt="Icon" class="img-responsive">
                    </div>
                    <!-- cta-icon -->

                    <h4>24/7 Support</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                </div>
                <!-- single-cta -->

                <!-- single-cta -->
                <div class="single-cta">
                    <!-- cta-icon -->
                    <div class="cta-icon icon-trading">
                        <img src="/img/profile/3.png" alt="Icon" class="img-responsive">
                    </div>
                    <!-- cta-icon -->

                    <h4>Easy Trading</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                </div>
                <!-- single-cta -->

                <!-- single-cta -->
                <div class="single-cta">
                    <h4>Need Help?</h4>
                    <p><span>Give a call on</span><a href="tel:08048100000"> 08048100000</a></p>
                </div>
                <!-- single-cta -->
            </div>
        </div>
        <!-- cta -->
    </div>
    <!-- sidebar-right-info -->
</div>

<script type="text/javascript">

    function validation_form() {
        var result = true;
        var $form = $formProfile;
        $form.find(".js-first_name").removeClass("error");
        if ($.trim($form.find(".js-first_name").val()) == "") {
            $form.find(".js-first_name").addClass("error");
            result = false;
            $('html, body').animate({scrollTop: $form.find(".js-first_name").offset().top}, 800);
        } else {$form.find(".js-email").removeClass("error");
            if ($.trim($form.find(".js-email").val()) == "") {
                $form.find(".js-email").addClass("error");
                result = false;
                $('html, body').animate({scrollTop: $form.find(".js-email").offset().top - 50}, 800);
            } else {
                $form.find(".js-phone").removeClass("error");
                if ($.trim($form.find(".js-phone").val()) == "") {
                    $form.find(".js-phone").addClass("error");
                    result = false;
                    $('html, body').animate({scrollTop: $form.find(".js-phone").offset().top - 50}, 800);
                } else {

                    $form.find(".js-last_name").removeClass("error");
                    if ($.trim($form.find(".js-last_name").val()) == "") {
                        $form.find(".js-last_name").addClass("error");
                        result = false;
                        $('html, body').animate({scrollTop: $form.find(".js-last_name").offset().top}, 800);
                    }
                }
            }

            var $email = $form.find(".js-email");
            if ($.trim($email.val()) != "") {
                $email.removeClass("error");
                if (validation.email($email.val())) {
                    $email.addClass("error");
                    result = false;
                    $('html, body').animate({scrollTop: $email.offset().top - 50}, 800);
                }
            }
        }
        return result;
    }

    function btn_save(e) {
        var $this = $(this);
        e.preventDefault();
        if (validation_form()) {
            $.ajax({
                type: "POST",
                url: '/save-profile',
                dataType: "json",
                data: $formProfile.serialize(),
                success: function (data, textStatus) {
                    if (data != undefined) {
                        return ViewMessageFromData($this, data);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    Notification.showError(thrownError, "Ошибка");
                }
            });
        }
    }

    $(document).ready(function () {
        window.$formProfile = $('#formProfile');
        $formProfile.on("submit", btn_save);
    });
</script>