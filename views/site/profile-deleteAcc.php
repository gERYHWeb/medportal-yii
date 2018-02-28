<?php
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\Collapse;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

?>
<div class="row">
    <div class="col-lg-9">
        <div class="delete-acc-container">
            <h2>Удалить аккаунт</h2>
            <div class="content-delete text-center">
                <h4 class="title"> Вы действительно хотите навсегда удалить Ваш аккаунт? </h4>
                <div class="btns">
                    <a href="/profile" class="btn btn-inverse btn-cancel">Отмена</a>
                    <button class="btn btn-ok">Удалить аккаунт</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 text-center">
        <div class="recommended-cta">
            <div class="cta">
                <!-- single-cta -->
                <div class="single-cta">
                    <!-- cta-icon -->
                    <div class="cta-icon icon-secure">
                        <img src="img/profile/1.png" alt="Icon" class="img-responsive">
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
                        <img src="img/profile/2.png" alt="Icon" class="img-responsive">
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
                        <img src="img/profile/3.png" alt="Icon" class="img-responsive">
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
    $(document).ready(function () {
        $(".btn-ok").click(function () {

            var form_data = new FormData();

            form_data.append('token', $("#token_user").val());

            $.ajax({
                type: "POST",
                url: 'delete-account',
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (data, textStatus) {
                    if (data != undefined && data.result != undefined) {
                        if (data.result == true) {
                            Notification.showSuccess("Аккаунт был полностью удален.");
                            window.location.replace("/");
                        } else {
                            Notification.showWarning(data.data);
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    Notification.showError(thrownError, "Ошибка");
                }
            });
        });
    });
</script>
