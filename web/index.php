<?php

function dd($var, $exit = true, $type = "print_r"){
    echo "<pre>";
    if($type === "print_r"){
        print_r($var);
    }else{
        print($var);
    }
    echo "</pre>";
    if($exit) exit();
}

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
