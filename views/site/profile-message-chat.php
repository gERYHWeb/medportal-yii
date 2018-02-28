<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\bootstrap\Collapse;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Pjax;
$ilName = (
        (isset($interlocutor['first_name'])) ? $interlocutor['first_name'] .
            ((isset($interlocutor['last_name'])) ? " " . $interlocutor['last_name'] : "")
            : $interlocutor['nickname']
    );
?>
<div class="my-message-container">
    <h2>Сообщение</h2>

    <div class="chat-container ">
        <div class="chat">
            <div class="chat-header clearfix">
                <div class="left">
                    <img src="/img/profile/user.svg" alt="avatar"/>
                    <div class="chat-about">
                        <div class="chat-with">Чат с <?php echo $ilName; ?></div>
                    </div>
                </div>
                <div class="right"></div>
            </div>
	        <?php Pjax::begin( [ 'id' => 'container_message', 'timeout' => 5000 ] ); ?>
            <div class="chat-history js-chat-container" data-count="<?php echo count($model); ?>">
                <ul>
					<?php
					$prEvent   = true;
					$str       = '';
					$id_parent = 0;
					$id_to     = 0;
                    $idAds = 0;
					if ( isset( $model[0]["to_user"] ) ) {
						$id_to_user = $model[0]["to_user"];
						$id_parent = $model[0]['id_message'];
                        $idAds = $model[0]['id_ads'];
						foreach ( $model as $val ) {
							if ( isset( $val ) && isset( $val["value"] ) && $val["value"] != "" ) {
								//if ( $prEvent == true ) {

                                $class = ($this_user['id_user'] == $val['from_user']) ? "isSelf" : "isInterlocutor";
                                $nickname = ($this_user['id_user'] == $val['from_user']) ? "Ваше сообщение" :
                                    $val['from_user_name'] . '(' . $val['from_nickname'] . ')';
								if ( $id_to_user != $val['from_user'] ) {
									//	$prEvent = false;
									$str .= '<li class="clearfix ' . $class . '">
                                                    <div class="message-data">
                                                    <span class="message-data-time">'
									        . date( "d.m.y", strtotime( $val['date_create'] ) )
									        . "&nbsp;&nbsp;&nbsp;"
									        . date( "H:i:s", strtotime( $val['date_create'] ) ) .
									        '</span> &nbsp; &nbsp;
                                                            <span class="message-data-name">' . $nickname . '</span>
                                                            <i class="fa fa-circle me"></i>
                                                        </div>
                                                        <div class="message other-message">
                                                            ' . $val['value'] . '
                                                        </div>';
								} else {
									//	$prEvent = true;
									$str .= '<li class="clearfix ' . $class . '">
                                                    <div class="message-data">
                                                    <span class="message-data-time">'
									        . date( "d.m.y", strtotime( $val['date_create'] ) )
									        . "&nbsp;&nbsp;&nbsp;"
									        . date( "H:i:s", strtotime( $val['date_create'] ) ) .
									        '</span> &nbsp; &nbsp;
                                                    <span class="message-data-name">' . $nickname . '</span>
                                                    <i class="fa fa-circle me"></i>
                                                </div>
                                                <div class="message other-message">
                                                    ' . $val['value'] . '
                                                </div>';
								}
								$str       .= '</li>';
							}
						}
					}
					echo $str;
					?>
                </ul>
            </div>
	        <?php Pjax::end(); ?>
            <form id="SendMessageForm" class="chat-message clearfix">
                <input type="hidden" name="token" value="<?php echo $this->params["token"]; ?>">
                <input type="hidden" name="into_account" value="true">
                <input type="hidden" name="id" value="<?php echo $idAds; ?>">
                <textarea name="message" id="messagetosend" placeholder="Ваше сообщение" rows="3"></textarea>
                <!--
											<a href="#" class="add-file"><i class="fa fa-paperclip" aria-hidden="true"></i> Прикрепить
												файл</a>
				-->
                <div hidden class="form-group" style="width: 80%; float: left;">
                    <div class="label-box">
                        <input type="checkbox" id="is_lament" class="checkbox"
                               name="want">
                        <label for="is_lament" class="checkbox-label">Отправить Администратору сайта, как жалобу</label>
                    </div>
                </div>
                <button id="btn_save" class="btn">Отправить</button>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">

    var timerId;

    function validation_form_send() {
        var result = true;
        $("#messagetosend").removeClass("error");
        if ($.trim($("#messagetosend").val()) == "") {
            $("#messagetosend").addClass("error");
            result = false;
            $('html, body').animate({scrollTop: $("#messagetosend").offset().top}, 800);
        }
        return result;
    }

    function btn_save(e) {
        e.preventDefault();
        var $form = $(this);
        if (validation_form_send()) {
            //form_data.append('title', '');

            $.ajax({
                type: "POST",
                url: '/send-message',
                dataType: "json",
                data: $form.serialize(),
                success: function (data, textStatus) {
                    if (data != undefined && data.result != undefined) {
                        if (data.result == true) {
                            Notification.showSuccess("Сообщение было отправлено!");
                            $("#messagetosend").val("");
                            update_message();
                        } else {
                            if ( data.data != undefined && data.data != "") {
								Notification.showWarning(data.data);
							} else {
								Notification.showWarning("Возникли проблемы, обратитесь к администратору сайта");
							}
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    Notification.showError(thrownError, "Ошибка");
                }
            });
        }
    }

    function update_message() {
        $.pjax.reload({container: '#container_message', async: false});
    }

    $(document).ready(function () {
        $("#SendMessageForm").on('submit', btn_save);
//js-chat-container
        timerId = setInterval(function(){
            var id = (location.pathname).replace(/.*\/([0-9]*)$/, "$1");
            $.post('/check-msgs', { id: id }, function(data){
                var current = $('.js-chat-container').data('count');
                if(current < data.count){
                    update_message();
                }
            });
        }, 5000);
    });
</script>
