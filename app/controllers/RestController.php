<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Utility;
use app\models\SimpleImage;

class RestController extends WebController {

	public $layout = 'rest';
	private $result;
	private $postValue;
	private $getValue;
	private $request;
	private $session;

	private $arr_authorized = [
		"actionSendMessage",
		"actionCheckMsgsById",
		"actionGetPhoneUser",
		"actionGetCity",
		"actionSaveProfile",
		"actionSaveAdvert",
		"actionMyAdverts",
		"actionAddAdvertFavorite",
		"actionRemoveAdvertFavorite",
		"actionDeleteImage",
		"actionUploadImage",
		"actionDeleteAdvert",
		"actionSignIn",
		"actionSignUp",
		"actionDeleteAccount",
		"actionAddMoney",
		"actionLiftupAdvert",
		"actionFeedback",
		"actionAddProAdvert",
		"actionRestorePassword",
		"actionDeleteMessage"
	];

	public function actions() {
		return [ 'error' => [ 'class' => 'yii\web\ErrorAction', ], ];
	}

	public function beforeAction($action) {
		$this->result = [
			"result" => false,
			"data" => 'not_found'
		];

		if(isset($action) && isset($action->actionMethod) && in_array($action->actionMethod, $this->arr_authorized)) {
			return true;
		} else {
			if($this->post("token")) {
				if(Session::isOpenSession($this->post("token")) === true) {
					return true;
				}
			} else {
				if($this->get("token")) {
					if(Session::isOpenSession($this->get("token")) === true) {
						return true;
					}
				}
			}
		}
		$this->createResponse();
	}

	private function createResponse() {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=utf-8');

        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $this->result;

        return $response;
	}

	public function actionSendMessage() {
		if($this->request->isAjax) {
            $this->post("user_id") = $_SESSION['user_id'];
            $this->post("id_ads") = $this->post("id");
            //dd($this->postValue);
            if(!$_SESSION['user_id']){
                $this->result = [
                    "result" => false,
                    "msg" => "please_auth"
                ];
            }else if($this->post("user_id") == $this->post("to")){
                $this->result = [
                    "result" => false,
                    "msg" => "send_msg_to_self"
                ];
            }else{
                if($this->post("user_id")) {

                    $time = isset($_SESSION["callback"]) ? $_SESSION["callback"] : time();
                    if(time() < $time) {
                        if($this->post("into_account")) {
                            $this->result = [
                                "result" => false,
                                "error" => "timeout_callback_into_acc"
                            ];
                        }else{
                            $this->result = [
                                "result" => false,
                                "error" => "timeout_callback"
                            ];
                        }
                    } else {
                        $url = Yii::$app->params['root_rest_url'] . "message/send-message";
                        $post_string = http_build_query($this->postValue);

                        $_post_data = Utility::postData($url, $post_string);
                      //  dd($_post_data);
                        if(isset($_post_data["res"])) {
                            $tmp_data = json_decode($_post_data["res"], true);
                        }
//                        print_r($_post_data);exit();

                        $this->result = [
                            "result" => isset($tmp_data["result"]) ? $tmp_data["result"] : false
                        ];

                        if(!$tmp_data['result']){
                            $this->result['error'] = $tmp_data["data"];
                        }else{
                            if($this->post("into_account")) {
                                $_SESSION["callback"] = (time() + 5);
                            }else{
                                $_SESSION["callback"] = (time() +(60 * 5));
                            }
                            $this->result['msg'] = isset($tmp_data["data"]) ? $tmp_data["data"] : "success_msg";
                        }
                    }
                }
            }


		}
		$this->createResponse();
	}

	public function actionCheckMsgsById(){
        if($this->request->isAjax) {
            $post_url = Yii::$app->params['root_rest_url'] . 'message/get-chain-message';
            $post_string = http_build_query([
                "checkNewMsg" => true,
                "token" => $_SESSION['token'],
                "idMessage" => $this->post("id")
            ]);
            $_res = Utility::postData($post_url, $post_string);
            if(isset($_res["res"])) {
                $tmp_data = json_decode($_res["res"], true);
            }
            $this->result = [
                "count" => $tmp_data['data']
            ];
        }
        $this->createResponse();
    }

