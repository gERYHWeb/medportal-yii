<?php
use \yii\helpers\Url;
?>
<!--main-->
<main class="main">
    
    <?php if ($vip) { ?>
    <?php
        $vip1 = ceil(count($vip)) / 2;
        $data_vip1 = array_slice($vip, 0, $vip1);
        $vip2 = floor(count($vip) - $vip1);
        $data_vip2 = array_slice($vip, $vip1, $vip2);
        if($data_vip1 || $data_vip2){
    ?>
    <section class="section section-vip  bg-white clearfix">
        <div class="container">
            <div class="title-hr title-hr--upper">
                <hr>
                <h2>Vip объявления</h2>
                <hr>
            </div>
            <div class="content">
                <?php if($data_vip1){ ?>
                <div class="vip-box vip-box-1">
					<?php
					foreach($data_vip1 as $key => $val) {
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

                            if (!@fopen($url_image, "r") || !$main_img) {
                                $url_image = "/img/default.jpg";
                            }

                            $url_advert = "/advert/".$id_ads . "-" . $meta_title;
                            ?>

                            <a href="<?php echo $url_advert; ?>" class="product-item">
                                <div class="image-box">
                                    <img src="<?php echo $url_image ?>" alt="<?php echo $title ?>" class="">
                                </div>
                                <div class="product-title"><?php echo $title ?></div>
                                <div class="bottom-info">
                                    <div class="price"><?php
                                        echo app\models\Advert::getPrice($val);
                                    ?></div>
                                </div>
                                <span class="badge badge-vip">Vip</span>
                            </a>
						<?php } ?>


					<?php } ?>
                </div>
                <?php } ?>
                <?php if($data_vip2){ ?>
                <div class="vip-box vip-box-2">
					<?php
					foreach($data_vip2 as $key => $val) {
						$main_img = "";
						if($val["media"]) {
                            foreach ($val["media"] as $item_media) {
                                if (isset($item_media['type_media']) && $item_media['type_media'] == "main_image") {
                                    $main_img = $item_media['value'];
                                }
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

                        <?php
                        $url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $main_img;

                        if (!@fopen($url_image, "r") || !$main_img) {
                            $url_image = "/img/default.jpg";
                        }

                        $url_advert = "/advert/".$id_ads . "-" . $meta_title;
                        ?>
						<?php if($meta_title != "") { ?>
                            <a href="<?php echo $url_advert; ?>" class="product-item ">
                                <div class="image-box">
                                    <img src="<?php echo $url_image ?>" alt="<?php echo $title ?>" class="">
                                </div>
                                <div class="product-title"><?php echo $title ?></div>
                                <div class="bottom-info">
                                    <div class="price"><?php
                                        echo app\models\Advert::getPrice($val);
                                    ?></div>
                                </div>
                                <span class="badge badge-vip">Vip</span>
                            </a>
						<?php } ?>
					<?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php } ?>
    <?php } ?>

    <?php if($categories){ ?>
    <section class="section section-category bg-gray clearfix">
        <div class="container">
            <div class="title-hr">
                <hr><h2>Категории объявлений</h2><hr>
            </div>
            <div class="content">
                <div class="row">
					<?php foreach($categories as $category) { ?>
					<?php
                        $slug = Url::toRoute([
                            'site/search-adverts',
                            'slug' => $category["sys_name"]
                        ]);
					?>
                        <div class="col-sm-6 col-md-4 col-lg-3  item">
                            <div class="property-card card  product-card">
                                <a href="<?php echo $slug; ?>" class="property-card-header image-box">
                                    <img src="/images/<?php echo $category["image"]; ?>" alt="" class="">
                                </a>
                                <div class="property-card-box card-box card-block">
                                    <h3 class="property-card-title">
                                        <img src="/images/icons/<?php echo $category["sys_name"]; ?>.svg" alt="" class="repairs-icon">
                                        <a href="<?php echo $slug; ?>"><?php echo $category['description']["value"]; ?></a>
                                    </h3>
									<?php if(isset($category['children']) && count($category['children']) > 0) { ?>
                                        <ul class="product-categories">
											<?php foreach($category['children'] as $val_child) { ?>
                                                <li>
                                                    <a class="product-box-item btn-default" href="<?php
                                                           echo Url::toRoute([
                                                               'site/search-adverts',
                                                               'slug' => $val_child["sys_name"]
                                                           ]);
                                                       ?>">
                                                    <?php echo(isset($val_child['description']["value"])) ? $val_child['description']["value"] : $val_child["sys_name"]; ?></a>
                                                    <span class="count text-color-primary"><?php echo $val_child['count_ads'] ?></span>
                                                </li>
											<?php } ?>
                                        </ul>
									<?php } ?>
                                </div>
                            </div>
                        </div>

					<?php } ?>

                </div>

                <?php if(isset($banners) && $banners) { ?>
                <div class="bannBox">
                    <?php echo implode('', $banners); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php } ?>

    <?php if(isset($page) && $page){ ?>
    <section class="section section-category bg-white clearfix">
        <div class="container">
            <?php echo $page['html']; ?>
        </div>
    </section>
    <?php } ?>

    <?php if(isset($brands) && $brands) { ?>
    <section class="section section-brand bg-white clearfix">
        <div class="container">
            <div class="content clearfix">
                <div class="brand-box">
                    <?php echo implode('', $brands); ?>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
</main>
