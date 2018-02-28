<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Create An Ad';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class="text-center">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Please fill out the following fields to create an ad:</p>
    </div>


    <?php
    $form = ActiveForm::begin([
                'id' => 'sign-up-form',
                'layout' => 'horizontal',
                'action' => '/sign-up',
                'method' => 'post',
                'options' => ['enctype' => 'multipart/form-data']
                    /* 'fieldConfig' => [
                      'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                      'labelOptions' => ['class' => 'col-lg-1 control-label'],
                      ], */
    ]);
    ?>

    <?php $form->field($model, 'name')->textInput()->hint('Enter your name')  ?>

    <?php $form->field($model, 'email')->input('email')  ?>

    <?php $form->field($model, 'phone')->input('phone') ?>

    <?php
    $form->field($model, 'radioList')->radioList([
                                              '1' => 'Private person',
                                            '0' => 'Company',
                                      ])->label('');
    ?>

    <?php
    echo $form->field($model, 'categories')->dropDownList(['A' => 'Category A',
        'B' => 'Category B'], ['prompt' => 'Select a category'], ['autofocus' => true])
    ?>

    <?php echo $form->field($model, 'title')->textInput(); //var_dump($form->field($model, 'login')->textInput())  ?>

    <?php echo $form->field($model, 'content')->textarea(['rows' => 5, 'cols' => 5])->label('Content of ad'); ?>




    <!--
    <div>
        <input type="button" >
    </div>
    -->

    <!-- <div class="row">-->
    <!-- <div class="col-md-offset-5 col-lg-offset-5 col-xs-3 col-md-3 col-lg-3">
       <a href="#" class="thumbnail">
         <img data-src="holder.js/100%x100" src="/images/fasteners.jpg"  alt="...">
       </a>

     </div>-->