	public function actionGetPhoneUser() {
		if($this->request->isAjax) {
			if($this->post("advert_id")) {

				$url = Yii::$app->params['root_rest_url'] . "help/view-phone?view=1&advert_id=" . $this->post("advert_id");

				$_post_data = Utility::getData($url);

				if(isset($_post_data["res"])) {
					$tmp_data = json_decode($_post_data["res"], true);
				}

				$this->result = $tmp_data;
			}
		}
		$this->createResponse();
	}

	public function actionAddAdvertFavorite() {
		if($this->request->isAjax) {
			$url = Yii::$app->params['root_rest_url'] . "advert/add-advert-favorite";
			$post_string = http_build_query($this->postValue);

			$_post_data = Utility::postData($url, $post_string);
			if(isset($_post_data["res"])) {
				$tmp_data = json_decode($_post_data["res"], true);
			}

			$this->result = [
				"result" => isset($tmp_data["result"]) ? $tmp_data["result"] : false,
				"data" => ""
			];
		}
		$this->createResponse();
	}

	public function actionRemoveAdvertFavorite() {
		if($this->request->isAjax) {
			$url = Yii::$app->params['root_rest_url'] . "advert/remove-advert-favorite";
			$post_string = http_build_query($this->postValue);

			$_post_data = Utility::postData($url, $post_string);
			if(isset($_post_data["res"])) {
				$tmp_data = json_decode($_post_data["res"], true);
			}

			$this->result = [
				"result" => isset($tmp_data["result"]) ? $tmp_data["result"] : false,
				"data" => ""
			];
		}
		$this->createResponse();
	}

	public function actionUploadImage() {
		if($this->request->isAjax) {
			if(isset($_FILES["file"]) && isset($_FILES["file"]["name"]) && isset($_FILES["file"]["tmp_name"]) && isset($_FILES["file"]["tmp_name"][0])) {
				$tmp_file = $_FILES["file"]["tmp_name"][0];
				$name_file = $_FILES["file"]["name"][0];
				if(is_uploaded_file($tmp_file)) {
					$this->result = [
						"result" => move_uploaded_file($tmp_file, Yii::$app->params['folder_images_server'] . $name_file),
						"data" => ""
					];
				}
			}
		}
		$this->createResponse();
	}

	public function actionDeleteImage() {
		if($this->request->isAjax && $this->post("file")) {
			if(file_exists(Yii::$app->params['folder_images_server'] . $this->post("file"))) {
				$url = Yii::$app->params['root_rest_url'] . "advert/delete-image?image=" . $this->post("file");
				$_post_data = Utility::getData($url);
				if(isset($_post_data["res"])) {
					$tmp_data = json_decode($_post_data["res"], true);
					if(isset($tmp_data["result"]) && $tmp_data["result"] == true) {
						$path_info = pathinfo($this->post("file"));
						$name_file = $path_info['filename'] . "_media." . $path_info['extension'];
						unlink(Yii::$app->params['folder_images_server'] . $name_file);
						$name_file = $path_info['filename'] . "_small." . $path_info['extension'];
						unlink(Yii::$app->params['folder_images_server'] . $name_file);
						$this->result = [
							"result" => unlink(Yii::$app->params['folder_images_server'] . $this->post("file")),
							"data" => "OK"
						];
					}
				}
			}
		}
		$this->createResponse();
	}

