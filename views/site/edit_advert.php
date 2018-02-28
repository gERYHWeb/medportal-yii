<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

use app\models\Constant;

$title_advert      = '';
$phone_user_advert = '';
$email_user_advert = '';
$description       = "";

if ( isset( $model["title"] ) ) {
	$title_advert = $model["title"];
}
if ( isset( $profile_user["email"] ) ) {
	$email_user_advert = $profile_user["email"];
}
if ( isset( $model["phone"] ) ) {
	$phone_user_advert = $model["phone"];
}
if ( isset( $model["description"] ) ) {
	$description = str_replace("<br>","\n",$model["description"]);
}
$affiliation = "";
if(isset($model['city'])) {
    $affiliation = $model['city'] . ((isset($model['affiliation'])) ? " (" . $model['affiliation'] . ")" : "");
}

isset( $val['is_private'] ) ? $is_private = $val['is_private'] : $is_private = 1;
$isNew = ( isset( $type ) && $type === "new" );
?>

<pre>
    <?php //print_r([$list_category, $model]) ;  ?>
</pre>

<main class="main ">

    <!--section-product-->
    <section class="section section-post-new-ad container clearfix">
        <!-- CONTENT -->
        <div class="content col-sm-12">

            <ol class="breadcrumb">
                <?php
                $str = '';
                foreach ( $this->params["BreadCrumbs"] as $key => $val ) {
                    if ( $key == end( $this->params["BreadCrumbs"] ) ) {
                        $str .= "<li class='active'>".$val["label"]."</li>";
                    } else {
                        if (isset($val["notlink"]) && $val["notlink"] == true) {
                            $str .= "<li>" . $val["label"] . "</li>";
                        } else {
                            $str .= "<li><a href='" . $val["url"] . "'>" . $val["label"] . "</a></li>";
                        }
                    }
                }
                echo $str;
                ?>
            </ol>
            <input type="hidden" name="advert_id" value="<?php echo $advert_id; ?>"/>

            <div class="title-page">
                <h1 class="text text-center"><?php
					if ( $isNew ) {
						echo "Подать объявление";
					} else {
						echo "Редактировать объявление";
					}
					?></h1>
            </div>

            <form action="/save-advert" id="FormPostNewItem" <?php
                echo $isNew ? 'class="isNew"' : "";
            ?> method="post">
                <input type="hidden" name="advertId" value="<?php echo $advert_id; ?>">
            </form>
            <div class="post-new-ad row">
                <div class="col-12 form-group form-group-input">
                    <label for="">Заголовок:</label>
                    <input type="text" value="<?php echo $title_advert; ?>" class="input limit-area js-vn" data-type="title" name="title" placeholder="" required=""  maxlength="70" form="FormPostNewItem">
                    <small class="limit">
                        <b class="counter">70</b> знаков осталось
                    </small>
                </div>

                <?php if($list_category && $isNew){ ?>
                <div class="col-12 form-group form-group-select category-box">
                    <label for="">Категория:</label>
                    <input type="hidden" name="root_category" class="select-category-input-id  js-vn" data-type="category" form="FormPostNewItem" required="" value="" >
                    <input type="text" class="select-category-input js-vn" required="" value="" readonly="" placeholder="Выберите категорию">
                    <div class="select-category">
                        <ul class="tab-group">
                            <?php
                            $str_select = "";
//                            if ( isset( $type ) && $type === "new" ) {
//                                $str_select = "<option value='0'>-----</option>";
//                            } else {
//                                if ( isset( $model["category"] ) && isset( $model["category"]["name_sub_category"] ) && $model["category"]["name_sub_category"] != "" ) {
//                                    $str_select = "<option value='" . $model["category"]["id_sub_category"] . "'>".$model["category"]["name_sub_category"]."</option>";
//                                    $str_select = "<a href=\"#\"  data-value=\"$model[category][name_sub_category]\" class=\"has-sub\">$model[category][name_sub_category]</a>";
//                                } else {
//                                    $str_select = "<option value='" . $model["category"]["id_category"] . "'>".$model["category"]["name_category"]."</option>";
//                                }
//                            }

                            function preCategory($val, &$str_select){
                                global $model, $default_lang;

                                $str_select .= '<li class="tab"><a href="#" ';
                                if(!isset($val["child"])) {
                                    $str_select .= 'data-value="' . $val["value"] . '" data-id="' . $val["id_category"] . '"';
                                }
                                if ( isset( $model["id_category"] ) && $val["id_category"] == $model["id_category"] ) {
                                    $str_select .= ' class="active valid-category" ';
                                }else if(isset($val["child"])){
                                    $str_select .= ' class="has-sub" ';
                                }
                                $str_select .= ">";
                                if ( isset( $val["value"] ) && $val["value"] != "" ) {
                                    $str_select .= $val["value"];
                                } else {
                                    $str_select .= $default_lang . "_" . $val["sys_name"];
                                }

                                $str_select .= "</a>";
                                if(isset($val['child'])){
                                    $str_select .= "<ul class=\"sub tab-content\">";
                                    foreach ($val['child'] as $item) {
                                        preCategory($item, $str_select);
                                    }
                                    $str_select .= "</ul>";
                                }
                                $str_select .= "</li>";
                            }

                            foreach ( $list_category as $val ) {
                                preCategory($val ,$str_select);
                            }
                            echo $str_select;
                            ?>
                        </ul>
                    </div>
                </div>
                <?php }else{
                    if(isset($model['category'])){
                    $category = $model['category']['name_category'] . ((isset($model['category']['name_sub_category'])) ? " / " . $model['category']['name_sub_category'] : "");
                    ?>
                    <div class="col-12 form-group form-group-input">
                        <label for="">Категория:</label>
                        <strong class="form-control-static"><?php echo $category; ?></strong>
                    </div>
                <?php }
                    } ?>

                <div class="col-6 form-group form-group-input">
                    <label for="">Телефон:</label>
                    <input type="text" value="<?php echo $phone_user_advert; ?>"
                           class="input limit-area js-vn"
                           name="phone" form="FormPostNewItem" data-type="phone" placeholder="">
                </div>

                <div class="col-6 form-group form-group-input">
                    <label for="">E-mail:</label>
                    <input type="text" value="<?php echo $email_user_advert; ?>"
                           class="input limit-area js-vn"
                           name="email" form="FormPostNewItem" data-type="email" placeholder="">
                </div>

                <div class="col-6 form-group form-group-select ">
                    <label>Состояние:</label>
                    <select class="select select100" form="FormPostNewItem" name="state">
                        <option value="old" selected="">Б/У</option>
                        <option value="new">Новое</option>
                    </select>
                </div>

                <div class="col-6 form-group form-group-select">
                    <label for="postCityControl">Город:</label>
                    <div class="form-cities">
                        <div class="form-cities__wrap-control">
                            <input id="postCityControl" type="text" value="<?php echo $affiliation; ?>" class="js-cities-control form-cities__control">
                            <input type="hidden" name="id_city" value="<?php echo (isset($model['id_city'])) ? $model['id_city'] : ""; ?>" form="FormPostNewItem" class="js-city-id">
                        </div>
                        <div class="form-cities__wrap-list">
                            <ul class="form-cities__list js-city-container">
                                <li class="form-cities__placeholder">(Ничего не найдено)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <?php
                if ( $isNew ) {
                    $disabled = '';
                    $btn_txt  = 'Опубликовать';
                } else {
                    $disabled = 'disabled'; //'disabled';
                    $btn_txt  = 'Сохранить изменения';
                }
                ?>

                <div class="col-6 form-group form-group-select ">
                    <label>Цена:</label>
                    <div class="price-box">
                        <input type="number" name="price" class="price-input js-vn" data-type="price" form="FormPostNewItem" value="<?php echo isset( $model["price"] ) ? $model["price"] : "0" ?>">
                        <?php
                        foreach ( $list_currency as $val ) {
                            if ( $val["id_currency"] == $_SESSION["id_currency"] ) {
                                echo "<span class=\"title-currency\">" . $val["symbol"] . " (" . $val["code"] . ")</span>";
                            }
                        }
                        ?>
                        <div class="label-box">
                            <input type="checkbox" id="check-contractual-price" class="checkbox" name="is_contract_price" form="FormPostNewItem" <?php
                                echo ($model['is_contract_price']) ? 'checked=""' : "";
                            ?>>
                            <label for="check-contractual-price" class="checkbox-label">Договорная</label>
                        </div>
                    </div>
                </div>

                <div class="col-6 form-group form-group-select">
                    <label>Вид объявления:</label>
                    <select class="select select100" name="view" form="FormPostNewItem">
                        <option value="1" <?php
                        if ( $is_private == 1 ) {
                            echo "selected";
                        }
                        ?>>Частное
                        </option>
                        <option value="2" <?php
                        if ( $is_private != 1 ) {
                            echo "selected";
                        }
                        ?>>От компании
                        </option>
                    </select>
                </div>

                <!--<div class="col-12 form-group form-group-select ">
                    <label>Цена:</label>
                    <div class="row">
                        <div class="col-6">
                            <input type="number" name="price" class="price-input"
                                   value="<?php echo isset( $model["price"] ) ? $model["price"] : "" ?>">
                        </div>
                        <div class="col-6">
                            <select class="select " name="currency" class="select-curr"
                                    form="FormPostNewItem">
								<?php
								$str_select = "";
								foreach ( $list_currency as $val ) {
									$str_select .= "<option value='" . $val["id_currency"] . "'";
									if ( isset( $model["id_currency"] ) && $val["id_currency"] == $model["id_currency"] ) {
										$str_select .= " selected  ";
									}
									$str_select .= ">";
									if ( isset( $val["symbol"] ) && $val["symbol"] != "" && isset( $val["code"] ) && $val["code"] != "" ) {
										$str_select .= $val["symbol"] . " (" . $val["code"] . ")";
									}

									$str_select .= "</option>";
								}
								echo $str_select;
								?>
                            </select>
                        </div>
                    </div>
                </div>-->

                <div class="col-12 form-group form-group-textarea clearfix">
                    <label for="">Описание:</label>
                    <textarea class="limit-area description-product-post js-vn"
                              id="desc_advert" data-type="description" name="description"
                              maxlength="2000" cols="30" rows="10"
                              form="FormPostNewItem"><?php echo $description; ?></textarea>
                    <small class="limit">
                        <b class="counter">2000</b> знаков осталось
                    </small>
                </div>

				<?php if ( 1 != 1 ) { ?>
                    <div class="col-12 form-group form-group-textarea clearfix">
                        <fieldset class="form-group row">
                            <!-- <div class="sliderGalleryThumb-thumbs product-gallery-thumbnails ">-->
                            <!--<div class="thumb">-->
							<?php foreach ( $model['media'] as $val ) { ?>
                                <div style="display: inline-block">
                                    <img src="/images/<?php echo $val['value']; ?>" width="103" height="100" hspace="5"
                                         vspace="7" alt="" align="left">
                                </div>
							<?php } ?>
                        </fieldset>
                    </div>
				<?php } ?>

                <div class="col-12 form-group form-group-file-upload clearfix">
                    <label for="">Загрузите фото:</label>
                    <label for="" class="small">
                        * Чтобы выбрать несколько фото удерживайте клавишу Ctrl. Максимальное количество фото: 9 шт.
                        Максимальный размер одного фото: 10 Мб. Форматы фото: JPEG, JPG, PNG. Не стоит указывать на фото
                        номера телефонов, адрес эл. почты или ссылки на другие сайты.</label>
                    <div class="file-upload-box">
                        <form action="/" class="dropzone" id="a-drop-img"></form>
                    </div>
                </div>

                <div class="col-12 form-group form-group-submit">
                    <!--
                    <button class="btn btn-inverse">Предпросмотр</button>
                    -->
                    <button class="btn" form="FormPostNewItem" id="button_save"><?php echo $btn_txt ?> </button><!--Опубликовать</button>-->
                </div>
            </div>
        </div>
    </section>
