<?php

$title = "";
if ( isset( $model["title"] ) && $model["title"] != "" ) {
	$title = $model["title"];
}

if ( isset( $model["category"] ) && $model["category"] != "" && isset( $model["category"]["name_category"] ) && $model["category"]["name_category"] != "" ) {
	$title .= " (" . $model["category"]["name_category"] . ")";
}

if ( isset( $model["category"] ) && $model["category"] != "" && isset( $model["category"]["name_sub_category"] ) && $model["category"]["name_sub_category"] != "" ) {
	$title .= " (" . $model["category"]["name_sub_category"] . ")";
}

?>

<main class="main ">
    <input type="hidden" id="advert_id"
           value="<?php echo ( isset( $model["id_ads"] ) && $model["id_ads"] != "" ) ? $model["id_ads"] : 0 ?>">
    <section class="section section-pro-submit  container clearfix">
        <div class="content col-sm-12">
            <div class="title-page">
                <h2 class="text"><?php echo $title; ?></h2>
            </div>
            <div class="pro-ads-submit" id="pro-ads-submit ">
                <div class="step step1">
                    <div class="step-title">
                        <h5>1.Выберите рекламные услуги</h5>
                    </div>
                    <div class="title-center">
                        Попробуйте новый пакет услуг по <span class="bright">сниженной цене</span>
                    </div>
                    <div class="info">
                        <div class="form-group select-step1">
                            <div class="radioBox ">
                                <div class="item">
                                    <input type="radio" id="control_01" name="section1" value="1" checked>
                                    <label for="control_01">
                                        <div class="title">
                                            <div class="title-main">Легкий старт</div>
                                            <div class="title-second"></div>
                                        </div>
                                        <div class="advantages">
                                            <div class="advantage">
                                                <div class="img-wrapper">
                                                    <img src="/img/select-pro/kite.png" alt="">
                                                </div>
                                                <div class="text">Топ-объявления на 3 дня</div>
                                            </div>
                                            <div class="advantage disable">
                                                <div class="img-wrapper">
                                                    <img src="/img/select-pro/refresh.png" alt="">
                                                </div>
                                                <div class="text">Поднятие вверх списка</div>
                                            </div>
                                            <div class="advantage disable">
                                                <div class="img-wrapper">
                                                    <img src="/img/select-pro/vip.png" alt="">
                                                </div>
                                                <div class="text">Vip-объявления</div>
                                            </div>
                                        </div>
                                        <div class="price-select">
                                            <div class="price">
                                                <div class="old"></div>
                                                <div class="new">10₸</div>
                                            </div>
                                            <div class="submit-box">
                                                <div class="btn-check check-no ">Выбрать</div>
                                                <div class="btn-check  check ">Выбрано <i class="fa fa-check"></i></div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="item">
                                    <input type="radio" id="control_02" name="section1" value="2">
                                    <label for="control_02">
                                        <div class="title">
                                            <div class="title-main">Быстрая продажа</div>
                                            <div class="title-second">16х больше просмотров</div>
                                        </div>
                                        <div class="advantages">
                                            <div class="advantage">
                                                <div class="img-wrapper">
                                                    <img src="/img/select-pro/kite.png" alt="">
                                                </div>
                                                <div class="text">Топ-объявления на 3 дня</div>
                                            </div>
                                            <div class="advantage">
                                                <div class="img-wrapper">
                                                    <img src="/img/select-pro/refresh.png" alt="">
                                                </div>
                                                <div class="text">Поднятие вверх списка</div>
                                            </div>
                                            <div class="advantage disable">
                                                <div class="img-wrapper">
                                                    <img src="/img/select-pro/vip.png" alt="">
                                                </div>
                                                <div class="text">Vip-объявления</div>
                                            </div>
                                        </div>
                                        <div class="price-select">
                                            <div class="price">
                                                <div class="old">64₸</div>
                                                <div class="new">30₸</div>
                                            </div>
                                            <div class="submit-box">
                                                <div class="btn-check check-no ">Выбрать</div>
                                                <div class="btn-check  check ">Выбрано <i class="fa fa-check"></i></div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="item">
                                    <input type="radio" id="control_03" name="section1" value="3">
                                    <label for="control_03">
                                        <div class="title">
                                            <div class="title-main">Турбо продажа</div>
                                            <div class="title-second">32х больше просмотров</div>
                                        </div>
                                        <div class="advantages">
                                            <div class="advantage">
                                                <div class="img-wrapper">
                                                    <img src="/img/select-pro/kite.png" alt="">
                                                </div>
                                                <div class="text">Топ-объявления на 3 дня</div>
                                            </div>
                                            <div class="advantage ">
                                                <div class="img-wrapper">
                                                    <img src="/img/select-pro/refresh.png" alt="">
                                                </div>
                                                <div class="text">Поднятие вверх списка</div>
                                            </div>
                                            <div class="advantage">
                                                <div class="img-wrapper">
                                                    <img src="/img/select-pro/vip.png" alt="">
                                                </div>
                                                <div class="text">Vip-объявления</div>
                                            </div>
                                        </div>
                                        <div class="price-select">
                                            <div class="price">
                                                <div class="old">99₸</div>
                                                <div class="new">40₸</div>
                                            </div>
                                            <div class="submit-box">
                                                <div class="btn-check check-no ">Выбрать</div>
                                                <div class="btn-check  check ">Выбрано <i class="fa fa-check"></i></div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="item" hidden="">
                                    <input type="radio" id="control_04" name="section1" value="4" disabled>
                                    <label for="control_04">
                                        <p></p>
                                    </label>
                                </div>
                                <div class="item" hidden="">
                                    <input type="radio" id="control_05" name="section1" value="5">
                                    <label for="control_05">
                                        <p></p>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="title-center title-center2">
                        Так же Вы можете приобрести одну из услуг по стандартной цене
                    </div>
                    <div class="info">
                        <div class="form-group select-addservices">
                            <div class="radioBox ">
                                <div class="item">
                                    <input type="checkbox" class="checkbox" id="control_14" name="section2" value="1">
                                    <label for="control_14">
                                        <div class="advantages">
                                            <div class="check-emulation"></div>

                                            <div class="advantage">
                                                <div class="img-wrapper">
                                                    <img src="/img/select-pro/refresh.png" alt="">
                                                </div>
                                                <div class="text">7 поднятий в верх списка (ужедневно, 7дней)</div>
                                            </div>
                                        </div>
                                        <div class="price">
                                            <div class="old"></div>
                                            <div class="new">40₸</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="item">
                                    <input type="checkbox" class="checkbox" id="control_15" name="section2" value="2">
                                    <label for="control_15">
                                        <div class="advantages">
                                            <div class="check-emulation"></div>

                                            <div class="advantage">
                                                <div class="img-wrapper">
                                                    <img src="/img/select-pro/vip.png" alt="">
                                                </div>
                                                <div class="text">VIP - объявления на 7 дней</div>
                                            </div>
                                        </div>
                                        <div class="price">
                                            <div class="old"></div>
                                            <div class="new">40₸</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="item">
                                    <input type="checkbox" class="checkbox" id="control_16" name="section2" value="3">
                                    <label for="control_16">
                                        <div class="advantages">
                                            <div class="check-emulation"></div>

                                            <div class="advantage">
                                                <div class="img-wrapper">
                                                    <img src="/img/select-pro/kite.png" alt="">
                                                </div>
                                                <div class="text">Топ-объявлений
                                                    <select class="select selectResolve selectNoSearch" name="dayscount"
                                                            class="select-daysCount" style="width: 100px; ">
                                                        <option value="1">1 день</option>
                                                        <option value="2">2 дня</option>
                                                        <option value="3">3 дня</option>
                                                        <option value="4">4 дня</option>
                                                        <option value="5">5 дней</option>
                                                        <option value="6">6 дней</option>
                                                        <option value="7" selected="">7 дней</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="price">
                                            <div class="old"></div>
                                            <div class="new">40₸</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-group-submit">
                        <div class="text">
                            Всего к оплате: <span class="counter">140₸</span>
                        </div>
                        <div class="info">

                            <div class="btns-box">
                                <a href="/profile-my-ads" class="btn btn-inverse">Отменить</a>
                                <button class="btn btn-pay">Оплатить</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </section>
</main>

<script type="text/javascript">
    $(document).ready(function act() {
        $('.btn-pay').click(function () {
            var section1 = [],
                section2 = [];
            $("[name='section1']:checked").each(function () {
                section1.push($(this).val());
            });
            $("[name='section2']:checked").each(function () {
                section2.push($(this).val());
            });


            var form_data = new FormData();
            form_data.append('token', $("#token_user").val());
            form_data.append('advert_id', $("#advert_id").val());
            form_data.append('section1', section1);
            form_data.append('section2', section2);


            $.ajax({
                type: "POST",
                url: '/add-pro-advert',
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,

                success: function (data, textStatus) {
                    if (data != undefined && data.result != undefined) {
                        if (data.result == true) {
                            Notification.showSuccess("Рекламные услуги были применнены для объявления ");
                            $(location).attr('href', '/profile-my-ads');
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