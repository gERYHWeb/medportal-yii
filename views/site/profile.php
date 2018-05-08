<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\Collapse;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Pjax;

?>

<?php

$params = $this->params["profile_user"];

isset($params["profile_user"]['title']) ? $title = $params["profile_user"]['title'] : $title = '';
isset($params["profile_user"]['description']) ? $description = $params["profile_user"]['description'] : $description = '';
isset($params["profile_user"]['first_name']) ? $first_name = $params["profile_user"]['first_name'] : $first_name = '';
isset($params["profile_user"]['last_name']) ? $last_name = $params["profile_user"]['last_name'] : $last_name = '';
isset($params["profile_user"]['email']) ? $email = $params["profile_user"]['email'] : $email = '';
isset($params["profile_user"]['mobile_number']) ? $mobile_number = $params["profile_user"]['mobile_number'] : $mobile_number = '';
isset($params["profile_user"]['about']) ? $about = $params["profile_user"]['about'] : $about = '';
isset($params["profile_user"]['meta_title']) ? $meta_title = $params["profile_user"]['meta_title'] : $meta_title = '';
isset($params["profile_user"]['meta_desc']) ? $meta_desc = $params["profile_user"]['meta_desc'] : $meta_desc = '';
isset($params["profile_user"]['keywords']) ? $keywords = $params["profile_user"]['keywords'] : $keywords = '';
isset($params["profile_user"]['id_currency']) ? $id_currency = $params["profile_user"]['id_currency'] : $id_currency = '';
isset($params["profile_user"]['phone']) ? $phone = $params["profile_user"]['phone'] : $phone = '';
isset($params["profile_user"]['address']) ? $address = $params["profile_user"]['address'] : $address = '';
isset($params["profile_user"]['name']) ? $name = $params["profile_user"]['name'] : $name = '';
isset($params["profile_user"]['city']) ? $select_city = $params["profile_user"]['city'] : $select_city = 0;
isset($params["count_advert"]) ? $count_advert = $params["count_advert"] : $count_advert = 0;
isset($params["count_message"]) ? $count_message = $params["count_message"] : $count_message = 0;
isset($params["count_favorite"]) ? $count_favorite = $params["count_favorite"] : $count_favorite = 0;
isset($params["account"]) ? $account = $params["account"] : $account = 0;
isset($params["profile_user"]["is_private"]) ? $is_private = $params["profile_user"]["is_private"] : $is_private = 1;
isset($params["profile_user"]["user_id"]) ? $id_user = $params["profile_user"]["user_id"] : $id_user = 0;

if ($first_name == "" && $last_name == "") {
    $username = $params["profile_user"]["username"];
} else {
	$username = $first_name . " " . $last_name;
}
?>

<main class="main ">
    <section class="section section-profile  container clearfix">
        <input id="user_id" value="<?php echo $id_user; ?>" type="hidden">
        <div class="col-12">

            <ol class="breadcrumb">
		        <?php
		        $str = '';
		        foreach($this->params["BreadCrumbs"] as $key => $val) {
			        if($key == end($this->params["BreadCrumbs"])) {
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
	        <?php Pjax::begin([ 'id' => 'container_profile' ]); ?>

            <div class="titleProduct-cash ">
                <div class="title-product ">
                    <h1 class="text">Ваш профиль</h1>
                </div>
                <div class="cash-box">
                    <div class="cash-count">
                        <div class="title">Ваш счет</div>
                        <div class="count"><?php echo $account["amount"] . " " . $account["currency"] ?></div>
                    </div>
                    <a href="/profile-my-payments" class="btn btn-add-money">
                        <i></i>
                        <span>Пополнить счет</span>
                    </a>
                </div>
            </div>
	        <?php Pjax::end(); ?>

            <div class="a-profile section">
                <div class="user-profile">
                    <div class="img-name">
                        <div class="user-images">
                            <img src="/img/profile/user.svg" alt="User Images" class="img-responsive">
                        </div>
                        <div class="user">
                            <div class="title">Добро пожаловать,
                                <br>
                                <div class="username"><?php echo $username ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="favorites-user">
                        <div class="item">
                            <a href="/profile-my-ads">
                                <span class="count"><?php echo $count_advert ?></span>
                                <span class="text">Мои объявления</span>
                            </a>
                        </div>
                        <div class="item my-message">
                            <a href="/profile-message">
                                <span class="count"><?php echo $count_message ?></span>
                                <span class="text">Новые сообщения</span>
                            </a>
                        </div>
                        <div class="item favorites">
                            <a href="/profile-favourite">
                                <span class="count"><?php echo $count_favorite ?></span>
                                <span class="text">Избранное</span></a>
                        </div>
                    </div>
                </div>
                <!-- user-profile -->

                <ul class="user-menu">
                    <li <?php if($page == 'main') {
						echo 'class="active"';
					} ?>><a href="/profile">Профиль</a></li>
                    <li <?php if($page == 'myAds') {
						echo 'class="active"';
					} ?>><a href="/profile-my-ads">Мои объявления</a></li>
                    <li <?php if($page == 'message' || $page == 'message-chat') {
						echo 'class="active"';
					} ?>><a href="/profile-message">Сообщения</a></li>
                    <li <?php if($page == 'favourite') {
						echo 'class="active"';
					} ?>><a href="/profile-favourite">Избранные</a></li>
                    <li <?php if($page == 'deleteAcc') {
						echo 'class="active"';
					} ?>><a href="/profile-delete-acc">Удалить аккаунт</a></li>
                </ul>
            </div>


			<?php require_once "profile-" . $page . ".php" ?>

    </section>
</main>