	public function actionSaveAdvert() {
//	    if($_SESSION["in_process"]) return;
		if($this->request->isAjax) {
		    try {
                $time = isset($_SESSION["save_advert"]) ? $_SESSION["save_advert"] : time();
//                if(time() < $time ) {
//                    $this->result = [
//                        "result" => false,
//                        "data" => "timeout_saved_advert"
//				    ];
//			    } else {
                if(true){
                    $_SESSION["in_process"] = true;
                    $data = $_POST;
                    $forUploadFiles = [];
                    $files = [];
                    $files_main = '';
                    $pfFirstImage = true;

                    Yii::info("actionSaveAdvert: " . print_r($this->postValue, true));

                    if ($this->post("images") && $this->post("images")) {
                        $list_file = $this->post("images");
                        foreach ($list_file as $filename) {
                            if (file_exists(Yii::$app->params['folder_images_server'] . $filename)) {
                                $name_file = substr(Utility::translit($data["title"]), 0, 200) . "_" . md5(uniqid(rand(), true));
                                $path_info = pathinfo($filename);

                                if ($pfFirstImage) {
                                    $files_main = $name_file . "." . $path_info['extension'];
                                    $pfFirstImage = false;
                                } else {
                                    $files[] = $name_file . "." . $path_info['extension'];
                                }
                                $forUploadFiles[] = [
                                    $filename,
                                    $name_file,
                                    $path_info['extension']
                                ];
                            }
                        }
                        $data['images'] = $files;
                        $data['main_image'] = $files_main;
                    }
                        $data['id_currency'] = (int)$_SESSION['id_currency'];
                        $data['id_user'] = (int)$_SESSION['user_id'];
                        $data['token'] = $_SESSION['token'];
                        if (!$data['price']) {
                            $data['price'] = 0;
                        }

                        $url = Yii::$app->params['root_rest_url'] . "advert/edit-advert";
                        $post_string = http_build_query($data);

                        $_post_data = Utility::postData($url, $post_string);
                        Yii::info("actionSaveAdvert: " . print_r([$url, $post_string, $_post_data], true));

                        if (isset($_post_data["res"])) {
                            $tmp_data = json_decode($_post_data["res"], true);
                        }
                        $link = "";
                        $_SESSION["in_process"] = false;
                        if (isset($tmp_data["result"])) {
                            if ($tmp_data["result"]) {
                                $this->result = [
                                    "result" => true,
                                    "data" => isset($tmp_data["data"]) ? $tmp_data["data"] : "invalid_data"
                                ];
                                $files[] = $files_main;
                                if ($forUploadFiles) {
                                    foreach ($forUploadFiles as $file) {
                                        $filename = $file[0];
                                        $name_file = $file[1];
                                        $ext = $file[2];

                                        SimpleImage::load(Yii::$app->params['folder_images_server'] . $filename);
                                        SimpleImage::resize(Yii::$app->params['media_width'], Yii::$app->params['media_height']);
                                        SimpleImage::save(Yii::$app->params['folder_images_server'] . $name_file . "_media." . $ext);

                                        SimpleImage::load(Yii::$app->params['folder_images_server'] . $filename);
                                        SimpleImage::resize(Yii::$app->params['small_width'], Yii::$app->params['small_height']);
                                        SimpleImage::save(Yii::$app->params['folder_images_server'] . $name_file . "_small." . $ext);

                                        rename(Yii::$app->params['folder_images_server'] . $filename, Yii::$app->params['folder_images_server'] . $name_file . "." . $ext);

                                    }
                                }
                                $_SESSION["save_advert"] = (time() + (60 * 1));
                                if ($data['advertId'] == "new") {
                                    $link = '/message/success-added';
                                } else {
                                    $link = '/profile-my-ads';
                                }
                            }
                        }
                        if(!isset($tmp_data["result"]) || !$tmp_data["result"]) {
                            $this->result = [
                                "result" => false,
                                "error" => isset($tmp_data["data"]) ? $tmp_data["data"] : "invalid_data"
                            ];
                        }
                        if ($link) {
                            $this->result['redirect'] = $link;
                        }
                    }
            } catch(Exception $e) {
                $this->result = [
                    "result" => false,
                    "data" => "not_saved_advert",
                ];
                $_SESSION["in_process"] = false;
            }
		}
		$this->createResponse();
	}

