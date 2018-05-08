<?php
$profile = (isset($this->params['profile_user']['profile_user'])) ? $this->params['profile_user']['profile_user'] : [];

?>

<main class="main ">
    <section class="section section-product  container clearfix">
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

			<?php
			$main_image = "";
			$image = [];
			if($data_advert) {
                foreach ($data_advert["media"] as $item_media) {
                    if (isset($item_media['type_media']) && $item_media['type_media'] == "main_image") {
                        $main_image = $item_media['value'];
                    } else {
                        $image[] = $item_media['value'];
                    }
                }
            }

			isset($data_advert['users']['first_name']) ? $first_name = $data_advert['users']['first_name'] : $first_name = '';
			isset($data_advert['users']['last_name']) ? $last_name = $data_advert['users']['last_name'] : $last_name = '';
			isset($data_advert['users']['username']) ? $username = $data_advert['users']['username'] : $username = '';
			isset($data_advert['users']['id_user']) ? $id_user = $data_advert['users']['id_user'] : $id_user = 0;
			isset($data_advert['phone']) ? $phone = $data_advert['phone'] : $phone = '';
			isset($data_advert['city']) ? $city = $data_advert['city'] : $city = '';
			isset($data_advert['country']) ? $country = $data_advert['country'] : $country = '';
			?>
            <input type="hidden" id="user_id" value="<?php echo $id_user; ?>">

            <div class="title-page">
                <h1 class="text"><?php echo $data_advert['title'] ?></h1>
                <div class="add-info">
					<?php
					$d1 = strtotime($data_advert['date_create']);
					$date2 = date("m.d.Y", $d1);
					$time2 = date("H:i", $d1);
					?>
                    <span>Добавлено: в <?php echo $time2 ?>, <?php echo $date2 ?></span>,
                    <span>ID: <?php echo $data_advert['id_ads'] ?></span>
                </div>
            </div>

            <div class="about-product">
                <div class="row">
                    <div class="col-lg-8 col-xl-9 product-mainInfo">
                        <!-- galery -->
                        <div class="sliderGalleryThumb product-gallery">
                            <div class="sliderGalleryThumb-big product-gallery-top">
                                <div class="item">
									<?php
									$url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $main_image;
									if(! @fopen($url_image, "r") || $main_image == "") {
										$url_image = "/img/default.jpg";
									}
									?>

                                    <a href="<?php echo $url_image ?>" data-fancybox="galleryProduct"
                                       class="big-photo-link">
                                        <img class="img-responsive" src="<?php echo $url_image ?>" alt=""/>
                                        <div class="hover-layer">
                                            <i class="fa fa-search-plus" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                </div>

								<?php
								if(isset($image)) {
									foreach($image as $key => $val) {
										?>

                                        <div class="item">
                                            <a href="/images/<?php echo $val ?>" data-fancybox="galleryProduct"
                                               class="big-photo-link">
                                                <img class="img-responsive" src="/images/<?php echo $val ?>"
                                                     alt=""/>
                                                <div class="hover-layer">
                                                    <i class="fa fa-search-plus" aria-hidden="true"></i>
                                                </div>
                                            </a>
                                        </div>
										<?php
									}
								}
								?>

                            </div>
                            <div class="sliderGalleryThumb-thumbs product-gallery-thumbnails ">
                                <div class="thumb">

									<?php
									$url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $main_image;
									if(! @fopen($url_image, "r") || $main_image == "") {
										$url_image = "/img/default.jpg";
									}
									?>

                                    <img src="<?php echo $url_image ?>" alt=""/>
                                </div>
								<?php
								if(isset($image)) {
									foreach($image as $key => $val) {
										?>
                                        <?php
                                        $url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $val;
                                        if(! @fopen($url_image, "r") || $main_image == "") {
                                            $url_image = "/img/default.jpg";
                                        }
                                        ?>
                                        <div class="thumb ">
                                            <img src="<?php echo $url_image; ?>" alt=""/>
                                        </div>
										<?php
									}
								}
								?>
                            </div>
                        </div>

                        <!-- galery -->
                        <!-- more-info -->
                        <div class="more-info">
                            <div class="product-tabInfo" id="productTab">
                                <ul class="resp-tabs-list">
                                    <li class="title"> Описание</li>
                                    <?php if(false){ ?>
                                        <li class="title"> Видео</li>
                                    <?php } ?>
                                </ul>

                                <div class="resp-tabs-container">
                                    <!-- Подробное описание  -->
                                    <div class="detailed-tab tab-description">
                                       <div class="tab-description__wrapper">
                                           <div class="tab-description__info-panel info-panel--top">
                                               <div class="info-panel__list">
                                                   <div class="info-panel__item">
                                                       <span class="info-panel-item__key">Тип: </span>
                                                       <strong class="info-panel-item__value"><?php
                                                           echo ($data_advert['view'] == 1) ? 'Частное' : 'Бизнес';
                                                       ?></strong>
                                                   </div>
                                                   <div class="info-panel__item">
                                                       <span class="info-panel-item__key">Состояние: </span>
                                                       <strong class="info-panel-item__value"><?php
                                                           echo ($data_advert['state'] == 'new') ? 'Новое' : 'Б/У';
                                                       ?></strong>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="tab-description__text"><?php
                                               $search = '\r\n';
                                               $replace = "<br>";
                                               $descript = str_replace($search, $replace, $data_advert['description']);
                                               echo $descript;
                                               ?></div>
                                           <div class="tab-description__info-panel info-panel--bottom">
                                               <div class="info-panel__wrapper">
                                                   <div class="info-panel__left">
                                                       <div class="info-panel__views">
                                                    <span class="views__icon">
                                                        <span class="fa fa-eye"></span>
                                                    </span>
                                                           <span class="views__title">Просмотров:</span>
                                                           <strong class="views__count"><?php echo $data_advert['count_views']; ?></strong>
                                                       </div>
                                                   </div>
                                                   <div class="info-panel__right"></div>
                                               </div>
                                           </div>
                                       </div>
                                    </div>
                                    <!-- Подробное описание  -->
                                    <?php if(false){ ?>
                                    <!-- Видео  -->
                                    <div class="video-tab">
                                        <iframe class="video" src="https://www.youtube.com/embed/eLEXAtJxiK0"
                                                frameborder="0" allowfullscreen></iframe>
                                    </div>
                                    <!-- Видео  -->
                                    <?php } ?>
                                </div>
                            </div>
							<?php if($this->params["is_login"] == true && $this->params["user_id"] != $id_user) { ?>
                                <div class="product-sendMessSeller" id="product-sendMessSeller">
                                    <div class="title-hr">
                                        <hr><h2>Связаться с автором</h2><hr>
                                    </div>
                                    <form action="/send-message" class="message_send_seller cleatfix" id="FormMessageToSeller">
                                        <input type="hidden" name="to" value="<?php echo $id_user; ?>">
                                        <input type="hidden" name="id" value="<?php echo $data_advert['id_ads']; ?>">
                                        <div class="form-box cleatfix">

                                            <div class="row ">

                                                <div class="col-sm-12 item">
                                                    <div class="form-group form-group-textarea">
                                                        <label for="message_searchCriteria-text">Сообщение</label>
                                                        <textarea name="message" data-type="message" class="js-vn" id="message_searchCriteria_text"
                                                                  cols="30"
                                                                  rows="10"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-sm-12 item text-center">
                                                    <button id="btn_send_message" class="btn">Отправить</button>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>
							<?php } ?>

                        </div>


						<?php if(count($advert_similar) > 0) { ?>
                            <div class="product-recomended">
                                <div class="title-hr">
                                    <hr><h2>Другие объявления автора</h2><hr>
                                </div>
                                <div class="content">
                                    <div class="recomended-product-box">

										<?php
										foreach($advert_similar as $key => $val) {

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

											if($id_ads != "") {
												?>
												<?php if($meta_title != "") { ?>

													<?php
													$url_image = "http://" . $_SERVER["HTTP_HOST"] . "/images/" . $main_img;
													if(! @fopen($url_image, "r") || $main_img == "") {
														$url_image = "/img/default.jpg";
													}

                                                    $url_advert = '/advert/' . $id_ads . "-" . $meta_title;
													?>

                                                    <a href="<?php echo $url_advert; ?>" class="product-item">
                                                        <div class="image-box">
                                                            <img id="url_img<?php echo $key ?>"
                                                                 src="<?php echo $url_image ?>"
                                                                 alt="" class="">
                                                        </div>
                                                        <div class="product-title" id="title<?php echo $key ?>"><?php echo $title ?></div>
                                                        <div class="bottom-info">
                                                            <div class="price"><?php
                                                                app\models\Utility::setPrice($val);
                                                                ?></div>
                                                        </div>
                                                    </a>

												<?php } ?>
											<?php }
										}
										?>
                                    </div>
                                </div>
                            </div>

						<?php } ?>

                    </div>
                    <div class=" col-lg-4 col-xl-3">
                        <div class="sidebar">
                            <div class="product-infoSidebar">
                                <?php if($data_advert['price'] > 0){ ?>
                                <div class="price"> <?php echo $data_advert['price'] . " " . $data_advert['cur_symbol'] ?><?php
                                    echo ($data_advert['is_contract_price'] > 0) ? ' <small>(Договорная)</small>' : "";
                                ?></div>
                                <?php } ?>
                                <div class="profile-info">
                                    <div class="avatar">
                                        <img src="/img/profile/user.svg">
                                    </div>
                                    <div class="name">
                                        <span class="first"><?php echo $first_name != "" ? $first_name : $username ?></span>
                                        <span class="last"> <?php echo $last_name ?></span>
                                    </div>
                                </div>
                                <div class="add-info">
                                    <div class="item link-phone phone">
                                        <span class="icon">
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                        </span>
                                        <span class="info" id="form_phone"></span>
                                        <span class="info" id="form_phone_view">
                                            <a href="javascript:viewPhone(<?php echo $data_advert['id_ads']; ?>)">Показать телефон</a>
                                        </span>

                                    </div>
									<?php if($this->params["user_id"] != $id_user) { ?>
                                    <a id="write_user"
                                       href="#product-sendMessSeller" <?php if($this->params["is_login"] != true) {
										echo 'onclick="about();return false;"';
									} ?> class="item sendSeller scrollToHref ">
                                            <span class="icon">
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                            </span>
                                        <span class="info"><span>Написать продавцу</span></span>
                                    </a>
                                    <a href="#" id="add_favorites" data-id="<?php echo $data_advert['id_ads']; ?>" <?php if($this->params["is_login"] != true) {
										echo 'onclick="about();return false;"';
									} ?> class="item favourite btn-favourite">
                                            <span class="icon">
                                                <i class="fa fa-heart" aria-hidden="true"></i>
                                            </span>
                                        <span class="info"><span>Добавить в избранное</span></span>
                                    </a>
									<?php }?>
                                    <div class="item adress">
                                        <span class="icon">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        </span>
                                        <span class="info">
                                            <span><?php echo $city . ', ' . $country ?></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="side-slides">
                                <a href="#" class="side-slide">
                                    <img src="/images/slide8.png" alt="" class="img-fluid">
                                </a>
                                <a href="#" class="side-slide">
                                    <img src="/images/slide9.png" alt="" class="img-fluid">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
</main>
<script type="text/javascript">
    function viewPhone(id) {

        var form_data = new FormData();

        form_data.append('advert_id', id);

        $.ajax({
            type: "POST",
            url: '/get-phone-user',
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (responce, textStatus) {
                if(responce.result){
                    var phones = $('<ul />');
                    for(var k in responce.data){
                        var v = responce.data[k];
                        phones.append("<li>" + v + "</li>");
                    }
                    $("#form_phone_view").hide();
                    $("#form_phone").html(phones).show();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                ViewMessage("invalid_data", "error");
                return console.error(thrownError);
            }
        });
    }

    $(document).ready(function () {
        if ($("#id_user").val() == $("#user_id").val()) {
            $("#product-sendMessSeller").hide();
        }
    });

    function about() {
        return ViewMessage("important_auth", "error");
    }

</script>
