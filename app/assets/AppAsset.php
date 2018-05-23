<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "css/bootstrap.min.css",
        "css/font-awesome.min.css",
        "css/slick.css",
        "css/slick-theme.css",
        "css/select2.min.css",
        "css/main.css",
        "css/jquery-ui.min.css",
        "css/jquery.fancybox.css",
        "css/easyResponsiveTabs.css",
        "vendors/bootstrap-toastr/toastr.min.css",
        "css/remodal.css",
        "css/remodal-default-theme.css",
        "css/dropzone.min.css",
        "css/middleware.css",
    ];
    public $js = [
        "js/jquery.pjax.min.js",
        "js/underscore-min.js",
        "vendors/bootstrap-toastr/toastr.min.js",
        "js/notification.js",
        "js/slick.min.js",
        "js/select2.min.js",
        "js/jquery.fancybox.js",
        "js/easyResponsiveTabs.js",
        "js/jquery-ui.min.js",
        "js/dropzone.js",
        "js/remodal.min.js",
        "js/plugins.js",
        "js/main.js",
        "js/custom.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
