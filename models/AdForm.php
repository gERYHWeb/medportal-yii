<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class AdForm extends Model{
    
    
    public $title;
    public $categories;
    public $content;
    public $imageFiles;
    public $email;
    public $phone;
    public $radioList;
    public $checkbox;
    public $verifyCode;
    public $name;

    public function rules() {
        
        
        return [
	        ['title','trim'],
                [['categories', 'title', 'content', 'name'], 'string'],
                [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg','maxFiles' => 4],
	        //['categories','trim'],
                //['password_repeat', 'trim'],
                 //['password', 'compare'],
	        //['login','string','min'=>2,'max'=>255],
                
	        //['login', 'trim'],
                ['phone', 'number'],
                ['radioList', 'integer'],
	        //[['password', 'password_repeat'],'string','min'=>6],
            //['radioList', 'boolean'],
            // name, email, subject and body are required
            //[['email', 'login', 'password', 'password_repeat', 'checkbox'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            //['checkbox', 'boolean'],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],
        ]; //parent::rules();
    }

     public function upload()
    {
        if ($this->validate()) { 
            foreach ($this->imageFiles as $file) {
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }

	/**
	 * @return mixed
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return mixed
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * @return mixed
	 */
	public function getContent() {
		return $this->content;
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


