<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SignUpForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class=" text-center">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Please fill out the following fields to chenge of Profile:</p>
    </div>


    <?php
    $form = ActiveForm::begin([
                'id' => 'profile-form',
                'layout' => 'horizontal',
                'action' => 'user-profile',
                'method' => 'post'
                    /* 'fieldConfig' => [
                      'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                      'labelOptions' => ['class' => 'col-lg-1 control-label'],
                      ], */
    ]);
    ?>
    <?php isset($this->params["profile_data"]['name']) ? $name = $this->params["profile_data"]['name'] : $name = '';
    echo $form->field($model, 'name')->textInput(['value' => "$name"]);
    ?>

    <?php
    isset($this->params["profile_data"]['first_name']) ? $first_name = $this->params["profile_data"]['first_name'] : $first_name = '';
    echo $form->field($model, 'first_name')->textInput(//['autofocus' => true,
            ['value' => "$first_name"]); //var_dump($form->field($model, 'login')->textInput()) 
    ?>

    <?php isset($this->params["profile_data"]['last_name']) ? $last_name = $this->params["profile_data"]['last_name'] : $last_name = '';
    echo $form->field($model, 'last_name')->textInput(['value' => "$last_name"])
    ?>

    <?php //$form->field($model, 'name')->textInput()->hint('Enter your name') ?>

    <?php isset($this->params["profile_data"]['email']) ? $email = $this->params["profile_data"]['email'] : $email = '';
    echo $form->field($model, 'email')->textInput(['value' => "$email"])
    ?>

    <?php isset($this->params["profile_data"]['mobile_number']) ? $mobile_number = $this->params["profile_data"]['mobile_number'] : $mobile_number = '';
    echo $form->field($model, 'mobile_number')->textInput(['value' => "$mobile_number"])
    ?>

    <?php isset($this->params["profile_data"]['phone']) ? $phone = $this->params["profile_data"]['phone'] : $phone = '';
    echo $form->field($model, 'phone')->textInput(['value' => "$phone"])
    ?>

    <?php isset($this->params["profile_data"]['address']) ? $address = $this->params["profile_data"]['address'] : $address = '';
    echo $form->field($model, 'address')->textInput(['value' => "$address"])
    ?>

    <?php isset($this->params["profile_data"]['about']) ? $about = $this->params["profile_data"]['about'] : $about = '';
    echo $form->field($model, 'about')->textInput(['value' => "$about"])
    ?>

    <?php isset($this->params["profile_data"]['id_currency']) ? $id_currency = $this->params["profile_data"]['id_currency'] : $id_currency = '';
    echo $form->field($model, 'id_currency')->dropDownList(['0' => 'USD (exempl)',
                                                            '1' => 'TG (exempl)',
                                                            '2' =>'RUR (exempl)',
                                                            '3' => 'UAH (exempl)'])
    ?>

    <?php isset($this->params["profile_data"]['keywords']) ? $keywords = $this->params["profile_data"]['keywords'] : $keywords = '';
    echo $form->field($model, 'keywords')->textInput(['value' => "$keywords"])
    ?>

    <?php /* $form->field($model, 'radioList')->radioList([
      '1' => 'Private person',
      '0' => 'Company',
      ])->label(''); ?>

      <?php $form->field($model, 'checkbox')->checkbox([
      'label' => 'I agree with the terms',
      'labelOptions' => [
      'style' => 'padding-left:20px;'
      ],
      //'disabled' => false
      ]); */ ?>

    <?php //var_dump($form);// $form->field($model, 'verifyCode')->widget(Captcha::className()) ?>

    <div class="col-lg-offset-4" style="color: red;">
        <?php echo is_string($res['data']) ? $res['data'] : '';   //print_r($res['data']);   ?>
        <!--You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        To modify the username/password, please check out the code <code>app\models\User::$users</code>.-->
    </div>

    <div class="text-center" style="color: red; padding-bottom: 20px;">
        <?php echo is_string($res['result']) ? $res['result'] : ''; ?>
    </div>

    <div class="form-group">
        <div class="text-center">
            <?= Html::submitButton('Save Profile', ['class' => 'btn btn-warning', 'name' => 'save-profile-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>


    <div class="col-lg-offset-1" style="color:#999;">
        <?php //   print_r($res);   ?>
        <!--You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        To modify the username/password, please check out the code <code>app\models\User::$users</code>.-->
    </div>
</div>