</main>


<script type="text/javascript">

    function validation_form() {

        var result = true;
        $("#title_advert").removeClass("error");
        if ($.trim($("#title_advert").val()) == "") {
            $("#title_advert").addClass("error");
            result = false;
            $('html, body').animate({scrollTop: $("#title_advert").offset().top - 50}, 800);
        } else {
            $("#root_category").removeClass("error");
            if ($.trim($("#root_category").val()) == 0) {
                $("#root_category").addClass("error");
                result = false;
                $('html, body').animate({scrollTop: $("#root_category").offset().top - 50}, 800);
            } else {

                $("#email_user_advert").removeClass("error");
                if ($.trim($("#email_user_advert").val()) == "") {
                    $("#email_user_advert").addClass("error");
                    result = false;
                    $('html, body').animate({scrollTop: $("#email_user_advert").offset().top - 50}, 800);
                } else {
                    $("#phone_user_advert").removeClass("error");
                    if ($.trim($("#phone_user_advert").val()) == "") {
                        $("#phone_user_advert").addClass("error");
                        result = false;
                        $('html, body').animate({scrollTop: $("#phone_user_advert").offset().top - 50}, 800);
                    } else {
                        $("#list_country").removeClass("error");
                        if ($.trim($("#list_country").val()) == 0) {
                            $("#list_country").addClass("error");
                            result = false;
                            $('html, body').animate({scrollTop: $("#list_country").offset().top - 50}, 800);
                        } else {
                            $("#desc_advert").removeClass("error");
                            if ($.trim($("#desc_advert").val()) == "") {
                                $("#desc_advert").addClass("error");
                                result = false;
                                $('html, body').animate({scrollTop: $("#desc_advert").offset().top - 50}, 800);
                            } else {
                                $("#price_advert").removeClass("error");
                                if ($.trim($("#price_advert").val()) == "") {
                                    $("#price_advert").addClass("error");
                                    result = false;
                                    $('html, body').animate({scrollTop: $("#price_advert").offset().top - 50}, 800);
                                } else {
                                    $("#list_currency").removeClass("error");
                                    if ($.trim($("#list_currency").val()) == "") {
                                        $("#list_currency").addClass("error");
                                        result = false;
                                        $('html, body').animate({scrollTop: $("#list_currency").offset().top - 50}, 800);
                                    } else {
                                        if ($("#title_advert").val().length > 200 ) {
                                            result = false;
                                            Notification.showWarning( "Заголовок не должен быть длинее 200 символов");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return result;
    }

    function btn_save() {
        if (prSendAdvert == false) {
            var files = $('#a-drop-img').get(0).dropzone.getAcceptedFiles();

            if (validation_form()) {
                var form_data = new FormData();
                prSendAdvert = true;

                if (files != undefined) {
                    arr_files = [];
                    $(files).each(function () {
                        if (this != undefined && this.upload != undefined && this.upload.filename != undefined) {
                            arr_files.push(this.upload.filename);
                        }

                    });
                    form_data.append("images", arr_files);
                }

                form_data.append('token', $("#token_user").val());
                form_data.append('userId', $("#user_id").val());
                form_data.append('advertId', '<?php echo $advert_id; ?>');
                form_data.append('title', $("#title_advert").val());
                form_data.append('root_category', $("#root_category").val());
                form_data.append('email', $("#email_user_advert").val());
                form_data.append('phone', $("#phone_user_advert").val());
                form_data.append('id_city', $("#list_country").val());
                form_data.append('description', $("#desc_advert").val());
                form_data.append('price', $("#price_advert").val());
                form_data.append('id_currency', $("#list_currency").val());
                form_data.append('type_user_advert', $('#type_user_advert').val());
                form_data.append('condition', $('#condition').val());

                $.ajax({
                    type: "POST",
                    url: '/save-advert',
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function (data, textStatus) {
                        if (data != undefined && data.result != undefined) {
                            if (data.result == true) {
						        <?php if ( $advert_id != "new" ) { ?>
                                Notification.showSuccess("Объявление было сохраненно.");
						        <?php } else { ?>
                                Notification.showSuccess("Объявление было добавленно.");
						        <?php } ?>
                                $(location).attr('href', '/profile-my-ads')
                            } else {
                                if (data.data != undefined) {
                                    Notification.showWarning(data.data);
                                } else {
                                    Notification.showWarning("Возникле проблемы на сервере. Попробуйте повторить позже.");
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
    }

    function load_file_to_dropzone() {
        var existingFiles = [];

		<?php if ( isset( $model['media'] ) ) {
		foreach ( $model['media'] as $val ) {
		$path_info = pathinfo( $val['value'] );
		if ( isset( $path_info['extension'] ) ) {
			$name_file = $path_info['filename'] . "_media." . $path_info['extension'];
		} else {
			$name_file = "";
		}
		?>
        existingFiles.push(
            {
                url: "<?php echo Constant::$url_client_site?>/images/<?php echo $name_file; ?>",
                name: "<?php echo $val['value']; ?>",
                size: 12345678
            });
		<?php } } ?>

        for (var i in existingFiles) {
            if (i != undefined && existingFiles[i] && existingFiles[i].name != "") {
                var mockFile = {
                    name: existingFiles[i].name,
                    size: existingFiles[i].size,
                    type: 'image/jpeg',
                    serverID: 0,
                    accepted: true
                };

                myDropzone.emit("addedfile", mockFile);
                //myDropzone.createThumbnailFromUrl(mockFile, "<?php echo Constant::$url_client_site?>/images/");
                myDropzone.emit("thumbnail", mockFile, existingFiles[i].url);
                //myDropzone.emit("success", mockFile);
                myDropzone.emit("complete", mockFile);
                //myDropzone.files.push(mockFile);
            }
        }
    }

    $(document).ready(function () {

//        iploadImgPost();

//        $("#button_save").click(function () {
//            btn_save();
//        });

		<?php if ( $advert_id != "new" ) { ?>
        setTimeout(load_file_to_dropzone, 500);
		<?php }?>

    });
</script>