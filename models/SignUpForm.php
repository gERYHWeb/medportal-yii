<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignUpForm extends Model{
    
    
    public $login;
    public $password;
    public $password_repeat;
    public $name;
    public $email;
    public $phone;
    public $radioList;
    public $checkbox;
    public $verifyCode;

    public function rules() {
        
        
        return [
	        ['login','trim'],
	        ['password','trim'],
                ['password_repeat', 'trim'],
                 ['password', 'compare'],
	        ['login','string','min'=>2,'max'=>255],
                ['name', 'string'],
	        ['login', 'trim'],
                ['phone', 'number'],
                ['radioList', 'integer'],
	        [['password', 'password_repeat'],'string','min'=>6],
            //['radioList', 'boolean'],
            // name, email, subject and body are required
            [['email', 'login', 'password', 'password_repeat', 'checkbox'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            //['checkbox', 'boolean'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ]; //parent::rules();
    }

    /*
    * Сюда нужно вернуть данные из вьюшки по $model в переменные модели SignUpForm
    */
    public function setUserData() {
        // Наверное скорее всего нужно этот запрос делать в SiteController
        //Utility::postData($url, $post_string, $user, $password);
        /*
         * Здесь нужно передать данные формы на restController,
         *  который отправит данные в админ-часть на UserController
         */
        
        //$user_data = 
    }

	/**
	 * @return mixed
	 */
	public function getLogin() {
		return $this->login;
	}

	/**
	 * @return mixed
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return mixed
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * @return mixed
	 */
	public function getRadioList() {
		return $this->radioList;
	}

	/**
	 * @return mixed
	 */
	public function getCheckbox() {
		return $this->checkbox;
	}

	/**
	 * @return mixed
	 */
	public function getVerifyCode() {
		return $this->verifyCode;
	}
}

