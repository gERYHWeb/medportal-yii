<?php

namespace app\models;

use Yii;

class Advert extends \yii\base\Object
{
    public static function getPrice($val)
    {
        $price = isset($val['price']) ? $val['price'] : 0;

        $return = ($price > 0) ? Yii::$app->locale->priceTransform($price) : "";
        $return .= ($val['is_contract_price']) ?
            (
            ($price > 0) ?
                "<span class='is-contract-price'> (договорная)</span>" :
                "<span class='is-contract-price'>Договорная цена</span>"
            ) : "";
        return $return;
    }
}
