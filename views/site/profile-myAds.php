<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\Collapse;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;

use yii\widgets\Breadcrumbs;

?>

<?php echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ]); ?>

<div class="row">

    <div class="col-lg-9">
        <div class="my-a-container">

            <h2>Мои объявления</h2>
	        <?php Pjax::begin( [ 'id' => 'container_advert' ] ); ?>
	        <?php if (count($list_adverts) > 0) {  ?>
			<?php
			foreach ( $list_adverts as $key => $val ) {
				isset( $val['media'][0]['value'] ) ? $main_img = $val['media'][0]['value'] : $main_img = '';
				isset( $val['cur_symbol'] ) ? $symbol_currency = $val['cur_symbol'] : $symbol_currency = '';
				isset( $val['price'] ) ? $price = $val['price'] : $price = '';
				isset( $val['title'] ) ? $title = $val['title'] : $title = '';
				isset( $val['category']['name_category'] ) ? $name_category = $val['category']['name_category'] : $name_category = '';
				isset( $val['category']['name_sub_category'] ) ? $name_sub_category = $val['category']['name_sub_category'] : $name_sub_category = '';
				isset( $val['date_create'] ) ? $date_create = $val['date_create'] : $date_create = '';
				isset( $val['count_views'] ) ? $count_views = $val['count_views'] : $count_views = '';
				isset( $val['count_views_phone'] ) ? $count_views_phone = $val['count_views_phone'] : $count_views_phone = '';
				isset( $val['count_add_favorites'] ) ? $count_add_favorites = $val['count_add_favorites'] : $count_add_favorites = '';
				isset( $val['meta_title'] ) ? $meta_title = $val['meta_title'] : $meta_title = '';
				isset( $val['id_ads'] ) ? $id_ads = $val['id_ads'] : $id_ads = '';
				(isset( $val['user'] ) && isset( $val['user']["id_user"] )) ? $id_user = $val['user']["id_user"] : $id_user = '';

				if ( $meta_title != "" ) {
					?>
                    <div class="my-a-item" id="ad-item<?= $key ?>">
	                    <?php
	                    $url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $main_img;
	                    if (!@fopen($url_image, "r") || $main_img == "") {
		                    $url_image = "/img/default.jpg";
	                    }
	                    ?>
                        <a href="/advert/<?php echo $id_ads . "-" . $meta_title ?>" class="item-image-box ">
                            <img id="url_img<?php echo $key; ?>" src="<?php echo $url_image; ?>" alt="Image" class="img-responsive">
                        </a>

                        <div class="item-info-main">
                            <div class="top">
                                <!-- item-info -->
                                <div class="item-info ">
                                    <div class="a-info">
                                        <h3 class="item-price"><?php echo $price . " " . $symbol_currency; ?></h3>
                                        <h4 class="item-title"><a href="/advert/<?php echo $id_ads . "-" . $meta_title ?>"><?php echo $title ?></a></h4>
                                        <div class="item-cat">
                                            <span><a href="#"><?php echo $name_category ?></a></span> /
                                            <span><a href="#"><?php echo $name_sub_category ?></a></span>
                                        </div>
                                    </div>
                                    <div class="a-meta">
                                        <div class="meta-content">
                                            <div class="dated">Выставлено: <span><?php echo $date_create ?></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-option">
                                    <a class=" btn btn-a user-option-btn" href="/add-pro/<?php echo $id_ads; ?>">
                                        <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                        <span>Рекламировать</span>
                                    </a>
                                    <a class="btn btn-toTop user-option-btn" href="javascript:liftUp('<?php echo $id_ads; ?>')">
                                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                                        <span>Поднять вверх</span>
                                    </a>
                                    <a class=" btn btn-edit user-option-btn" href="/edit-advert/<?php echo $id_ads; ?>">
                                        <i class="fa fa-pencil"></i>
                                        <span>Редактировать</span>
                                    </a>
                                    <a class=" btn btn-delete user-option-btn"
                                       href="javascript:deleteAds('<?php echo $id_ads; ?>')">
                                        <i class="fa fa-times"></i>
                                        <span>Удалить</span>
                                    </a>
                                </div>
                            </div>
                            <div class="bottom">
                                <div class="item">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    <div class="text">Просм.: <span class="count"><?php echo $count_views; ?></span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                    <div class="text">Тел.: <span class="count"><?php echo $count_views_phone; ?></span>
                                    </div>
                                </div>
                                <div class="item">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    <div class="text">В избранном: <span
                                                class="count"><?php echo $count_add_favorites; ?></span></div>
                                </div>
                            </div>
                        </div>
                    </div>


				<?php } ?>
			<?php } ?>
			<?php if ( $count_page > 1 ) { ?>
                <div class="pagination-box">
                    <ul class="pagination">
                        <li class="disabled">
                            <a href="javascript:gotoPage('prev');">
                            <span class="caret"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
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
                            <span class="caret"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                            </a>
                        </li>
                    </ul>
                </div>
			<?php } ?>
		    <?php } else {?>
                В данном разделе отсутствуют объявления
	        <?php } ?>
	        <?php Pjax::end(); ?>
        </div>
    </div>
    <!-- left-info -->

    <!-- sidebar-right-info -->
    <div class="col-lg-3 text-center">
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
    $(document).ready(function act() {
        $('#page1').addClass("active");
    });

    function deleteAds(id) {
        var del_data = {};
        del_data.id_ads = id;
        $.ajax({
            type: "POST",
            url: '/delete-advert',
            cache: false,
            data: del_data,

            success: function (data, textStatus) {
                if (data != undefined && data.result != undefined) {
                    if (data.result == true) {
                        Notification.showSuccess("Объявление было удаленно");
                        location.reload();
                    } else {
                        Notification.showWarning("Ошибка. Свяжитесь с администратором сайта");
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                Notification.showError(thrownError, "Ошибка");
            }
        });
    }

    function liftUp(id) {
        var form_data = new FormData();
        form_data.append('token', $("#token_user").val());
        form_data.append('id_ads', id);


        $.ajax({
            type: "POST",
            url: '/liftup-advert',
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,

            success: function (data, textStatus) {
                if (data != undefined && data.result != undefined) {
                    if (data.result == true) {
                        Notification.showSuccess("Объявлению был выставлен признак поднятия вверх");
                        $.pjax.reload({container: '#container_profile'});
                        //location.reload();
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
    }
</script>

    