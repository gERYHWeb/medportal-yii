<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\SignUpForm */

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\Collapse;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

use yii\widgets\Breadcrumbs;
use yii\widgets\Pjax;
use app\models\User;

function msgTemplate($val){ ?>
    <tr class="tr-message<?php
       echo (!$val['is_read']) ? ' tr-message--active' : "";
    ?>">
        <td>
            <a href="/profile-message-chat/<?php echo $val['id_ads']; ?>"><?php echo User::fullName($val['from_user']); ?></a>
        </td>
        <td class="date">
            <a href="/profile-message-chat/<?php echo $val['id_ads']; ?>" class="mess-info"><?php echo date( "d.m.y H:i:s", strtotime( $val['date_create'] ) ); ?></a>
        </td>
        <td>
            <a href="/profile-message-chat/<?php echo $val['id_ads']; ?>" class="mess-info">
                <span class="mess-info__title title"><?php echo $val['advert']['title']; ?></span>
                <span class="mess-info__text text"><?php echo $val['value']; ?></span>
            </a>
        </td>
    </tr>
<?php } ?>

<?php echo Breadcrumbs::widget( [ 'links' => isset( $this->params['breadcrumbs'] ) ? $this->params['breadcrumbs'] : [], ] ); ?>

<div class="my-message-container">
    <h2>Сообщения</h2>

    <div class="content-message">

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-head">
                    <div class="btn-group">
                        <a href="/profile-message/inbox" class="btn btn-inverse<?php if($type == "inbox") echo ' active'; ?>">Входящие</a>
                        <a href="/profile-message/outbox" class="btn btn-inverse<?php if($type == "outbox") echo ' active'; ?>">Исходящие</a>
                    </div>
					<?php if ( ( isset( $model["inbox"] ) && count( $model["inbox"] ) > 10 ) || ( isset( $model["outbox"] ) && count( $model["outbox"] ) > 10 ) ) { ?>
                        <div class="search-mess-box">
                            <input type="text" id="text_search" placeholder="Поиск...">
                            <button type="submit" class="btn">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
					<?php } ?>
                </div>
				<?php
				//Pjax::begin( [ 'id' => 'container_message' ] );
				if ( (isset($model[$type]) && count( $model[$type] ) > 0)) { ?>
                <div class="table-container">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width:17%;">Пользователь</th>
                            <th style="width:17%;">Дата</th>
                            <th style="width:55%;">Сообщение</th>
                        </tr>
    					<?php
						if ( isset( $model[$type] ) && count( $model[$type] ) > 0 ) {
							foreach ( $model[$type] as $val ) {
                                msgTemplate($val);
							}
						}

//						if ( isset( $model["outbox"] ) && count( $model["outbox"] ) > 0 ) {
//							foreach ( $model["outbox"] as $val ) {
//							    msgTemplate($val);
//                            }
//						}

						if(count( $model[$type] ) < 1){ ?>
							<tr>
                                <td colspan="4">
                                    <p class="title-not-content">- Сообщений нет -</p>
                                </td>
                            </tr>
						<?php }else{ ?>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                       <?php } ?>
                    </table>
                </div>
                <?php
				} else {
                    echo "У Вас ещё нет сообщений";
				}
                ?>
                <?php //Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function search_message() {
        var form_data = new FormData();
        form_data.append('text_search', $("#text_search").val());
        $.ajax({
            type: "POST",
            url: '/mess-search',
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function (data, textStatus) {
                $.pjax.reload({container: '#container_message'});

                $('.fa-search').click(function () {
                    search_message();
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    };

    $(document).ready(function act() {
        $('.fa-search').click(function () {
            search_message();
        });
    });


</script>

