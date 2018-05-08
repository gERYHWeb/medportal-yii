<?php

namespace app\models;

class Advertisement extends \yii\base\Object
{
    protected $packages = [];
    protected $addons = [];

    public function endWordByNum($n, $titles) {
      $cases = array(2, 0, 1, 1, 1, 2);
      return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
    }

    public function setPackages($config){
        $easy = $config["easy_package"];
        $fast = $config["fast_package"];
        $turbo = $config["turbo_package"];

        $sevenUp = $config["m_raise_money"];
        $highSearch = $config["light_money"];
        $vip = $config["vip_money"];
        try {
            $raiseDuration = $config["m_raise_duration"]['val'] / 24;
            $lightDuration = $config["light_duration"]['val'] / 24;
            $vipDuration = $config["vip_duration"]['val'] / 24;
        }catch(\Exception $e){
            $raiseDuration = 1;
            $lightDuration = 1;
            $vipDuration = 1;
        }

        $this->addons = [
            [
                "title" => "Выделенное объявление на $lightDuration " . $this->endWordByNum($lightDuration, [
                        'день',
                        'дня',
                        'дней'
                    ]),
                "image" => "/img/select-pro/kite.png",
                "price" => $highSearch['val'],
                "type" => "light"
            ],
            [
                "title" => "$raiseDuration " . $this->endWordByNum($raiseDuration, [
                        'поднятие',
                        'поднятия',
                        'поднятий'
                    ]) . " вверх списка (ежедневно, $raiseDuration " . $this->endWordByNum($raiseDuration, [
                        'день',
                        'дня',
                        'дней'
                    ]) . ")",
                "image" => "/img/select-pro/refresh.png",
                "price" => $sevenUp['val'],
                "type" => "m_raise"
            ],
            [
                "title" => "VIP объявление на $vipDuration " . $this->endWordByNum($vipDuration, [
                        'день',
                        'дня',
                        'дней'
                    ]),
                "image" => "/img/select-pro/vip.png",
                "price" => $vip['val'],
                "type" => "vip"
            ]
        ];

        $this->packages = [
            "easy_package" => [
                "title" => "Легкий старт",
                "subtitle" => "10х больше просмотров",
                "price" => $easy['val'],
                "old_price" => ($easy['val'] * 2) - 5,
                "features" => [
                    "light" => [
                        "title" => "Выделенное объявление на 7 дней",
                        "image" => "/img/select-pro/kite.png"
                    ],
                    "raise" => [
                        "title" => "Поднятие вверх списка",
                        "image" => "/img/select-pro/refresh.png",
                        "disabled" => true
                    ],
                    "vip" => [
                        "title" => "VIP объявление",
                        "image" => "/img/select-pro/vip.png",
                        "disabled" => true
                    ]
                ]
            ],
            "fast_package" => [
                "title" => "Быстрая продажа",
                "subtitle" => "18х больше просмотров",
                "price" => $fast['val'],
                "old_price" => ($fast['val'] * 2) - 10,
                "features" => [
                    "light" => [
                        "title" => "Выделенное объявление на 9 дней",
                        "image" => "/img/select-pro/kite.png"
                    ],
                    "raise" => [
                        "title" => "9 поднятий вверх списка (ежедневно)",
                        "image" => "/img/select-pro/refresh.png"
                    ],
                    "vip" => [
                        "title" => "VIP объявление",
                        "image" => "/img/select-pro/vip.png",
                        "disabled" => true
                    ]
                ]
            ],
            "turbo_package" => [
                "title" => "Турбо продажа",
                "subtitle" => "36х больше просмотров",
                "price" => $turbo['val'],
                "old_price" => ($turbo['val'] * 2) - 15,
                "features" => [
                    "light" => [
                        "title" => "Выделенное объявление на 21 день",
                        "image" => "/img/select-pro/kite.png"
                    ],
                    "raise" => [
                        "title" => "12 поднятий вверх списка (ежедневно)",
                        "image" => "/img/select-pro/refresh.png"
                    ],
                    "vip" => [
                        "title" => "VIP объявление на 21 день",
                        "image" => "/img/select-pro/vip.png"
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