	public function actionGetCity(){
        if($this->request->isAjax) {
            if($this->post("query")) {
                $query = Utility::clearString($this->post("query"));
                $url = Yii::$app->params['root_rest_url'] . "help/city?query=" . $query;

                $_post_data = Utility::getData($url);
//                print_r($_post_data);
//                exit();
                if(isset($_post_data["res"])) {
                    $tmp_data = json_decode($_post_data["res"], true);
                    //print_r($tmp_data);
                    //exit();
                }

                $this->result = $tmp_data;
            }
        }
        $this->createResponse();
    }

	public function actionSaveProfile() {
		$result = true;
        $this->result = [
            "msg" => "not_saved_profile"
        ];
		if(!isset($_SESSION['token'])){
            $this->result = [
                "msg" => [
                    "text" => "session_expired",
                    "redirect" => '/auth-reg/login'
                ]
            ];
        }else {
            if ($this->request->isAjax) {
                $this->post("id_user") = $_SESSION['user_id'];
//			if(isset($this->post("user_id") ) ) {
                if ($this->post("old_password") && $this->post("old_password") != "" &&
                    $this->post("new_password") && $this->post("new_password") != "" &&
                    $this->post("repeat_password") && $this->post("repeat_password") != ""
               ) {
                    if ($this->post("new_password") != $this->post("repeat_password")) {
                        $result = false;
                        $this->result = [
                            "result" => false,
                            "data" => "invalid_passwords_dont_match"
                        ];
                    } else {
                        $url = Yii::$app->params['root_rest_url'] . "user/check-exist-password";
                        $post_string = http_build_query($this->postValue);
                        $set_prof = Utility::postData($url, $post_string);

                        $_res = json_decode($set_prof["res"], true);
                        if ($_res["result"] != true) {
                            $result = false;
                            $this->result = [
                                "result" => false,
                                "data" => "invalid_curr_password"
                            ];
                        }
                    }
                }

                if ($result == true) {
                    $url = Yii::$app->params['root_rest_url'] . "user/profile";
                    $post_string = http_build_query($this->postValue);
                    $set_prof = Utility::postData($url, $post_string);

                    $_res = json_decode($set_prof["res"], true);
                    $_res["data"] = ($_res["data"] !== "not_found") ? $_res["data"] : "not_saved_profile";

                    $this->result = [
                        "result" => isset($_res["result"]) ? $_res["result"] : false,
                        "data" => isset($_res["data"]) ? $_res["data"] : "not_saved_profile",
                        "msg" => isset($_res["data"]) ? $_res["data"] : "not_saved_profile"
                    ];

                }
//			} else {
//				$this->result = [
//					"result" => false,
//					"data" => "Системная ошибка. Были переданны не все параметры."
//				];
//			}
            }
        }
		$this->createResponse();
	}

	public function actionDeleteAdvert() {
		if($this->request->isAjax) {
			if(isset($this->postValue) && $this->postValue != []) {
				$url = Yii::$app->params['root_rest_url'] . "advert/ads-delete";
				$post_string = http_build_query($this->postValue);
				$_post_data = Utility::postData($url, $post_string);

				if(isset($_post_data["res"])) {
					$tmp_data = json_decode($_post_data["res"], true);
					$this->result = [
						"result" => isset($tmp_data["result"]) ? $tmp_data["result"] : false,
						"data" => ""
					];
				}
			}
		}
		$this->createResponse();
	}

