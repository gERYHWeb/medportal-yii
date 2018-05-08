<?php

use yii\widgets\Pjax;

use yii\widgets\Breadcrumbs;

$list_vip = $this->params["vip_adverts"];
?>

<main class="main ">

    <section class="section section-category  container clearfix">
        <div class="col-12">
            <ol class="breadcrumb">
                <?php
                $str = '';
                foreach($this->params["BreadCrumbs"] as $key => $val) {
                    if($key == end($this->params["BreadCrumbs"])) {
                        $str .= "<li class='active'>" . $val["label"] . "</li>";
                    } else {
                        if(isset($val["notlink"]) && $val["notlink"] == true) {
                            $str .= "<li>" . $val["label"] . "</li>";
                        } else {
                            $str .= "<li><a href='" . $val["url"] . "'>" . $val["label"] . "</a></li>";
                        }
                    }
                }
                echo $str;
                ?>
            </ol>

			<?php if(count($list_vip) > 0) { ?>
                <div class="title-page">
                    <h1 class="text">Vip объявления</h1>
                </div>
                <div class="section-vip">
                    <div class="vip-box vip-box-1">
						<?php
						foreach($list_vip as $key => $val) {
							$main_img = "";
							foreach($val["media"] as $item_media) {
								if(isset($item_media['type_media']) && $item_media['type_media'] == "main_image") {
									$main_img = $item_media['value'];
								}
							}
							isset($val['meta_title']) ? $meta_title = $val['meta_title'] : $meta_title = '';
							isset($val['cur_symbol']) ? $symbol_currency = $val['cur_symbol'] : $symbol_currency = '';
							isset($val['price']) ? $price = $val['price'] : $price = '';
							isset($val['title']) ? $title = $val['title'] : $title = '';
							isset($val['name_category']) ? $name_category = $val['name_category'] : $name_category = '';
							isset($val['date_create']) ? $date_create = $val['date_create'] : $date_create = '';
							isset($val['count_views']) ? $count_views = $val['count_views'] : $count_views = '';
							isset($val['id_ads']) ? $id_ads = $val['id_ads'] : $id_ads = '';
							(isset($val['user']) && isset($val['user']["user_id"])) ? $id_user = $val['user']["user_id"] : $id_user = '';
							?>

							<?php if($meta_title != "" && $id_ads != "") { ?>

								<?php
								$url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $main_img;
								if(! @fopen($url_image, "r") || $main_img == "") {
									$url_image = "/img/default.jpg";
								}
                                $url_advert = '/advert/' . $id_ads . "-" . $meta_title;
								?>

                                <a href="<?php echo $url_advert; ?>" class="product-item ">
                                    <div class="image-box">
                                        <img src="<?php echo $url_image ?>" alt="" class="">
                                    </div>
                                    <div class="product-title"><?php echo $title ?></div>
                                    <div class="bottom-info">
                                        <div class="price"><?php echo $symbol_currency . $price ?></div>
                                    </div>
                                    <span class="badge badge-vip">Vip</span>
                                </a>
							<?php } ?>


						<?php } ?>
                    </div>
                </div>
			<?php } ?>

            <div class="title-page">
                <a name="top"><h2 class="text">Обычные объявления</h2></a>
            </div>

			<?php
			if(count($list_adverts) > 0) { ?>


                <div class="row sidebar-content">
                    <aside class="sidebar" id="sidebar">
                        <form action="/search" method="get" class="widget shop-categories" id="shop-categories">
							<?php if(isset($id_category["category"]) && isset($id_category["category2"])) {
								echo '<input type="hidden" value="' . $id_category["category"] . '" name="category">';
								echo '<input type="hidden" value="' . $id_category["category2"] . '" name="category2">';
							} else {
								echo '<input type="hidden" value="' . $id_category["category"] . '" name="category">';
							} ?>

                            <div class="widget shop-categories">
                                <h4 class="widget-title">Поиск</h4>
                                <div class="widget-content">
                                    <div class="form-group form-group-select column  col-second">
                                        <label>Вид объвления</label>
                                        <select class="select select100" name="view">
                                            <option value="">- Выберите вид -</option>
                                            <option value="0">От компании</option>
                                            <option value="1">Частное</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-group-select column  col-third">
                                        <label>Состояние</label>
                                        <select class="select select100" name="condition">
                                            <option value="">- Выберите состояние -</option>
                                            <option value="old">Б/У</option>
                                            <option value="new">Новое</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-group-price column col-first">
                                        <label>Цена</label>
                                        <div class="price-box">
                                            <input type="number" placeholder="от (тенге)"
                                                   name="price-min">
                                            <div class="dash">&nbsp;</div>
                                            <input type="number" placeholder="до (тенге)"
                                                   name="price-max">
                                        </div>
                                    </div>
                                    <div class="form-group form-group-select column col-third">
                                        <label>Сортировка</label>
                                        <select class="select select100" name="sort">
                                            <option value="">- Тип сортировки -</option>
                                            <option value="1">Самые новые</option>
                                            <option value="2">От дешевых к дорогим</option>
                                            <option value="3">От дорогих к дешевым</option>
                                            <option value="4">Популярные</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-group-check column  col-fourth">
                                        <label>&nbsp;</label>
                                        <div class="label-box">
                                            <input type="checkbox" id="check-withFoto" class="checkbox"
                                                   name="hasPhoto">
                                            <label for="check-withFoto" class="checkbox-label">Только с фото</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="filtration-bottom">
                                    <button class="btn btn-inverse btn-submit" type="submit" id="go-filter">Поиск</button>
                                </div>
                            </div>
                        </form>
                    </aside>

                    <div class="content ">

						<?php Pjax::begin([ 'id' => 'container_advert' ]); ?>
                        <div class="a-container row">
							<?php
							foreach($list_adverts as $key => $val) {
								$main_img = "";
								foreach($val["media"] as $item_media) {
									if(isset($item_media['type_media']) && $item_media['type_media'] == "main_image") {
										$main_img = $item_media['value'];
									}
								}
								isset($val['meta_title']) ? $meta_title = $val['meta_title'] : $meta_title = '';
								isset($val['cur_symbol']) ? $symbol_currency = $val['cur_symbol'] : $symbol_currency = '';
								isset($val['price']) ? $price = $val['price'] : $price = '';
								isset($val['title']) ? $title = $val['title'] : $title = '';
								isset($val['name_category']) ? $name_category = $val['name_category'] : $name_category = '';
								isset($val['date_create']) ? $date_create = $val['date_create'] : $date_create = '';
								isset($val['count_views']) ? $count_views = $val['count_views'] : $count_views = '';
								isset($val['id_ads']) ? $id_ads = $val['id_ads'] : $id_ads = '';
								(isset($val['user']) && isset($val['user']["user_id"])) ? $id_user = $val['user']["user_id"] : $id_user = '';
								if($id_ads != "") {
                                    $url_advert = '/advert/' . $id_ads . "-" . $meta_title;
									?>
									<?php if($meta_title != "") { ?>
                                        <div class="col-6 col-md-6 col-lg-4 col-xl-3 a-item">
                                            <a href="<?php echo $url_advert; ?>" class="product-item">
                                                <div class="image-box">
													<?php
													$url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $main_img;

													if(! @fopen($url_image, "r") || $main_img == "") {
														$url_image = "/img/default.jpg";
													}
													?>

                                                    <img id="url_img<?= $key ?>" src="<?= $url_image ?>"
                                                         alt="" class="">
                                                </div>
                                                <div class="product-title" id="title<?= $key ?>"><?php echo $title ?></div>
                                                <div class="bottom-info">
                                                    <div class="price"
                                                         id="currency<?= $key ?>"><?php echo $symbol_currency . $price ?></div>
                                                </div>
                                            </a>
                                        </div>
									<?php } ?>
								<?php }
							}
							?>
                        </div>

						<?php if($count_page > 1) { ?>
                            <div class="pagination-box">
                                <ul class="pagination">
                                    <li class="disabled">
                                        <a href="javascript:gotoPage('prev');">
                                            <span class="caret"><i class="fa fa-angle-left"
                                                                   aria-hidden="true"></i></span>
                                        </a>
                                    </li>
									<?php
									$str = '';
									for($i = 1; $i <= $count_page; $i ++) {
										if($i ==($active_page + 1)) {
											$str .= '<li class="active"><span>' . $i . '</span></li>';
										} else {
											$str .= '<li><a href="javascript:gotoPage(' . $i . ');">' . $i . '</a></li>';
										}
									}
									echo $str;
									?>
                                    <li>
                                        <a href="javascript:gotoPage('next');">
                                        <span class="caret"><i class="fa fa-angle-right"
                                                               aria-hidden="true"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
						<?php } ?>
						<?php Pjax::end(); ?>


                    </div>
                </div>
			<?php } else { ?>
                В данном разделе отсутствуют объявления
			<?php } ?>
        </div>
    </section>
</main>

<script type="text/javascript">
    function select_category() {
        $("#select_category").change(function () {
            var form_data = new FormData();

            form_data.append('type', "category");
            form_data.append('category', $(this).val());

            $.ajax({
                type: "POST",
                url: '/change-category',
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (data, textStatus) {
                    $.pjax.reload({container: '#container_category'});
                    setTimeout(select_category, 1000);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });
    }

    function select_sub_category() {
        $("#select_sub_category").change(function () {
            var form_data = new FormData();

            form_data.append('type', "sub_category");
            form_data.append('category', $(this).val());

            $.ajax({
                type: "POST",
                url: '/change-category',
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (data, textStatus) {
                    $.pjax.reload({container: '#container_category'});
                    setTimeout(select_sub_category, 1000);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });
    }

    function toSearch() {
        var data_search = $("#form-search").serializeArray();

        if ($("#check-withFoto").prop('checked') == false) {
            data_search.push({"name": "check-withFoto", "value": "off"});
        }

        $.ajax({
            type: "POST",
            url: '/start-search',
            data: data_search,
            success: function (data, textStatus) {
                $.pjax.reload({container: '#container_advert'});
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    }

    $(document).ready(function () {
        select_category();
        select_sub_category();
    });
</script>

