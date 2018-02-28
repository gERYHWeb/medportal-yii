<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders">
    <h1><?php echo Html::encode($this->title) ?></h1>

        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th>Ф.И.О.</th>
                <th>E-mail</th>
                <th>Описание</th>
                <th>Специализация</th>
                <th>Степень</th>
                <th>Дата</th>
                <th>Статус</th>
            </tr>
            <?php if ($orders){ ?>
            <?php foreach ($orders as $order) { ?>
            <tr>
                <td><?php echo $order['order_id'] ?></td>
                <td><?php echo $order['first_name'] . " " . $order['last_name'] . " " . $order['patronymic'] ?></td>
                <td><?php echo $order['email'] ?></td>
                <td><?php echo $order['description'] ?></td>
                <td><?php echo $order['specialization']['value'] ?></td>
                <td><?php echo $order['degree']['value'] ?></td>
                <td><?php echo $order['date'] ?></td>
                <td><?php echo (!$order['status']) ? 'Новая <a href="/order-status?id=' . $order['order_id'] . '&status=1"><i>Обработать</i></a>' : "Обработанная" ?></td>
            </tr>
            <?php } ?>
            <?php }else{ ?>
            <tr>
                <td colspan="8"><h2>Нет данных для отображения</h2></td>
            </tr>
            <?php } ?>
        </table>
</div>