	public function actionSignUp() {
	    $post = $this->postValue;
		if($this->request->isAjax) {
			if($post["login"] &&
			     $post["password"] &&
			     $post["email"] &&
			     $post["check-term"]
			) {
                $errors = [];
			    if(!preg_match("/^[a-zA-Z0-9\_\-]{5,20}$/", $post["login"])){
                    $errors['username'] = "invalid_username";
                }
			    if(!preg_match("/^.{6,100}$/", $post["password"])){
                    $errors['password'] = "invalid_password";
                }
			    if(!preg_match("/^([a-zA-Z0-9_-]+\.)*[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*\.[a-zA-Z]{2,6}$/", $post["email"])){
                    $errors['email'] = "invalid_email";
                }
                if(!$errors) {
                    $form_data = [
                        'username' => $post["login"],
                        'password' => $post["password"],
                        'email' => $post["email"],
                        'ra' => ($post["check-term"] == "on") ? 1 : 0
                    ];

                    $url = Yii::$app->params['root_rest_url'] . "user/sign-up";
                    $post_string = http_build_query($form_data);
                    $result = Utility::postData($url, $post_string);
                    $res = json_decode($result['res'], true);
                    if ($res['result'] == true && isset($res['data']['token']) && $res['data']['token'] != "") {
                        $_SESSION['token'] = $res['data']['token'];
                        $_SESSION['user_id'] = $res['data']['id'];
                        $this->result = [
                            "result" => true,
                            "data" => ""
                        ];
                    } else {
                        $this->result = [
                            "result" => false,
                            "data" => $res["data"]
                        ];
                    }
                }else{
                    $this->result = [
                        "result" => false,
                        "error" => $errors
                    ];
                }
			} else {
				$this->result = [
					"result" => false,
					"data" => "Недостаточно данных"
				];
			}
		}
		$this->createResponse();
	}

	public function actionSignIn() {
		if($this->request->isAjax) {
			if(isset($this->postValue) && $this->post("login") && $this->post("password")) {
				$form_login = [
					'username' => $this->post("login"),
					'password' => $this->post("password")
				];
				$url = Yii::$app->params['root_rest_url'] . "user/sign-in";
				$post_string = http_build_query($form_login);
				$_post = Utility::postData($url, $post_string);

				$res = json_decode($_post['res'], true);

				if($res['result'] == true && isset($res['data']['token']) && $res['data']['token'] != "") {
					$_SESSION["token"] = $res['data']['token'];
					$_SESSION["user_id"] = $res['data']['id'];

					if($_POST["check-remember"] == true) {
						$data = [ "token" => $res['data']['token'] . "_" . $res['data']['id'] ];
					} else {
						$data = "";
					}
					$this->result = [
						"result" => true,
						"data" => $data
					];
				} else {
					$this->result = [
						"result" => false,
						"data" => $res["data"]
					];
				}

			}
		}
		$this->createResponse();
	}

	public function actionDeleteAccount() {
		if($this->request->isAjax) {
			if(isset($this->postValue) && $this->post("token")) {
				$form_login = [
					'token' => $this->post("token")
				];
				$url = Yii::$app->params['root_rest_url'] . "user/delete-account";
				$post_string = http_build_query($form_login);
				$_post = Utility::postData($url, $post_string);
				$res = json_decode($_post['res'], true);

				if($res['result'] == true) {
					$_SESSION = [];
					$this->result = [
						"result" => true,
						"data" => ""
					];
				} else {
					$this->result = [
						"result" => false,
						"data" => $res["data"]
					];
				}
			} else {
				$this->result = [
					"result" => false,
					"data" => "Системная ошибка. Недостаточно параметров."
				];
			}
		}
		$this->createResponse();
	}

	public function actionAddMoney() {
		if($this->request->isAjax) {
			if(isset($this->postValue) && $this->post("token")) {
				$form_login = [
					"token" => $this->post("token"),
					"sum" => $this->post("slider-money")
				];
				$url = Yii::$app->params['root_rest_url'] . "payments/money-transfer";
				$post_string = http_build_query($form_login);
				$_post = Utility::postData($url, $post_string);
				$res = json_decode($_post['res'], true);
				if(isset($res) && isset($res["result"]) && $res["result"] == true) {
					$this->result = [
						"result" => true,
						"data" => $res["data"]
					];
				} else {
					$this->result = [
						"result" => false,
						"data" => $res["data"]
					];
				}
			} else {
				$this->result = [
					"result" => false,
					"data" => "Системная ошибка. Недостаточно параметров."
				];
			}
		}
		$this->createResponse();
	}

