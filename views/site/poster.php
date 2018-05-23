<?php

use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use \yii\helpers\Url;

$breadcrumbs = $this->params['breadcrumbs'];
$filters = $this->params['filters'];
$viewOpts = [
    ['', '- Выберите состояние -'],
    ['new', 'Новый'],
    ['old', 'Б/у']
];
$stateOpts = [
    ['', '- Выберите вид -'],
    [0, 'От компании'],
    [1, 'Частное']
];
$sortOpts = [
    ['', '- Выберите тип сортировки -'],
    [1, 'Самые новые'],
    [2, 'От дешевых к дорогим'],
    [3, 'От дорогих к дешевым'],
    [4, 'Популярные']
];
?>

<main class="main">

    <ol class="breadcrumb">
		<?php
		$str = '';
		$i = 1;
		foreach($this->params["BreadCrumbs"] as $key => $val) {
		    if($i == count($this->params["BreadCrumbs"])){
		        $val['notlink'] = true;
            }
			if($key == end($this->params["BreadCrumbs"])) {
				$str .= "<li class='active'>" . $val["label"] . "</li>";
			} else {
				if(isset($val["notlink"]) && $val["notlink"] == true) {
					$str .= "<li>" . $val["label"] . "</li>";
				} else {
					$str .= "<li><a href='" . $val["url"] . "'>" . $val["label"] . "</a></li>";
				}
			}
            $i++;}
		echo $str;
		?>
    </ol>

    <section class="section section-category container clearfix">
        <div>
			<?php if($vip) { ?>
                <div class="title-page">
                    <h1 class="text">Vip объявления</h1>
                </div>
                <div class=" section-vip ">
                    <div class="vip-box vip-box-1">
						<?php
						foreach($vip as $key => $advert) {
                            $mainImage = "";
							foreach($advert["media"] as $item_media) {
								if(isset($item_media['type_media']) && $item_media['type_media'] == "main_image") {
                                    $mainImage = $item_media['value'];
								}
							}
                            $slug = Url::to([
                                'site/advert',
                                'id' => $advert["id_ads"],
                                'slug' => $advert["slug"]
                            ]);
                            ?>
                            <a href="<?php echo $slug; ?>" class="product-item">
                                <div class="image-box">
                                    <?php
                                    $url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $mainImage;
                                    if(! @fopen($url_image, "r") || $mainImage == "") {
                                        $url_image = "/img/default.jpg";
                                    }
                                    ?>
                                    <img src="<?php echo $url_image ?>" alt="" class="">
                                </div>
                                <div class="product-title"><?php echo $advert['title']; ?></div>
                                <div class="bottom-info">
                                    <div class="price"><?php
                                        echo app\models\Advert::getPrice($advert);
                                    ?></div>
                                </div>
                                <span class="badge badge-vip">Vip</span>
                            </a>
						<?php } ?>
                    </div>
                </div>
			<?php } ?>
            <div class="title-page">
                <a name="top"><h2 class="text">Обычные объявления</h2></a>
            </div>


            <div class="row sidebar-content">
                <aside class="sidebar" id="sidebar">
                    <form action="<?php echo Url::to(['site/search-adverts']); ?>" class="widget shop-categories" id="FormFilter">
                        <div class="widget shop-categories">
                            <h4 class="widget-title">Фильтр</h4>
                            <br>

                            <div class="widget-content">
                                <?php if($categories){ ?>
                                <?php
                                    $placeholder = (isset($category) && $category) ? $category['description']['value'] : '- Выберите категорию -';
                                ?>
                                <div class="form-group form-group-select column  col-first">
                                    <label>Категория</label>
                                    <div class="select-category">
                                        <div class="select-category__main select-category__li">
                                            <a href="#" onclick="return false;">
                                                <span class="select-category__title"><?php echo $placeholder; ?></span>
                                                <span class="select-category__arrow" ><i></i></span>
                                            </a>
                                            <ul class="select-category__ul">
                                                <li data-value="0" class="select-category__li">
                                                    <a href="<?php echo Url::to(['site/search-adverts']); ?>" class="select-category__link">
                                                        <strong class="select-category__title">- Сбросить категорию -</strong>
                                                    </a>
                                                </li>
                                                <?php function catsOutput($val){ ?>
                                                    <?php $id = $val['id_category']; ?>
                                                    <li data-value="<?php echo $id; ?>" class="select-category__li <?php
                                                        echo (($category == $id)?'select-category__li--selected':'');
                                                    ?>">
                                                        <a href="<?php
                                                            echo !isset($val['children']) ? Url::to(['site/search-adverts', 'slug' => $val['sys_name']]) : "#";
                                                        ?>" class="select-category__link">
                                                            <span class="select-category__title"><?php echo $val['description']['value']; ?></span>
                                                        </a>
                                                        <?
                                                        if(isset($val['children'])){?>
                                                            <ul class="select-category__ul select-category__ul--submenu">
                                                                <li class="select-category__li">
                                                                    <a href="<?php
                                                                        echo Url::to(['site/search-adverts', 'slug' => $val['sys_name']]);
                                                                    ?>" class="select-category__link">
                                                                        <strong class="select-category__title">- Показать всё -</strong>
                                                                    </a>
                                                                </li>
                                                                <?php
                                                                foreach ($val['children'] as $child) {
                                                                    catsOutput($child);
                                                                }
                                                                ?>
                                                            </ul>
                                                            <?php
                                                        }
                                                        ?>
                                                    </li>
                                                    <?php
                                                }
                                                foreach($categories as $val) {
                                                    catsOutput($val);
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                                <div class="form-group form-group-select column  col-second">
                                    <label for="viewFilterControl">Вид объявления</label>
                                    <select id="viewFilterControl" class="select select100 js-field" name="view">
                                        <?php foreach($viewOpts as $item){ ?>
                                            <option <?php
                                                echo ($filters['view'] == $item[0]) ? 'selected=""' : '';
                                            ?> value="<?php echo $item[0]; ?>"><?php echo $item[1]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group form-group-select column col-third">
                                    <label for="stateFilterControl">Состояние</label>
                                    <select id="stateFilterControl" class="select select100 js-field" name="state">
                                        <?php foreach($stateOpts as $item){ ?>
                                            <option <?php
                                                echo ($filters['state'] == $item[0]) ? 'selected=""' : '';
                                            ?> value="<?php echo $item[0]; ?>"><?php echo $item[1]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group form-group-price column col-first">
                                    <label for="priceFilterControl">Цена</label>
                                    <div class="price-box">
                                        <input class="js-field mb10" id="priceFilterControl" value="<?php echo $filters['price_min']; ?>" type="number" placeholder="от (тенге)" name="price_min">
                                        <input class="js-field" value="<?php echo $filters['price_max']; ?>" type="number" placeholder="до (тенге)" name="price_max">
                                    </div>
                                </div>
                                <div class="form-group form-group-select column col-third">
                                    <label for="sortFilterControl">Сортировка</label>
                                    <select id="sortFilterControl" class="select select100 js-field" name="sort">
                                        <?php foreach($sortOpts as $item){ ?>
                                            <option <?php
                                                echo ($filters['sort'] == $item[0]) ? 'selected=""' : '';
                                            ?> value="<?php echo $item[0]; ?>"><?php echo $item[1]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group form-group-check column  col-fourth">
                                    <div class="label-box">
                                        <input class="js-field checkbox" type="checkbox" id="hasImageFilterControl"
	                                        <?php echo ($filters['hasImage']) ? 'checked=""' : ''; ?> name="check-withFoto">
                                        <label for="hasImageFilterControl" class="checkbox-label">Только с фото</label>
                                    </div>
                                </div>
                                <input class="js-field" type="hidden" name="search" value="<?php echo $filters['search']; ?>">
                                <input class="js-field" type="hidden" name="city" value="<?php echo $filters['city']; ?>">
                            </div>
                            <div class="filtration-bottom">
                                <button class="btn btn-inverse btn-submit" type="submit" id="go-filter">Поиск</button>
                            </div>
                        </div>
                    </form>
                </aside>
                <div class="content ">
                    <?php if(isset($adverts) && $adverts) { ?>
                    <div class="a-container row">
                    <?php
                    foreach($adverts as $key => $advert) {
                        $mainImage = "";
                        foreach($advert["media"] as $item_media) {
                            if(isset($item_media['type_media']) && $item_media['type_media'] == "main_image") {
                                $mainImage = $item_media['value'];
                            }
                        }
                        $slug = Url::to([
                            'site/advert',
                            'id' => $advert["id_ads"],
                            'slug' => $advert["slug"]
                        ]);
                        ?>
                        <div class="col-6 col-md-6 col-lg-4 col-xl-3 a-item <?php
                            echo ($advert['is_light']) ? "a-item--light" : "";
                        ?>">
                            <a href="<?php echo $slug; ?>" class="product-item">
                                <div class="image-box">
                                    <?php
                                    $url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $mainImage;
                                    if(! @fopen($url_image, "r") || $mainImage == "") {
                                        $url_image = "/img/default.jpg";
                                    }
                                    ?>
                                    <img src="<?php echo $url_image ?>" alt="" class="">
                                </div>
                                <div class="product-title"><?php echo $advert['title']; ?></div>
                                <div class="bottom-info">
                                    <div class="price"><?php
                                        echo app\models\Advert::getPrice($advert);
                                    ?></div>
                                </div>
                            </a>
                        </div>
                        <?php } ?>
                    </div>

					<?php
                        LinkPager::widget([
                            'pagination' => $pagination,
                        ]);
					?>
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

