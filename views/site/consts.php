<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\Consts;

$this->title = 'Справочники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consts">
    <h1><?php echo Html::encode($this->title) ?></h1>

        <table class="table table-bconsted">
            <tr>
                <th>#</th>
                <th>Тип</th>
                <th>Значение</th>
            </tr>
            <?php if ($consts){ ?>
            <?php foreach ($consts as $const) { ?>
            <tr>
                <td><?php echo $const['const_id'] ?></td>
                <td><?php echo Consts::getType($const['type']) ?></td>
                <td>
                    <form action="/edit-const">
                        <input type="hidden" name="id" value="<?php echo $const['const_id'] ?>">
                        <input type="text" name="data[value]" value="<?php echo $const['value'] ?>" class="form-control">
                    </form>
                </td>
            </tr>
            <?php } ?>
            <?php }else{ ?>
            <tr>
                <td colspan="8"><h2>Нет данных для отображения</h2></td>
            </tr>
            <?php } ?>
        </table>
</div>
