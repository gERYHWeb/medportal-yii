<div class="main-message <?php
    echo ($type == "error") ? "isError" : "isSuccess"
?>">
    <div class="main-message__wrapper">
        <div class="main-message__wrap-icon">
            <div class="main-message__icon <?php
            echo ($type == "error") ? "fa fa-times" : "fa fa-check"
            ?>"></div>
        </div>
        <h1 class="main-message__title"><?php echo $title; ?></h1>
        <p class="main-message__description"><?php echo $description; ?></p>
    </div>
    <?php if($hasHomeLink){ ?>
        <p class="main-message__wrap-link"> Вернуться назад на <a href="/" class="main-message__link">главную</a> </p>
    <?php } ?>
</div>