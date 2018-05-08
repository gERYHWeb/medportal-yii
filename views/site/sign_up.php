<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SignUpForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Sign Up';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    
    <div class="text-center">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Please fill out the following fields to sign up or sign in:</p>
    </div>
    
    
    <?php $form = ActiveForm::begin([
        'id' => 'sign-up-form',
        'layout' => 'horizontal',
        'action' => 'sign-up',
        'method' => 'post'
        /*'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],*/
    ]); ?>
        <?php echo $form->field($model, 'login')->textInput(['autofocus' => true]); //var_dump($form->field($model, 'login')->textInput()) ?>
        
        <?php echo $form->field($model, 'password')->passwordInput() ?>
    
        <?php echo $form->field($model, 'password_repeat')->passwordInput()->hint('Enter password again') ?>
        
        <?php echo $form->field($model, 'name')->textInput()->hint('Enter your name') ?>

        <?php echo $form->field($model, 'email')->input('email') ?>
    
        <?php echo $form->field($model, 'phone')->input('phone') ?>
    
        <?php echo $form->field($model, 'radioList')->radioList([
                                                        '1' => 'Private person',
                                                        '0' => 'Company',
                                                    ])->label(''); ?>
    
        <?= $form->field($model, 'checkbox')->checkbox([
                                                'label' => 'I agree with the terms',
                                                'labelOptions' => [
                                                    'style' => 'padding-left:20px;'
                                                ],
                                                //'disabled' => false
                                            ]); ?>

        <?php //var_dump($form);// $form->field($model, 'verifyCode')->widget(Captcha::className())?>
    
        <div class="col-lg-offset-4" style="color: red;">
            <?php  echo is_string($res['data']) ? $res['data']:'';   //print_r($res['data']);  ?>
            <!--You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
            To modify the username/password, please check out the code <code>app\models\User::$users</code>.-->
        </div>

        <div class="form-group">
            <div class="col-lg-offset-5 col-lg-7">
                <?= Html::submitButton('Sign Up', ['class' => 'btn btn-warning', 'name' => 'sign-up-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    
    <div class="col-lg-offset-1" style="color:#999;">
        <?php  //   print_r($res);  ?>
        <!--You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        To modify the username/password, please check out the code <code>app\models\User::$users</code>.-->
    </div>
</div>


