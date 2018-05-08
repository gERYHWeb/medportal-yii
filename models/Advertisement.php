<?php

namespace app\models;

class Advertisement extends \yii\base\Object
{
    protected $packages = [];
    protected $addons = [];

    public function setPackages($config){
        $easy = $config["easy_package"];
        $fast = $config["fast_package"];
        $turbo = $config["turbo_package"];

        $sevenUp = $config["7_up_money"];
        $highSearch = $config["high_search_money"];
        $vip = $config["vip_money"];

        $this->addons = [
            [
                "title" => "7 поднятий вверх списка (ежедневно, 7 дней)",
                "image" => "/img/select-pro/refresh.png",
                "price" => $sevenUp['val'],
                "type" => "7_up"
            ],
            [
                "title" => "Топ - объявление на 7 дней",
                "image" => "/img/select-pro/kite.png",
                "price" => $highSearch['val'],
                "type" => "high_search"
            ],
            [
                "title" => "VIP - объявление на 7 дней",
                "image" => "/img/select-pro/vip.png",
                "price" => $vip['val'],
                "type" => "vip"
            ]
        ];

        $this->packages = [
            "easy_package" => [
                "title" => "Легкий старт",
                "subtitle" => "8х больше просмотров",
                "price" => $easy['val'],
                "old_price" => ($easy['val'] * 2) - 5,
                "features" => [
                    "top" => [
                        "title" => "Топ-объявления на 3 дня",
                        "image" => "/img/select-pro/kite.png"
                    ],
                    "vip" => [
                        "title" => "Vip-объявления",
                        "image" => "/img/select-pro/vip.png",
                        "disabled" => true
                    ],
                    "raise" => [
                        "title" => "Поднятие вверх списка",
                        "image" => "/img/select-pro/refresh.png",
                        "disabled" => true
                    ]
                ]
            ],
            "fast_package" => [
                "title" => "Быстрая продажа",
                "subtitle" => "16х больше просмотров",
                "price" => $fast['val'],
                "old_price" => ($fast['val'] * 2) - 10,
                "features" => [
                    "top" => [
                        "title" => "Топ-объявления на 7 дней",
                        "image" => "/img/select-pro/kite.png"
                    ],
                    "vip" => [
                        "title" => "Vip-объявления",
                        "image" => "/img/select-pro/vip.png"
                    ],
                    "raise" => [
                        "title" => "Поднятие вверх списка",
                        "image" => "/img/select-pro/refresh.png",
                        "disabled" => true
                    ]
                ]
            ],
            "turbo_package" => [
                "title" => "Турбо продажа",
                "subtitle" => "32х больше просмотров",
                "price" => $turbo['val'],
                "old_price" => ($turbo['val'] * 2) - 15,
                "features" => [
                    "top" => [
                        "title" => "Топ-объявления на 21 день",
                        "image" => "/img/select-pro/kite.png"
                    ],
                    "vip" => [
                        "title" => "Vip-объявления",
                        "image" => "/img/select-pro/vip.png"
                    ],
                    "raise" => [
                        "title" => "Поднятие вверх списка",
                        "image" => "/img/select-pro/refresh.png"
                    ]
                ]
            ]
        ];
//        dd($config);
    }

    public function getAddons(){
        return $this->addons;
    }

    public function getPackages(){
        return $this->packages;
    }
}
