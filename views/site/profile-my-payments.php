<!--main-->
<main class="main ">
    <section class="section section-category  container clearfix">
        <div class="content col-sm-12">
            <div class="form-add-money">
                <div class="form-group">
                    <div class="title">
                        <div class="num">1.</div>
                        <div class="text">Укажите сумму пополнения</div>
                    </div>
                    <div class="info">
                        <div class="money-range-box">
                            <div class="slider-range slider-range-addMoney" data-min="100" data-max="10000" id="slider-range-addMoney"></div>
                            <div class="summ-box">
                                <div class="text-title">Сумма:</div>
                                <input type="number" id="slider-range-addMoney-val" name="slider-money"/>
                                <div class="text-other">тенге</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="title">
                        <div class="num">2.</div>
                        <div class="text">Выберить способ оплаты</div>
                    </div>
                    <div class="info">
                        <div class="radio-btns row">
                            <div class="col-sm-6 col-md-4 col-lg-3 ">
                                <label>
                                    <input type="radio" name="radio" checked/>
                                    <div class="box">
                                        <div class="box-img">
                                            <img src="/img/add-money/pay1.png" class="" alt="">
                                        </div>
                                        <div class="box-text">
                                            Банковская карта
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-submit">
                    <div class="info">
                        <hr>
                        <div class="btns-box">
                            <button class="btn btn-cancel">Отмена</button>
                            <button type="submit" class="btn btn-add-money">
                                <i></i>
                                <span>Пополнить счет</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
<script type="text/javascript">

    function click_send_form() {
        $("#form_send_money").submit();
    }

    function add_money() {
        var form_data = new FormData();
        form_data.append('token', $("#token_user").val());
        form_data.append('slider-money', $("#slider-range-addMoney-val").val());

        $.ajax({
            type: "POST",
            url: 'add-money',
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (data, textStatus) {
                if (data != undefined && data.result != undefined) {
                    if (data.result == true) {
                        Notification.showSuccess("Ожидайте.");
                        $("#conteiner_form").html(data.data);
                        setTimeout(click_send_form, 1000);
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
    $(document).ready(function () {
        $(".btn-add-money").click(function () {
            add_money();
        });
    });
</script>