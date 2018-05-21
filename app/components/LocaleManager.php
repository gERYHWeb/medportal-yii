<?php
namespace app\components;

use yii\base\Component;

class LocaleManager extends Component
{
    protected $app;
    protected $request;
    protected $currencies = [];
    protected $countries = [];
    protected $languages = [];
    protected $cities = [];
    protected $language = 'ru';
    protected $currency = 'KZT';
    protected $country = 'kz';

    /**
     * Initializes this component for sending restfull requests.
     */
    public function init()
    {
        parent::init();
        $app = $this->app = \Yii::$app;
        $this->request = $app->request;
    }

    public function getCurrency($type = null)
    {
        if($type == 'code') {
            return $this->currency;
        }
        $currencies = $this->currencies;
        $currency = $this->currency;
        $result = null;
        foreach ($currencies as $curr) {
            if($curr['code'] == $currency){
                $result = $curr;
            }
        }
        return ($type) ? $result[$type] : $result;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getLanguage($type = null)
    {
        if($type == 'code') {
            return $this->language;
        }
        $languages = $this->languages;
        $language = $this->language;
        $result = null;
        foreach ($languages as $lang) {
            if($lang['iso_code'] == $language){
                $result = $lang;
            }
        }
        return ($type) ? $result[$type] : $result;
    }

    public function priceTransform($price = 0)
    {
        $currency = $this->getCurrency();
        $result = "";
        if($currency){
            $symb = $currency['symbol'];
            $tmpl = $currency['price_tmpl'];
            $result = str_replace('{price}', $price, $tmpl);
            $result = str_replace('{symbol}', $symb, $result);
        }
        return $result;
    }

    public function setCurrencies($currencies = [])
    {
        $result = [];
        foreach ($currencies as $currency) {
            $result[$currency['code']] = $currency;
        }
        return $this->currencies = $result;
    }

    public function setLanguages($languages = [])
    {
        return $this->languages = $languages;
    }

    public function setCountries($countries = [])
    {
        return $this->countries = $countries;
    }

    public function setCities($cities = [])
    {
        return $this->cities = $cities;
    }

    public function setLanguage($language = null)
    {
        if(!$language) {
            return false;
        }
        $languages = $this->languages;
        if(isset($languages[$language])){
            $this->language = $language;
            return $language;
        }
        return false;
    }
}