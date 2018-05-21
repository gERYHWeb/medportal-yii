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

        <div class="my-favourite-container">
            <h2>Избранное</h2>

			<?php Pjax::begin([ 'id' => 'container_advert' ]); ?>
            <div class="row">
				<?php
                if (count($list_adverts) > 0) {
	                foreach($list_adverts as $key => $val) {
		                isset($val['media'][0]['value']) ? $main_img = $val['media'][0]['value'] : $main_img = '';
		                isset($val['cur_symbol']) ? $symbol_currency = $val['cur_symbol'] : $symbol_currency = '';
		                isset($val['price']) ? $price = $val['price'] : $price = '';
		                isset($val['title']) ? $title = $val['title'] : $title = '';
		                isset($val['name_category']) ? $name_category = $val['name_category'] : $name_category = '';
		                isset($val['name_sub_category']) ? $name_sub_category = $val['name_sub_category'] : $name_sub_category = '';
		                isset($val['date_create']) ? $date_create = $val['date_create'] : $date_create = '';
		                isset($val['count_views']) ? $count_views = $val['count_views'] : $count_views = '';
		                isset($val['count_views_phone']) ? $count_views_phone = $val['count_views_phone'] : $count_views_phone = '';
		                isset($val['count_add_favorites']) ? $count_add_favorites = $val['count_add_favorites'] : $count_add_favorites = '';
		                isset($val['meta_title']) ? $meta_title = $val['meta_title'] : $meta_title = '';
		                isset($val['id_ads']) ? $id_ads = $val['id_ads'] : $id_ads = '';
		               (isset($val['user']) && isset($val['user']["user_id"])) ? $id_user = $val['user']["user_id"] : $id_user = '';

		                if($meta_title != "") {
                            $url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $main_img;
                            if(! @fopen($url_image, "r") || $main_img == "") {
                                $url_image = "/img/default.jpg";
                            }
                            $url_advert = '/advert/' . $id_ads . "-" . $meta_title;
                            ?>
                            <div class="col-6 col-md-4 item">
                                <div class="product-item" id="product-item<?php echo $key ?>">
                                    <div class="image-box">
                                        <a href="<?php echo $url_advert; ?>">
                                            <img id="url_img<?php echo $key ?>" src="<?php echo $url_image ?>" alt=""
                                                 class="">
                                        </a>
                                        <div class="absolute-btn-info">
                                            <button data-id="<?php echo $id_ads; ?>"
                                                    class="btn btn-inverse btn-not-favourite">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                                <span>Убрать из избранного</span>
                                            </button>
                                        </div>
                                    </div>
                                    <a class="product-title" href="<?php echo $url_advert; ?>"
                                       id="title<?php echo $key ?>"><?php echo $title ?></a>
                                    <div class="bottom-info">
                                        <div class="bottom-btn-info">
                                            <a href="#" class="btn btn-inverse btn-not-favourite">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </a>
                                            <a href="#" class="btn btn-inverse btn-message ">
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <div class="price"
                                             id="currency<?php echo $key ?>"><?php
                                            echo app\models\Advert::getPrice($val);
                                        ?></div>
                                    </div>
                                </div>
                            </div>
		                <?php }
	                }
                } else {
                    ?>
                    В данном разделе отсутствуют объявления
                    <?php
                }
				echo '</div>';
				?>
				<?php if($count_page > 1) { ?>
                    <div class="pagination-box">
                        <ul class="pagination">
                            <li class="disabled">
                                <a href="javascript:gotoPage('prev');">
                                    <span class="caret"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
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
                                    <span class="caret"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                </a>
                            </li>
                        </ul>
                    </div>
				<?php } ?>
				<?php Pjax::end(); ?>

            </div>
        </div>
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
    </div>

    <script type="text/javascript">
        $(document).ready(function act() {
            $('#page1').addClass("active");
        });


    </script>