	public function actionLiftupAdvert() {
		if($this->request->isAjax) {
			if(isset($this->postValue) && $this->post("id_ads") && $this->post("id_ads") != "") {
				$url = Yii::$app->params['root_rest_url'] . "advert/set-status-advert";

				$params = [
					"advertId" => $this->post("id_ads"),
					"status" => "raise",
					"token" => $this->post("token")
				];
				$post_string = http_build_query($params);
				$_post_data = Utility::postData($url, $post_string);
//dd($_post_data);
				if(isset($_post_data["res"])) {
					$tmp_data = json_decode($_post_data["res"], true);
				}

				$this->result = [
					"result" => isset($tmp_data["result"]) ? $tmp_data["result"] : false,
					"data" => $tmp_data["data"]
				];

			}
		}
		$this->createResponse();
	}

	public function actionFeedback() {
		if($this->request->isAjax) {

			$time = isset($_SESSION["callback"]) ? $_SESSION["callback"] : time();
			if(time() < $time) {
				$this->result = [
					"result" => false,
					"data" => "Сообщение не было отправлено по причине ограничения сайта на отправку одного сообщения раз в 15 минут."
				];
			} else {
				$_SESSION["callback"] =(time() +(60 * 15));

				$url = Yii::$app->params['root_rest_url'] . "message/send-feed-back";
				$post_string = http_build_query($this->postValue);

				$_post_data = Utility::postData($url, $post_string);
				if(isset($_post_data["res"])) {
					$tmp_data = json_decode($_post_data["res"], true);
				}

				$this->result = [
					"result" => isset($tmp_data["result"]) ? $tmp_data["result"] : false,
					"data" => ""
				];
			}
		}

		$this->createResponse();
	}

	public function actionAddProAdvert() {
		if($this->request->isAjax) {

			$url = Yii::$app->params['root_rest_url'] . "advert/add-pro-advert";

			$params = [
				"advert_id" => $this->post("advert_id"),
				"package" => $this->post("package"),
				"addons" => $this->post("addons"),
				"token" => $this->post("token")
			];
			$post_string = http_build_query($params);
			$_post_data = Utility::postData($url, $post_string);
            //dd($_post_data);
			if(isset($_post_data["res"])) {
				$tmp_data = json_decode($_post_data["res"], true);
			}


			$this->result = [
				"result" => isset($tmp_data["result"]) ? $tmp_data["result"] : false,
				"data" => $tmp_data["data"]
			];
		}
		$this->createResponse();
	}

	public function actionRestorePassword() {
		if($this->request->isAjax && $this->post("email") && $this->post("email") != "") {
			//$time = isset($_SESSION["restore_password"] ) ? $_SESSION["restore_password"] : time();
//			if(time() < $time ) {
//				$this->result = [
//					"result" => false,
//					"data" => "Восстановление пароля разрешенно раз в сутки"
//				];
//			} else {
				$_SESSION["restore_password"] =(time() +(60 * 24));

				$url = Yii::$app->params['root_rest_url'] . "user/restore-password?email=" . $this->post("email");
				$_post_data = Utility::getData($url);
                dd($_post_data);
				if(isset($_post_data["res"])) {
					$tmp_data = json_decode($_post_data["res"], true);
				}
                //"Проверьте почту. Следуйте инструкции в письме!"
				$this->result = [
					"result" => isset($tmp_data["result"]) ? $tmp_data["result"] : false,
					"data" => isset($tmp_data["data"]) ? $tmp_data["data"] : "fail_restore"
				];
			//}
		}
		$this->createResponse();
	}

	public function actionDeleteMessage() {
        if(false){
	    //		if($this->request->isAjax && isset($this->post("message_id") ) && $this->post("message_id") != "" ) {

			$url = Yii::$app->params['root_rest_url'] . "message/delete-message";
			$post_string = http_build_query($this->postValue);

			$_post_data = Utility::postData($url, $post_string);

			if(isset($_post_data["res"])) {
				$tmp_data = json_decode($_post_data["res"], true);
			}

			$this->result = [
				"result" => isset($tmp_data["result"]) ? $tmp_data["result"] : false,
				"data" => $tmp_data["data"]
			];
		}
		$this->createResponse();
	}
}