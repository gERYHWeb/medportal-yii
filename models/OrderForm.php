<?php
namespace app\models;

use yii\base\Model;

class OrderForm extends Model
{
	public $order_id;
	public $first_name;
	public $last_name;
	public $patronymic;
	public $email;
	public $specialization;
	public $degree;
	public $status;
	public $date;
	public $description;
	
    public function rules()
    {
        return [
            ['first_name', 'required', 'message' => 'invalid_firstname'],
            ['last_name', 'required', 'message' => 'invalid_lastname'],
            ['patronymic', 'required', 'message' => 'invalid_patronymic'],
            ['email', 'required', 'message' => 'invalid_email'],
            ['specialization', 'required', 'message' => 'invalid_spec'],
            ['degree', 'required', 'message' => 'invalid_degree']
        ];
    }
}

?>