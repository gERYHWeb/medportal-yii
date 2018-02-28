<?php

use yii\widgets\Pjax;

$select_category = (isset($category)) ? $category['id_category'] : 0;
?>

<main class="main">

    <ol class="breadcrumb">
		<?php
		$str = '';
		$i = 1;
		foreach ( $this->params["BreadCrumbs"] as $key => $val ) {
		    if($i == count($this->params["BreadCrumbs"])){
		        $val['notlink'] = true;
            }
			if ( $key == end( $this->params["BreadCrumbs"] ) ) {
				$str .= "<li class='active'>" . $val["label"] . "</li>";
			} else {
				if ( isset( $val["notlink"] ) && $val["notlink"] == true ) {
					$str .= "<li>" . $val["label"] . "</li>";
				} else {
					$str .= "<li><a href='" . $val["url"] . "'>" . $val["label"] . "</a></li>";
				}
			}
            $i++;}
		echo $str;
		?>
    </ol>

    <section class="section section-category  container clearfix">
        <div>
			<?php if ( $list_vip ) { ?>
                <div class="title-page">
                    <h1 class="text">Vip объявления</h1>
                </div>
                <div class=" section-vip ">
                    <div class="vip-box vip-box-1">
						<?php
						foreach ( $list_vip as $key => $val ) {
							$main_img = "";
							foreach ( $val["media"] as $item_media ) {
								if ( isset( $item_media['type_media'] ) && $item_media['type_media'] == "main_image" ) {
									$main_img = $item_media['value'];
								}
							}
							isset( $val['meta_title'] ) ? $meta_title = $val['meta_title'] : $meta_title = '';
							isset( $val['cur_symbol'] ) ? $symbol_currency = $val['cur_symbol'] : $symbol_currency = '';
							isset( $val['price'] ) ? $price = $val['price'] : $price = '';
							isset( $val['title'] ) ? $title = $val['title'] : $title = '';
							isset( $val['name_category'] ) ? $name_category = $val['name_category'] : $name_category = '';
							isset( $val['date_create'] ) ? $date_create = $val['date_create'] : $date_create = '';
							isset( $val['count_views'] ) ? $count_views = $val['count_views'] : $count_views = '';
							isset( $val['id_ads'] ) ? $id_ads = $val['id_ads'] : $id_ads = '';
							isset( $val['id_user'] ) ? $id_user = $val['id_user'] : $id_user = '';
							?>

							<?php if ( $meta_title != "" && $id_ads != "" ) { ?>
                                <a href="/advert/<?php echo $id_ads . "-" . $meta_title; ?>" class="product-item ">
                                    <div class="image-box">
                                        <?php
                                        $url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $main_img;
                                        if ( ! @fopen( $url_image, "r" ) || $main_img == "" ) {
                                            $url_image = "/img/default.jpg";
                                        }
                                        ?>
                                        <img src="<?php echo $url_image ?>" alt="" class="">
                                    </div>
                                    <div class="product-title"><?php echo $title ?></div>
                                    <div class="bottom-info">
                                        <div class="price"><?php
                                            app\models\Utility::setPrice($val);
                                        ?></div>
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


            <div class="row sidebar-content">
                <aside class="sidebar" id="sidebar">
                    <!--
                    <form action="/search" method="get" class="widget shop-categories" id="shop-categories">
                    -->
                    <form action="/search" method="get" class="widget shop-categories" id="shop-categories">
                        <div class="widget shop-categories">
                            <h4 class="widget-title">Фильтр</h4>
                            <br>

                            <div class="widget-content">
                                <?php Pjax::begin( [ 'id' => 'container_category', "timeout" => 5000 ] ); ?>
                                <?php
                                    $name_category = (isset($category)) ? $category['value'] : '- Выберите категорию -';
                                ?>
                                <div class="form-group form-group-select column  col-first">
                                    <label>Категория</label>
                                    <div class="select-category">
                                        <div class="select-category__main select-category__li">
                                            <a href="#" onclick="return false;">
                                                <span class="select-category__title"><?php echo $name_category; ?></span>
                                                <span class="select-category__arrow" ><i></i></span>
                                            </a>
                                            <ul class="select-category__ul">
                                                <li data-value="0" class="select-category__li">
                                                    <a href="/items/" class="select-category__link">
                                                        <strong class="select-category__title">- Сбросить категорию -</strong>
                                                    </a>
                                                </li>
                                                <?php
                                                function preCategory($val, $select_category){
                                                    $key = $val['id_category'];
                                                    ?>
                                                    <li data-value="<?php echo $key; ?>" class="select-category__li <?php
                                                        echo (( $select_category == $key )?'select-category__li--selected':'');
                                                    ?>">
                                                        <a href="<?php
                                                            if(!isset($val['child']))
                                                                echo "/category/" . $val['sys_name'];
                                                            else echo "#";
                                                        ?>"
                                                           class="select-category__link">
                                                            <span class="select-category__title"><?php echo $val['value']; ?></span>
                                                        </a>
                                                        <?
                                                        if(isset($val['child'])){?>
                                                            <ul class="select-category__ul select-category__ul--submenu">
                                                                <li class="select-category__li">
                                                                    <a href="<?php
                                                                        echo "/category/" . $val['sys_name'];
                                                                    ?>"
                                                                       class="select-category__link">
                                                                        <strong class="select-category__title">- Показать всё -</strong>
                                                                    </a>
                                                                </li>
                                                                <?php
                                                                foreach ($val['child'] as $key => $item) {
                                                                    preCategory($item, $select_category);
                                                                }
                                                                ?>
                                                            </ul>
                                                            <?php
                                                        }
                                                        ?>
                                                    </li>
                                                    <?php
                                                }
                                                foreach ( $list_category as $val ) {
                                                    preCategory($val, $select_category);
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <?php Pjax::end(); ?>
                                <div class="form-group form-group-select column  col-second">
                                    <label>Вид объявления</label>
                                    <select  class="select select100" name="view">
                                        <option <?php if ( isset( $this->params["filter"] ) &&
                                                           isset( $this->params["filter"]['view'] ) &&
                                                           $this->params["filter"]['view'] == "" ) {
	                                        echo " selected ";
                                        } ?> value="">- Выберите вид -</option>
                                        <option <?php if ( isset( $this->params["filter"] ) &&
                                                           isset( $this->params["filter"]['view'] ) &&
                                                           $this->params["filter"]['view'] == "0" ) {
	                                        echo " selected ";
                                        } ?> value="0">От компании</option>
                                        <option <?php if ( isset( $this->params["filter"] ) &&
                                                           isset( $this->params["filter"]['view'] ) &&
                                                           $this->params["filter"]['view'] == "1" ) {
	                                        echo " selected ";
                                        } ?> value="1">Частное</option>
                                    </select>
                                </div>
                                <div class="form-group form-group-select column  col-third">
                                    <label>Состояние</label>
                                    <select  class="select select100" name="condition">
                                        <option <?php if ( isset( $this->params["filter"] ) &&
                                                           isset( $this->params["filter"]['condition'] ) &&
                                                           $this->params["filter"]['condition'] == "" ) {
	                                        echo " selected ";
                                        } ?> value="">- Выберите состояние -</option>
                                        <option <?php if ( isset( $this->params["filter"] ) &&
                                                           isset( $this->params["filter"]['condition'] ) &&
                                                           $this->params["filter"]['condition'] == "old" ) {
	                                        echo " selected ";
                                        } ?> value="old">Б/У</option>
                                        <option <?php if ( isset( $this->params["filter"] ) &&
                                                           isset( $this->params["filter"]['condition'] ) &&
                                                           $this->params["filter"]['condition'] == "new" ) {
	                                        echo " selected ";
                                        } ?> value="new">Новое</option>
                                    </select>
                                </div>
                                <div class="form-group form-group-price column col-first">
                                    <label>Цена</label>
                                    <div class="price-box">
                                        <input  value="<?php if ( isset( $this->params["filter"] ) && isset( $this->params["filter"]['price-min'] ) && $this->params["filter"]['price-min'] != "" ) {
	                                        echo $this->params["filter"]['price-min']; } ?>" type="number" placeholder="от (тенге)" name="price-min">
                                        <div class="dash">&nbsp;</div>
                                        <input  value="<?php if ( isset( $this->params["filter"] ) && isset( $this->params["filter"]['price-max'] ) && $this->params["filter"]['price-max'] != "" ) {
	                                        echo $this->params["filter"]['price-max']; } ?>" type="number" placeholder="до (тенге)" name="price-max">
                                    </div>
                                </div>
                                <div class="form-group form-group-select column col-third">
                                    <label>Сортировка</label>
                                    <select  class="select select100" name="sort">
                                        <option <?php if ( isset( $this->params["filter"] ) &&
                                                           isset( $this->params["filter"]['sort'] ) &&
                                                           $this->params["filter"]['sort'] == "" ) {
	                                        echo " selected ";
                                        } ?> value="">- Выберите тип сортировки -</option>
                                        <option <?php if ( isset( $this->params["filter"] ) &&
                                                           isset( $this->params["filter"]['sort'] ) &&
                                                           $this->params["filter"]['sort'] == "1" ) {
	                                        echo " selected ";
                                        } ?> value="1">Самые новые</option>
                                        <option <?php if ( isset( $this->params["filter"] ) &&
                                                           isset( $this->params["filter"]['sort'] ) &&
                                                           $this->params["filter"]['sort'] == "2" ) {
	                                        echo " selected ";
                                        } ?> value="2">От дешевых к дорогим</option>
                                        <option <?php if ( isset( $this->params["filter"] ) &&
                                                           isset( $this->params["filter"]['sort'] ) &&
                                                           $this->params["filter"]['sort'] == "3" ) {
	                                        echo " selected ";
                                        } ?> value="3">От дорогих к дешевым</option>
                                        <option <?php if ( isset( $this->params["filter"] ) &&
                                                           isset( $this->params["filter"]['sort'] ) &&
                                                           $this->params["filter"]['sort'] == "4" ) {
	                                        echo " selected ";
                                        } ?> value="4">Популярные</option>
                                    </select>
                                </div>
                                <div class="form-group form-group-check column  col-fourth">
                                    <label>&nbsp;</label>
                                    <div class="label-box">
                                        <input type="checkbox"
                                               id="check-withFoto"
                                               class="checkbox"
	                                        <?php if ( isset( $this->params["filter"] ) &&
                                                       isset( $this->params["filter"]['hasImage'] )) {
		                                        echo " checked ";
	                                        } ?>
                                               name="check-withFoto">
                                        <label for="check-withFoto" class="checkbox-label">Только с фото</label>
                                    </div>
                                </div>
                                <input type="hidden" name="search"
                                       value="<?php if ( isset( $this->params["filter"] ) && isset( $this->params["filter"]['search'] ) && $this->params["filter"]['search'] != "" ) {
		                                   echo $this->params["filter"]['search'];
	                                   } ?>">
                                <input type="hidden" name="city"
                                       value="<?php if ( isset( $this->params["filter"] ) && isset( $this->params["filter"]['city'] ) && $this->params["filter"]['city'] != "" ) {
		                                   echo $this->params["filter"]['city'];
	                                   } ?>">
                            </div>
                            <div class="filtration-bottom">
                                <button class="btn btn-inverse btn-submit" type="submit" id="go-filter">Поиск</button>
                            </div>

                            <!--
                            form="from-search"
                            -->

                        </div>
                    </form>
                </aside>
                <div class="content ">
                    <?php if ( $list_adverts ) { ?>
					<?php Pjax::begin( [ 'id' => 'container_advert', 'timeout' => 5000 ] ); ?>
                    <div class="a-container row">

						<?php
						foreach ( $list_adverts as $key => $val ) {
							$main_img = "";
							foreach ( $val["media"] as $item_media ) {
								if ( isset( $item_media['type_media'] ) && $item_media['type_media'] == "main_image" ) {
									$main_img = $item_media['value'];
								}
							}
							isset( $val['meta_title'] ) ? $meta_title = $val['meta_title'] : $meta_title = '';
							isset( $val['cur_symbol'] ) ? $symbol_currency = $val['cur_symbol'] : $symbol_currency = '';
							isset( $val['price'] ) ? $price = $val['price'] : $price = '';
							isset( $val['title'] ) ? $title = $val['title'] : $title = '';
							isset( $val['name_category'] ) ? $name_category = $val['name_category'] : $name_category = '';
							isset( $val['date_create'] ) ? $date_create = $val['date_create'] : $date_create = '';
							isset( $val['count_views'] ) ? $count_views = $val['count_views'] : $count_views = '';
							isset( $val['id_ads'] ) ? $id_ads = $val['id_ads'] : $id_ads = '';
							isset( $val['id_user'] ) ? $id_user = $val['id_user'] : $id_user = '';
							if ( $id_ads != "" ) {
								?>
								<?php if ( $meta_title != "" ) { ?>
                                    <div class="col-6 col-md-6 col-lg-4 col-xl-3 a-item">
                                        <a href="/advert/<?php echo $id_ads . "-" . $meta_title; ?>" class="product-item ">
                                            <div class="image-box">
                                                <?php
                                                $url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $main_img;
                                                if ( ! @fopen( $url_image, "r" ) || $main_img == "" ) {
                                                    $url_image = "/img/default.jpg";
                                                }
                                                ?>
                                                <img src="<?php echo $url_image ?>" alt="" class="">
                                            </div>
                                            <div class="product-title"><?php echo $title ?></div>
                                            <div class="bottom-info">
                                                <div class="price"><?php
                                                    app\models\Utility::setPrice($val);
                                                ?></div>
                                            </div>
                                        </a>
                                    </div>
								<?php } ?>
							<?php }
						} ?>
                    </div>

					<?php if ( $count_page > 1 ) { ?>
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
								for ( $i = 1; $i <= $count_page; $i ++ ) {
									if ( $i == ( $active_page + 1 ) ) {
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
                <?php }else{ ?>
                    <div class="main-message isWarning" style="margin: 0;padding: 0;">
                        <div class="main-message__wrapper">
                            <div class="main-message__wrap-icon">
                                <div class="main-message__icon fa fa-question"></div>
                            </div>
                            <h1 class="main-message__title"><?php echo 'Нет объявлений'; ?></h1>
                            <p class="main-message__description"><?php echo 'По Вашему запросу объявления не найдены.'; ?></p>
                        </div>
                        <p class="main-message__wrap-link"> Вернуться назад на <a href="/" class="main-message__link">главную</a> </p>
                    </div>
                <?php } ?>
            </div>
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
/*
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
                $.pjax.reload({container: '#container_advert', async: false});
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    }
*/

    $(document).ready(function () {
        select_category();
        select_sub_category();
    });
</script>

