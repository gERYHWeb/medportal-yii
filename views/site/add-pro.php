<?php

$title = "";
if(isset($model["title"]) && $model["title"] != "") {
	$title = $model["title"];
}

$config = $this->params['list_config'];

$packages = $this->params['packages'];
$addons = $this->params['addons'];

?>

<main class="main ">
    <section class="section section-pro-submit  container clearfix">
        <div class="content col-sm-12">
            <div class="title-page">
                <h2 class="text"><?php echo $title; ?></h2>
            </div>
            <form action="/add-pro-advert" class="pro-ads-submit" id="pro-ads-submit">
                <input type="hidden" name="advert_id" value="<?php echo $model["id_ads"]; ?>">
                <input type="hidden" name="token" value="<?php echo $this->params["token"]; ?>">
                <div class="step step1">
                    <div class="step-title">
                        <h5>1.Выберите рекламные услуги</h5>
                    </div>
                    <div class="title-center">
                        Попробуйте новый пакет услуг по <span class="bright">сниженной цене</span>
                    </div>
                    <div class="info" id="AdtPrices">
                        <div class="form-group select-step1">
                            <div class="radioBox ">
                                <?php foreach($packages as $k => $package){ ?>
                                <div class="item package js-clk-price">
                                    <input <?php
                                        echo ($k == 'easy_package') ? "checked" : "";
                                    ?> class="package__input" type="radio" id="<?php echo $k; ?>_checker" data-price="<?php echo $package['price']; ?>" name="package" value="<?php echo $k; ?>">
                                    <label class="package__label" for="<?php echo $k; ?>_checker">
                                        <span class="title">
                                            <span class="title-main"><?php echo $package['title']; ?></span>
                                            <span class="title-second"><?php echo $package['subtitle']; ?></span>
                                        </span>
                                        <span class="advantages">
                                            <?php foreach($package['features'] as $kF => $vF){ ?>
                                            <span class="advantage <?php echo (isset($vF['disabled'])) ? "disable" : ""; ?>">
                                                <span class="img-wrapper">
                                                    <img src="<?php echo $vF['image']; ?>" alt="<?php echo $vF['title']; ?>">
                                                </span>
                                                <span class="text"><?php echo $vF['title']; ?></span>
                                            </span>
                                            <?php } ?>
                                        </span>
                                        <span class="price-select">
                                            <span class="price">
                                                <span class="old"><?php echo ($package['old_price']) ? $package['old_price'] . "₸" : ""; ?></span>
                                                <span class="new"><?php echo ($package['price']) ? $package['price'] . "₸" : ""; ?></span>
                                            </span>
                                            <span class="submit-box">
                                                <span class="btn-check check-no ">Выбрать</span>
                                                <span class="btn-check  check ">Выбрано <i class="fa fa-check"></i></span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                    <div class="title-center title-center2">
                        Так же Вы можете приобрести одну из услуг по стандартной цене
                    </div>

                    <div class="info">
                        <div class="form-group select-addservices">
                            <div class="radioBox">
                                <?php foreach($addons as $k => $addon){ ?>
                                <div class="item js-clk-price">
                                    <input type="checkbox" data-price="<?php echo $addon['price']; ?>" class="checkbox" id="<?php echo $addon['type'].$addon['price']; ?>_chk" name="addons[]" value="<?php echo $addon['type']; ?>">
                                    <label for="<?php echo $addon['type'].$addon['price']; ?>_chk">
                                        <div class="advantages">
                                            <div class="check-emulation"></div>
                                            <div class="advantage">
                                                <div class="img-wrapper">
                                                    <img src="<?php echo $addon['image']; ?>" alt="<?php echo $addon['title']; ?>">
                                                </div>
                                                <div class="text"><?php echo $addon['title']; ?></div>
                                            </div>
                                        </div>
                                        <div class="price">
                                            <div class="old"></div>
                                            <div class="new"><?php echo ($addon['price']) ? $addon['price'] . "₸" : ""; ?></div>
                                        </div>
                                    </label>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-submit">
                        <div class="text">
                            Всего к оплате: <span class="counter"><span class="js-final-price">140</span>₸</span>
                        </div>
                        <div class="info">

                            <div class="btns-box">
                                <a href="/profile-my-ads" class="btn btn-inverse">Отменить</a>
                                <button class="btn btn-pay">Оплатить</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
    </section>
</main>

<script type="text/javascript">

    $(document).ready(function () {
        var $prices = $('.js-clk-price [data-price]');
        var $finalPrice = $('.js-final-price');
        var chgFinalPrice = function(){
            var price = 0;
            for(var i = 0; i < $prices.length; i++){
                var $price = $($prices[i]);
                if($price.prop('checked')){
                    console.log($price);
                    price += ($price.data('price')) ? $price.data('price') : 0;
                }
            }
            $finalPrice.text(price);
        };
        chgFinalPrice();
        $('.js-clk-price').on('change', chgFinalPrice);
        $('#pro-ads-submit').on("submit", function (e) {
            e.preventDefault();
            var $form = $(this);
            $.ajax({
                type: "POST",
                url: $form.attr('action'),
                dataType: "json",
                data: $form.serialize(),
                success: function (data, textStatus) {
                    if (data != undefined && data.result != undefined) {
                        if (data.result == true) {
                            Notification.showSuccess("Рекламные услуги были применнены для объявления");
                            window.location = '/profile-my-ads';
                        } else {
                            if (data.data != undefined && data.data != "") {
                                Notification.showWarning(data.data);
                            } else {
                                Notification.showWarning("Ошибка. Свяжитесь с администратором сайта");
                            }
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