<?php

use yii\helpers\Url;

?>

<header class="header <?php if(isset($this->params["is_index"]) && $this->params["is_index"] === true) {
    echo 'container-fluid';
} ?>">

    <div class="container">
        <div class="header-top">
            <a href="/" class="logo">
                <img src="/img/logo.png" alt="">
            </a>
            <div class="sign-add">
                <div class="sign">
                    <?php if(!Yii::$app->user->isGuest) {
                        $profile = $this->params["profile_user"]; ?>
                        <a href="/sign-out" class="btn-link">
                                <span class="icon-box">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                </span>
                            <span class="btn-text">Выйти<?php //echo isset($this->params['translations']['sign_out'] ) ? $this->params['translations']['sign_out'] : $this->params['language'] . "_" . "sign_out";  ?></span>
                        </a>
                        <a href="/profile" class="btn-link">
                                <span class="icon-box profile-cmsgs">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <?php if($profile['count_message']){ ?>
                                        <span class="profile-cmsgs__counter <?php
                                        echo ($profile['count_message'] > 99) ? "profile-cmsgs__counter--big" : "";
                                        ?>"><?php echo $profile['count_message']; ?></span>
                                    <?php } ?>
                                </span>
                            <span class="btn-text">Профайл<?php //echo isset($this->params['translations']['private_office'] ) ? $this->params['translations']['private_office'] : $this->params['language'] . "_" . "profile";  ?></span>
                        </a>

                    <?php } else { ?>
                        <a href="/auth-reg/signup" class="btn-link">
                                <span class="icon-box">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </span>
                            <span class="btn-text">Регистрация<?php //echo isset($this->params['translations']['sign_up'] ) ? $this->params['translations']['sign_up'] : $this->params['language'] . "_" . "sign_up";  ?></span>
                        </a>
                        <a href="/auth-reg/login" class="btn-link">
                                <span class="icon-box">
                                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                                </span>
                            <span class="btn-text">Вход<?php //echo isset($this->params['translations']['sign_out'] ) ? $this->params['translations']['sign_in'] : $this->params['language'] . "_" . "sign_in";  ?></span>
                        </a>
                    <?php } ?>
                </div>

                <div class="add">
                    <!--<a href="" class="btn">-->
                    <?php if(!Yii::$app->user->isGuest) { ?>
                    <a href="/edit-advert/new" class="btn">
                        <?php } else { ?>
                        <a href="/auth-reg/login" class="btn">
                            <?php } ?>
                            <i class="fa fa-plus plus" aria-hidden="true"></i>
                            <span>Подать объявление</span>
                        </a>
                </div>
            </div>
        </div>
    </div>

    <?php if(isset($this->params['mainSlider']) && $this->params['mainSlider']) { ?>
        <div class="header-slider container-fluid">
            <div class="main-slider">
                <?php echo implode('', $this->params['mainSlider']); ?>
            </div>
        </div>
    <?php } ?>

    <div class="header-bottom container-fluid">
        <div class="container">
            <form id="form-search" method="get" action="/search" class="form form-search row">
                <div class="form-group form-group-input">
                    <input type="search" class="input-search" name="query" placeholder="Пример: вагонка"
                           value="<?php if(isset($_GET["query"]) && isset($_GET["query"]) && $_GET["query"] != "") {
                               echo $_GET["query"];
                           } ?>">
                </div>
                <div class="form-group form-group-select">
                    <div class="form-cities">
                        <div class="form-cities__wrap-control">
                            <input placeholder="Искать по всей стране" name="nameCity" type="text" value="<?php echo $_GET['nameCity']; ?>" class="js-cities-control form-cities__control">
                            <input type="hidden" name="city" value="<?php echo $_GET['city']; ?>" class="js-city-id">
                        </div>
                        <div class="form-cities__wrap-list">
                            <ul class="form-cities__list js-city-container">
                                <li class="form-cities__placeholder">(Ничего не найдено)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="form-group form-group-btn">
                    <button class="btn  btn-search" type="submit">
                        <i class="fa fa-search icon-white"></i>
                        <span class="btn-search-text">Найти</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>