<!--    <input type="image" src="/images/fasteners.jpg" border="2" width="100" height="75" > -->

    <?php // $form_upload = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])  ?>

    <?php
    //$form->field($model, 'imageFiles[]')->fileInput(['multiple' => true,
    //'accept' => 'image/*',
    //'class' => 'btn btn-warning'])
    ?>

    <!--<button>Submit</button>-->

    <?php // ActiveForm::end()  ?>

    <?php //echo $form->field($model, 'imageFile[]')->fileInput(['multiple' => 'multiple']);  ?>

    <?php //$form->field($model, 'password')->passwordInput()  ?>

    <?php //$form->field($model, 'password_repeat')->passwordInput()->hint('Enter password again')  ?>

    <?php //$form->field($model, 'name')->textInput()->hint('Enter your name')  ?>

    <?php //$form->field($model, 'email')->input('email')  ?>

    <?php //$form->field($model, 'phone')->input('phone') ?>

    <?php
    //$form->field($model, 'radioList')->radioList([
    //                                          '1' => 'Private person',
    //                                        '0' => 'Company',
    //                                  ])->label('');
    ?>

    <?php /* $form->field($model, 'checkbox')->checkbox([
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

    <div class="form-group">

        <div class="col-lg-offset-5 col-lg-7">
            <p><?= Html::submitButton('Add An Ad', ['class' => 'btn btn-warning', 'name' => 'sign-up-button']) ?></p>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

    <form action="/send-img" name="send-img" id="sendimg" enctype="multipart/form-data" method="POST">
        <div class=" form-group" id="divform">
            <div class="col-lg-offset-5 col-lg-7" id="divbtn">
                <label for="uploadbtn" class="btn btn-default " style="display: inline">Select file</label>
                <input type="file" accept="image/jpeg, image/pjpeg" style="opacity: 0; z-index: -1; display: none" name="upload-img[]" id="uploadbtn" onchange="imgName()">
                <button type="button" class="btn btn-default col-xs-1 col-md-1 col-lg-1" name="btn_plus"  id="btn_plus1" style="display: inline" onclick="plusOne()"><i class="fa fa-plus plus" aria-hidden="true"></i></button>
            </div>
        </div>
    <!--
        <div class="form-group col-md-offset-3 col-xs-4 col-md-4 col-lg-4">
            <label for="uploadbtn2" class="btn" id="btn_send2" style="display: none"><span>Select file</span></label>
            <input type="file" accept="image/jpeg, image/pjpeg" style="opacity: 0; z-index: -1; display: none" name="upload-img[]" id="uploadbtn2">
            <a href="" class="btn " id="btn_plus2" style="display: inline">
                <i class="fa fa-plus plus" aria-hidden="true"></i>
            </a>
        </div>
    -->
        <input type="submit" value="Send Image" class="form-group btn  col-xs-3 col-md-3 col-lg-3">
    </form>

    <script type="text/javascript">
        function plusOne() {
            var btn = document.getElementsByName('btn_plus');
            for (var i = 0; i < btn.length; i++){
                //console.log(btn[i]);
                var btnEl = btn[i];
                //console.log(btnEl);
                btnEl.setAttribute('style', 'display: none');
            };
            var one = Date.now();
            $("#divform").append('<div class="col-lg-offset-5 col-lg-7" id="divbtn' + one + '">\n' +
                                            '<label for="uploadbtn' + one + '" class="btn btn-default " style="display: inline">Select file</label>\n' +
                                            '<input type="file" accept="image/jpeg, image/pjpeg" style="opacity: 0; z-index: -1; display: none" name="upload-img[]" id="uploadbtn' + one + '" onchange="imgName()">\n' +
                                            '<button type="button" class="btn btn-default col-xs-1 col-md-1 col-lg-1" name="btn_plus"  id="btn_plus' + one + '" style="display: inline" onclick="plusOne()"><i class="fa fa-plus plus" aria-hidden="true"></i></button>\n' +
                                        '</div>\n');
        };
    </script>

    <script type="text/javascript">
        function imgName (){
            var arrName = document.getElementsByName('upload-img[]');
                arrName.forEach ( function( item, i, arrName ) {
                    console.log(item.value);
                });
        };

    /*    var arrName = document.getElementsByName('upload-img[]'[0]);
        //var arrName = $('[name = upload-img[]]');
        console.log(arrName.value);
            //arrName.onchange =
                    forEach( function ( item, i, arrName){
                 //for (var i = 0; i < arrName; i++){

                console.log(arrName[i]);
                    /*function(){

                var imgName = arrName[i];


            });*/
        //}
                //);



    </script>
    <!--
        <script type="text/javascript" src="/jquery-3.2.1.js">

        </script>-->
    <!--
    <script >
        $(document).ready(function () {
            $("#btn_plus1").click(function () {
                $("body").append($("#btn_send2").copy())
            });
        });
    </script>
    -->
<!--
    <script>
        function plusTwo() {
            var mvp = document.getElementById('btn_send2');
            console.log(mvp);
            mvp.setAttribute('style', 'display: inline');
        }
    </script>
-->
    <!--
    <script>
        var div_form = document.createElement('div');
            div_form.className = "form-group";
            //div_form.id = "divform3";
            div_form.innerHTML = "KU-KU";
        var div_btn = document.createElement('div');
            div_btn.className = "col-lg-offset-5 col-lg-7";
            div_btn.id = "divbtn3";
            div_btn.innerHTML = "KU-KU";
        var label_up = document.createElement('label');
            label_up.for = "uploadbtn";
            label_up.className = "btn";
            label_up.id = "btn_send3";
            label_up.style = "display: inline";
            label_up.innerHTML = "Select file";
        var input_up = document.createElement('input');
            input_up.type = "file";
            input_up.accept = "image/jpeg, image/pjpeg";
            input_up.style = "opacity: 0; z-index: -1; display: none"; //setAttribute
            input_up.name = "upload-img[]";
            input_up.id = "uploadbtn";
        var btn_plus = document.createElement('button');
            btn_plus.type = "button";
            btn_plus.className = "btn btn-default col-xs-1 col-md-1 col-lg-1";
            btn_plus.onclick = "plusOne()";
            btn_plus.innerHTML = "<i class="fa fa-plus plus" aria-hidden="true"></i>";

        sendimg.appendChild(div_form);




    </script>
    -->