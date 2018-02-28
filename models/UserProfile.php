<?php

namespace app\models;

use Yii;
use yii\base\Model;

class UserProfile extends Model {

    public $title;
    public $description;
    public $first_name;
    public $last_name;
    public $email;
    public $mobile_number;
    public $about;
    public $meta_title;
    public $meta_desc;
    public $keywords;
    public $id_currency;
    public $phone;
    public $address;
    public $name;

    public function rules() {

        return [
            [['first_name', 'last_name', 'name'], 'string'],
            [['first_name', 'last_name', 'name'], 'trim'],
            ['email', 'email'],
            ['phone', 'number']
        ];
    }

    //public function getProfile() {
        //Обращается к actionGetProfile() для получения данных профиля пользователя.
        //Или не так! Переход на страницу профиля выполнить через actionGetProfile()
        // с получением данных из базы данных
    //}

    // Потом делаем геттеры для передачи в actionUpdateProfile().

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getMobileNumber() {
        return $this->mobile_number;
    }

    public function getAbout() {
        return $this->about;
    }

    public function getMetaTitle() {
        return $this->meta_title;
    }

    public function getMetaDesc() {
        return $this->meta_desc;
    }

    public function getKeywords() {
        return $this->keywords;
    }

    public function getIdCurrency() {
        return $this->id_currency;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getName() {
        return $this->name;
    }

}
