<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Utility;
use app\models\SignUpForm;
use app\models\Translations;
use app\models\UserProfile;
use app\models\AdForm;
use app\models\Constant;

use yii\helpers\Url;

class SiteController extends Controller {

	private $postValue;
	private $getValue;
	private $request;
	private $list_category;
	private $list_lang;
	private $default_language;
	private $select_language;
	private $default_id_language;
	private $status = false;
	private $value = '';
	private $data = [];
	private $list_countries;
	private $list_currency;
	private $list_cities;
	private $content_site;
	private $user_id;
	private $list_advert;
	private $str_filter = '';
	private $page_advert = 0;
	private $affiliation;
	private $title_advert;
	private $name_category;
	private $sysname_category;

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only'  => [ 'logout' ],
				'rules' => [
					[
						'actions' => [ 'logout' ],
						'allow'   => true,
						'roles'   => [ '@' ],
					],
				],
			],
			'verbs'  => [
				'class'   => VerbFilter::className(),
				'actions' => [
					'logout' => [ 'post' ],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'error'   => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class'           => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	private function createResponce() {

		echo json_encode(
			array(
				"result" => $this->status,
				"data"   => $this->data
			)
		);
		die();
	}

	private function setViewParams($tags){
	    if(!$tags || !is_array($tags)) return [];
	    foreach ($tags as $k => $v){
            $this->view->params[$k] = $v;
        }
    }

	private function getDefaultLanguage() {
		$_res = Utility::getData( Constant::$root_rest_url . "help/default-language" );
		if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
			$_lang_site = json_decode( $_res['res'], true );

			if ( isset( $_lang_site["result"] ) && $_lang_site["result"] != "" && isset( $_lang_site["data"]["language"] ) && $_lang_site["data"]["language"] != "" ) {
				$this->default_language    = $_lang_site["data"]["language"];
				$this->default_id_language = $_lang_site["data"]["id_lang"];
			}
		}
	}

	private function getListAffiliation() {
		$_res = Utility::getData( Constant::$root_rest_url . 'help/get-list-affiliation' );

		if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
			$_affiliation = json_decode( $_res['res'], true );
			if ( isset( $_affiliation["result"] ) && $_affiliation["result"] != "" && isset( $_affiliation["data"] ) ) {
				$this->affiliation = $_affiliation["data"];
			}
		}
	}

	private function getListLanguage() {
		$_res = Utility::getData( Constant::$root_rest_url . 'help/language' );
		if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
			$_list_lang = json_decode( $_res['res'], true );
			if ( isset( $_list_lang["result"] ) && $_list_lang["result"] != "" && isset( $_list_lang["data"] ) ) {
				$this->list_lang = $_list_lang["data"];
			}
		}
	}

	private function getListCategories() {
		$_res = Utility::getData( Constant::$root_rest_url . 'help/categories?language=' . $this->default_language );

		if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
			$_list_categs = json_decode( $_res['res'], true );
			if ( isset( $_list_categs["result"] ) && $_list_categs["result"] != "" && isset( $_list_categs["data"] ) ) {
				foreach ( $_list_categs["data"] as $val ) {
					$this->list_category[ $val["sys_name"] ] = $val;
				}
                $this->view->params['list_category'] = $this->list_category;
			}
		}
	}

	private function getListCountries() {
		$_res = Utility::getData( Constant::$root_rest_url . 'help/countries' );
		if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
			$_list_countries = json_decode( $_res['res'], true );
			if ( isset( $_list_countries["result"] ) && $_list_countries["result"] != "" && isset( $_list_countries["data"] ) ) {
				$this->list_countries = $_list_countries["data"];
			}
		}
	}

	private function getListCurrency() {
		$_res = Utility::getData( Constant::$root_rest_url . 'help/currency' );
		if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
			$_list_countries = json_decode( $_res['res'], true );
			if ( isset( $_list_countries["result"] ) && $_list_countries["result"] != "" && isset( $_list_countries["data"] ) ) {
				$this->list_currency = $_list_countries["data"];
			}
		}
	}

	private function getListCities() {
		$_res = Utility::getData( Constant::$root_rest_url . 'help/city' );

		if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
			$_list_city = json_decode( $_res['res'], true );
			if ( isset( $_list_city["result"] ) && $_list_city["result"] != "" && isset( $_list_city["data"] ) ) {
				$this->list_cities = $_list_city["data"];
			}
		}
	}

	private function getContentSite() {
		$_res = Utility::getData( Constant::$root_rest_url . "help/content" );
		if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
			$_content_site = json_decode( $_res['res'], true );
			if ( isset( $_content_site["result"] ) && $_content_site["result"] != "" && isset( $_content_site["data"] ) ) {
				$this->content_site = $_content_site["data"];
			}
		}
	}

	private function getVipAdvert() {
        $get_vip = Utility::getData( Constant::$root_rest_url . 'advert/get-list-advert-filter?random=1&isVip=true&' . http_build_query( $this->getValue ) );;
        //dd($get_vip);
        $vip     = json_decode( $get_vip['res'], true );
		if ( isset( $vip['result'] ) && $vip['result'] == true && isset( $vip['data'] ) ) {
			return $this->view->params["vip_adverts"] = $vip['data'];
		}
	}

	private function getAdvertByCategory( $name_category ) {
		$result           = false;
		$this->str_filter = "name_category=" . $name_category;
		$_res             = Utility::getData( Constant::$root_rest_url . 'advert/get-list-advert-category?' . $this->str_filter );

		if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
			$_list_adverts = json_decode( $_res['res'], true );

			if ( isset( $_list_adverts["result"] ) && $_list_adverts["result"] != "" && isset( $_list_adverts["data"] ) ) {
				$this->list_advert = $_list_adverts["data"];
				$result            = true;
			}
		}

		return $result;
	}

	public function beforeAction( $action ) {
		Yii::$app->session->open();

        // Стандартное значение для валюты
        $_SESSION["id_currency"] = 5;

		$this->postValue = Yii::$app->request->post();
		$this->getValue  = Yii::$app->request->get();
		$this->request   = Yii::$app->request;

		if ( isset( $_SESSION["default_language"] ) && $_SESSION["default_language"] != "" ) {
			$this->default_language = $_SESSION["default_language"];
		} else {
			$this->getDefaultLanguage();
		}
	    $this->getListCategories();
	    $this->getListCountries();
	    $this->getListCurrency();
	    $this->getListCities();

		$this->getListLanguage();
        //$this->getListAffiliation();
		$this->getContentSite();

		$this->view->params["is_index"] = false;

		$this->view->params["user_id"] = false;
		$this->user_id                 = false;


		$this->view->params["content"]      = $this->content_site;

		$this->view->params["is_login"] = false;

		$this->view->params["language"]["default_id"]   = $this->default_id_language;
		$this->view->params["language"]["default_code"] = $this->default_language;
		$this->view->params["language"]["list"]         = $this->list_lang;
		$this->view->params['Translations']             = Translations::listTranslations( $this->default_language );
		$this->view->params['Language']                 = $this->default_language;
		$this->view->params['affiliation']              = $this->affiliation;

		if ( isset( $_SESSION['token'] ) && $_SESSION['token'] != "" && $_SESSION['token'] != "0" ) {
			$this->view->params["token"]    = $_SESSION['token'];
			$this->view->params["is_login"] = true;
			$this->view->params["user_id"]  = $_SESSION['user_id'];
			$this->user_id                  = $_SESSION['user_id'];
		}
        $this->getProfileUser();

		$_SESSION["default_language"]    = $this->default_language;
		$_SESSION["default_id_language"] = $this->default_id_language;

		if ( ! isset( $_SESSION["page_advert"] ) ) {
			$_SESSION["page_advert"] = 0;
		}

		if ( ! isset( $_SESSION["category"] ) ) {
			$_SESSION["category"] = 0;
		}

		if ( ! isset( $_SESSION["sub_category"] ) ) {
			$_SESSION["sub_category"] = 0;
		}

		if ( isset( $_SESSION["filter"] ) && $_SESSION["filter"] != [] ) {
			$this->view->params["filter"] = $_SESSION["filter"];
		} else {
			$this->view->params["filter"] = [];
		}

		if ( ! isset( $_SESSION["is_first"] ) ) {
			$_SESSION["is_first"] = 0;
		}

		return true;
	}

	//--------------------------------------------------------------------------------------------------------------

	public function actionChangeLanguage() {
		if ( $this->request->isAjax ) {
			if ( isset( $this->postValue["language"] ) ) {
				$_SESSION["default_language"] = $this->postValue["language"];
			}
		}

		return true;
	}

	public function actionChangePage() {

		if ( $this->request->isAjax ) {
			if ( isset( $this->postValue["page"] ) ) {
				if ( $this->postValue["page"] == "prev" ) {
					if ( $_SESSION["page_advert"] != 0 ) {
						$_SESSION["page_advert"] = $_SESSION["page_advert"] - 1;
					}
				} elseif ( $this->postValue["page"] == "next" ) {
					if ( $_SESSION["page_advert"] != ( $this->calculationNumberPages( $this->list_advert ) - 1 ) ) {
						$_SESSION["page_advert"] = $_SESSION["page_advert"] + 1;
					}
				} else {
					$_SESSION["page_advert"] = $this->postValue["page"] - 1;
				}
			}
		}

		return true;
	}

	public function actionChangeCategory() {
		if ( $this->request->isAjax ) {
			if ( isset( $this->postValue["type"] ) ) {
				if ( $this->postValue["type"] == "category" ) {
					$_SESSION["category"]     = $this->postValue["category"];
					$_SESSION["sub_category"] = 0;
				} elseif ( $this->postValue["type"] == "sub_category" ) {
					$_SESSION["sub_category"] = $this->postValue["category"];
				}
			}
		}

		return true;
	}

	private function getBreadCrumbs( $cur_url ) {
		$result = "Главная";
		if ( $cur_url == "profile" ) {
			$result = 'Профайл';
		} elseif ( $cur_url == "profile-my-ads" ) {
			$result = "Мои объявления";
		} elseif ( $cur_url == "profile-message" ) {
			$result = "Мои сообщения";
		} elseif ( $cur_url == "profile-favourite" ) {
			$result = "Избранные";
		} elseif ( $cur_url == "profile-delete-acc" ) {
			$result = "Удалить аккаунт";
		} elseif ( $cur_url == "edit-advert" ) {
			$result = "Редактирование объявления";
		}

		/*
				if ( strpos( $cur_url, 'profile-my-ads' ) !== false ) {
					$result = 'Мои объявления';
				} elseif ( strpos( $cur_url, 'profile-message-chat' ) !== false ) {
					$result = 'Чат';
				} elseif ( strpos( $cur_url, 'profile-message' ) !== false ) {
					$result = 'Сообщения';
				} elseif ( strpos( $cur_url, 'profile-favourite' ) !== false ) {
					$result = 'Избранные';
				} elseif ( strpos( $cur_url, 'profile-delete-acc' ) !== false ) {
					$result = 'Удалить аккаунт';
				} elseif ( strpos( $cur_url, 'profile' ) !== false ) {
					$result = 'Профайл';
				} elseif ( strpos( $cur_url, 'advert' ) !== false ) {
					$result = 'Объявление';
				} elseif ( strpos( $cur_url, 'category' ) !== false ) {
					$result = 'Категории';
				} elseif
		*/

		return $result;
	}

	public function buildBreadCrumbs() {
		$request = $_SERVER['REQUEST_URI'];
		$_tmp    = [];

		$pr_find = false;
		if ( isset( $_SESSION["BreadCrumbs"] ) && isset( $_SESSION["BreadCrumbs"][1] ) && $_SESSION["BreadCrumbs"][1] !== "" ) {
			$pr_find = true;
			$item    = $_SESSION["BreadCrumbs"][1];
		}

		$_SESSION["BreadCrumbs"]   = [];
		$_SESSION["BreadCrumbs"][] = [ 'label' => $this->getBreadCrumbs( "/" ), 'url' => "/" ];
		$tmp                       = $_SESSION["BreadCrumbs"];

		if ( strpos( $request, '/sign-out' ) === false &&
		     strpos( $request, '/auth-reg' ) === false &&
		     strpos( $request, 'profile-my-payments' ) === false
		) {
			$_url = explode( "/", $request );
			if ( $_url[1] == "profile" ) {
				$tmp[] = [ 'label' => $this->getBreadCrumbs( $_url[1] ), 'url' => $request ];
			} elseif ( $_url[1] == "profile-my-ads" ) {
				$tmp[] = [ 'label' => $this->getBreadCrumbs( "profile" ), 'url' => "/profile" ];
				$tmp[] = [ 'label' => $this->getBreadCrumbs( $_url[1] ), 'url' => $request ];
			} elseif ( $_url[1] == "profile-message" ) {
				$tmp[] = [ 'label' => $this->getBreadCrumbs( "profile" ), 'url' => "/profile" ];
				$tmp[] = [ 'label' => $this->getBreadCrumbs( $_url[1] ), 'url' => $request ];
			} elseif ( $_url[1] == "profile-favourite" ) {
				$tmp[] = [ 'label' => $this->getBreadCrumbs( "profile" ), 'url' => "/profile" ];
				$tmp[] = [ 'label' => $this->getBreadCrumbs( $_url[1] ), 'url' => $request ];
			} elseif ( $_url[1] == "profile-delete-acc" ) {
				$tmp[] = [ 'label' => $this->getBreadCrumbs( "profile" ), 'url' => "/profile" ];
				$tmp[] = [ 'label' => $this->getBreadCrumbs( $_url[1] ), 'url' => $request ];
			} elseif ( $_url[1] == "edit-advert" ) {
				$tmp[] = [ 'label' => $this->getBreadCrumbs( "profile" ), 'url' => "/profile" ];
				$tmp[] = [ 'label' => $this->getBreadCrumbs( "profile-my-ads" ), 'url' => "/profile-my-ads" ];
				$tmp[] = [ 'label' => $this->getBreadCrumbs( $_url[1] ), 'url' => $request ];
			} elseif ( $_url[1] == "advert" ) {
				if ( $pr_find ) {
					$tmp[] = $item;
					$tmp[] = [ 'label' => $this->title_advert, 'url' => $request ];
				} else {
					$tmp[] = [ 'label' => $this->name_category, 'url' => "/category/" . $this->sysname_category ];
					$tmp[] = [ 'label' => $this->title_advert, 'url' => $request ];
				}
			} elseif ( $_url[1] == "category" ) {
				$tmp[] = [ 'label' => $this->name_category, 'url' => $request ];
			} elseif ( strpos( $_url[1], "search" ) !== false ) {
				$tmp[] = [
					'label'   => "Поиск (" . @$this->view->params["filter"]["search"] != "" ? @$this->view->params["filter"]["search"] : "Поиск по параметрам" . ")",
					'url'     => "#",
					'notlink' => true
				];
			}


			/*
			if ( $_url[1] == "advert" ) {
				$tmp[] = [ 'label' => $this->getBreadCrumbs( $_url[1] ), 'url' => '#', 'notlink' => true ];
				$tmp[] = [ 'label' => $this->title_advert, 'url' => $request ];

			} elseif ( $_url[1] == "category" ) {
				$tmp[] = [ 'label' => $this->getBreadCrumbs( $_url[1] ), 'url' => '#', 'notlink' => true ];
				$tmp[] = [ 'label' => $this->getNameCategoryBySysName( $_url[2] ), 'url' => $request ];
			} elseif ( $_url[1] == "edit-advert" ) {

			} else {
				$tmp[] = [ 'label' => $this->getBreadCrumbs( $request ), 'url' => $request ];
			}
			*/

			$_SESSION["BreadCrumbs"] = $tmp;

			$_tmp = $tmp;
		}
		$this->view->params["BreadCrumbs"] = $_tmp;
	}

	public function actionMessSearch() {
		if ( $this->request->isAjax ) {
			if ( isset( $this->postValue["text_search"] ) ) {
				$_SESSION["message_search"] = $this->postValue["text_search"];
			}
		}

		return true;
	}

	//==============================================================================================================
	private function calculationNumberPages( $array ) {
		return ceil( count( $array ) / Constant::$count_advert_in_page );
	}

	private function getSlice( $array, $page ) {
		$start = $page * Constant::$count_advert_in_page;

		return array_slice( $array, $start, Constant::$count_advert_in_page );
	}


	public function actionError() {
		$exception = Yii::$app->errorHandler->exception;
		if ( $exception !== null ) {
			return $this->render( 'error', [ 'exception' => $exception ] );
		}
	}

	public function actionIndex() {
        $this->getListCategories();
        $this->getVipAdvert();

		$_res = Utility::getData( Constant::$root_rest_url . 'help/statistics?item=count_new_visitors' );

		$this->buildBreadCrumbs();

		$_SESSION["message_search"]     = "";
		$_SESSION["filter"]             = [];
		$this->view->params["filter"]   = $_SESSION["filter"];
		$this->view->params["is_index"] = true;

		return $this->render( 'index', [
			'list_category' => $this->list_category
		] );
	}

	public function actionSearch() {
        $this->getListCategories();
		if ( $this->request->isGet ) {
			$this->view->params["filter"] = $this->getValue;
			if(isset($this->getValue["id"])) {
                $category = $this->getCategoryBySysName($this->getValue["id"]);
                $this->getValue["category"] = $this->getValue["id"];
            }
            $_list_vip_adverts = [];
			$_res = Utility::getData( Constant::$root_rest_url . 'advert/get-list-advert-filter?' . http_build_query( $this->getValue ) );
//			print_r($_res);exit();
			$_res_vip = $this->getVipAdvert();

			$_SESSION["page_advert"] = 0;

			if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
				$_list_adverts = json_decode( $_res['res'], true );
				if ( isset( $_list_adverts["result"] ) && $_list_adverts["result"] != "" && isset( $_list_adverts["data"] ) ) {
					$this->list_advert = $_list_adverts["data"];
					$list_adverts      = $this->getSlice( $this->list_advert, $_SESSION["page_advert"] );
				}
			}
            if ( $_res_vip ) {
                $_list_vip_adverts = $_res_vip;
            }
			if ( ! $this->request->isAjax && isset( $this->getValue["category"] ) && $this->getValue["category"] != "" ) {
				$_SESSION["category"] = $this->getValue["category"];
			}
			if ( ! $this->request->isAjax && isset( $this->getValue["category2"] ) && $this->getValue["category2"] != "" ) {
				$_SESSION["sub_category"] = $this->getValue["category2"];
			}
		} else {
			$_res = Utility::getData( Constant::$root_rest_url . 'advert/list-advert' );
			if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
				$_list_adverts = json_decode( $_res['res'], true );
				if ( isset( $_list_adverts["result"] ) && $_list_adverts["result"] != "" && isset( $_list_adverts["data"] ) ) {
					$this->list_advert = $_list_adverts["data"];
					$list_adverts      = $this->getSlice( $this->list_advert, $_SESSION["page_advert"] );
				}
			}
		}

		$list_category = $this->list_category;

        $this->setViewParams([
            "title" => $category['seo_title'],
            "description" => $category['seo_desc']
        ]);

        $params = [
            'list_adverts'        => $list_adverts,
            'list_vip'        => $_list_vip_adverts,
            'count_page'          => $this->calculationNumberPages( $this->list_advert ),
            'active_page'         => $_SESSION["page_advert"],
            'list_category'       => $list_category,
            'list_sub_category'   => $list_sub_category,
            'select_category'     => $_SESSION["category"],
            'select_sub_category' => $_SESSION["sub_category"],
            "get_param"           => $this->getValue
            //'crumbs'              => $_SESSION['crumbs']
        ];
        if(isset($category)){
            $this->name_category = $category['value'];
            $params['category'] = $category;
        }
		$this->buildBreadCrumbs();

        $params['count_page'] = $this->calculationNumberPages( $this->list_advert );
        $params['active_page'] = $_SESSION["page_advert"];

		return $this->render( 'poster',  $params);
	}

	public function getIdCategoryBySysName( $sys_name = false ) {
		if ( isset( $this->list_category ) && isset( $this->list_category[ $sys_name ] ) ) {
			return [ "category" => $this->list_category["$sys_name"]["id_category"] ];
		} else {
			foreach ( $this->list_category as $item ) {
				if ( isset( $item ) && isset( $item["child"] ) ) {
					foreach ( $item["child"] as $val ) {
						if ( isset( $val ) && isset( $val["sys_name"] ) && $val["sys_name"] == $sys_name ) {
							return [ "category" => $item["id_category"], "category2" => $val["id_category"] ];
						}
					}
				}
			}
		}
	}

	public function getCategoryBySysName( $sys_name = false ) {
		if ( isset( $this->list_category ) && isset( $this->list_category[ $sys_name ] ) ) {
			return $this->list_category[ $sys_name ];
		} else {
			foreach ( $this->list_category as $item ) {
				if ( isset( $item ) && isset( $item["child"] ) ) {
					foreach ( $item["child"] as $val ) {
						if ( isset( $val ) && isset( $val["sys_name"] ) && $val["sys_name"] == $sys_name ) {
							return $val;
						}
					}
				}
			}
		}
	}

	public function actionCategory() {

		if ( isset( $_SESSION["filter"] ) && $_SESSION["filter"] != [] ) {
			//TODO :: добавить вызов рест метода фильтров
			$_SESSION["filter"]           = array_merge( $_SESSION["filter"], $this->getIdCategoryBySysName( $this->getValue["id"] ) );
			$this->view->params["filter"] = $_SESSION["filter"];
			$_res                         = Utility::getData( Constant::$root_rest_url . 'advert/get-list-advert-filter?' . http_build_query( $_SESSION["filter"] ) );
			if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
				$_list_adverts = json_decode( $_res['res'], true );
				if ( isset( $_list_adverts["result"] ) && $_list_adverts["result"] != "" && isset( $_list_adverts["data"] ) ) {
					$this->list_advert = $_list_adverts["data"];
					$list_adverts      = $this->getSlice( $this->list_advert, $_SESSION["page_advert"] );
				}
			}
		} else {
			if ( isset( $this->getValue["id"] ) && $this->getValue["id"] != "" ) {
				if ( $this->getAdvertByCategory( $this->getValue["id"] ) ) {
					$list_adverts = $this->getSlice( $this->list_advert, $_SESSION["page_advert"] );
				}
			}
		}
        $category = $this->getCategoryBySysName( $this->getValue["id"] );

		$this->setViewParams([
		    "title" => $category['seo_title'],
            "description" => $category['seo_desc']
        ]);

		$this->name_category = $category['value'];
		$this->buildBreadCrumbs();

		return $this->render( 'category', [
			'name_category' => $category['value'],
			"id_category"   => $this->getIdCategoryBySysName($this->getValue["id"]),
			'list_adverts'  => $list_adverts,
			'count_page'    => $this->calculationNumberPages( $this->list_advert ),
			'active_page'   => $_SESSION["page_advert"]
		] );
	}

	public function actionAdvert() {
        $this->getListCategories();
		$data_advert = [];
		if ( isset( $this->getValue["id"] ) && $this->getValue["id"] != "" ) {
			$_res = Utility::getData( Constant::$root_rest_url . 'advert/get-info-advert?ext_meta_title=' . $this->getValue["id"] );
			//dd($_res);
			if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
				$_data_advert = json_decode( $_res['res'], true );
				if ( isset( $_data_advert["result"] ) && $_data_advert["result"] != "" && isset( $_data_advert["data"] ) ) {
					$data_advert = $_data_advert["data"];
					Utility::getData( Constant::$root_rest_url . '/help/view-advert?advert_id=' . $data_advert['id_ads'] );
				}
			}
		}
		$advert_similar = [];
		if ( isset( $data_advert ) && isset( $data_advert["id_ads"] ) && $data_advert["id_ads"] != "" ) {

			$_res = Utility::getData( Constant::$root_rest_url . 'advert/get-list-advert-similar?advert_id=' . $data_advert["id_ads"] );
			//dd($_res);
			if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
				$_list_adverts = json_decode( $_res['res'], true );
				if ( isset( $_list_adverts["result"] ) && $_list_adverts["result"] != "" && isset( $_list_adverts["data"] ) ) {
					$this->list_advert = $_list_adverts["data"];
					$advert_similar    = $this->getSlice( $this->list_advert, $_SESSION["page_advert"] );
				}
			}

		}

		$this->title_advert     = $data_advert['title'];
		$this->name_category    = $data_advert["category"]['name_category'] != "" ? $data_advert["category"]['name_category'] : $data_advert["category"]['name_sub_category'];
		$this->sysname_category = $data_advert["category"]['sys_name'] != "" ? $data_advert["category"]['sys_name'] : $data_advert["category"]['sys_name_sub_category'];

        $this->setViewParams([
            "title" => $data_advert['title'] . " | " . $this->name_category,
            "description" => (($data_advert['price'] > 0) ? $data_advert['price'] . " ₸ (KZT). " : "") . $data_advert['title'] . " | " . $this->name_category
        ]);

		$this->buildBreadCrumbs();

		return $this->render( 'advert', [
			'data_advert'    => $data_advert,
			"advert_similar" => $advert_similar
		] );
	}

	public function actionSignIn() {
		if ( isset( $_SESSION ) && isset( $_SESSION["token"] ) && $_SESSION["token"] != "" ) {
			$this->view->params["user_id"]  = $_SESSION['user_id'];
			$this->user_id                  = $_SESSION['user_id'];
			$this->view->params["is_login"] = true;
			$_SESSION["filter"]             = [];

			$this->redirect( array( '/profile' ) );
		} else {
			$this->redirect( array( '/auth-reg/login' ) );
		}
	}

	public function actionSignOut() {
		if ( isset( $_SESSION['token'] ) ) {
			$url       = Constant::$root_rest_url . "user/sign-out";
			$out_token = [
				'token' => $_SESSION['token']
			];

			$post_string = http_build_query( $out_token );
			$asd         = Utility::postData( $url, $post_string ); //, $user, $password);

			$res = json_decode( $asd['res'], true );
			$err = json_decode( $asd['err'], true );

			if ( $res == true ) {
				unset( $_SESSION['token'] );
			} else {
				unset( $_SESSION['token'] );
			}

			return $this->goBack();
		} else {
			return $this->goBack();
		}
	}

	public function actionSignUp() {

		$session = Yii::$app->session;
		$session->setFlash( 'alerts', "" );

		if ( isset( $this->postValue["login"] ) && $this->postValue["login"] != "" &&
		     isset( $this->postValue["password"] ) && $this->postValue["password"] != "" &&
		     isset( $this->postValue["password_repeat"] ) && $this->postValue["password_repeat"] != "" ) {

			$this->status = true;

			$form_data = [
				'username' => $this->postValue["login"],
				'password' => $this->postValue["password"],
				'email'    => $this->postValue["email"],
				'ra'       => ( $this->postValue["check-term"] = "on" ) ? 1 : 0
			];

			$url         = Constant::$root_rest_url . "user/sign-up";
			$post_string = http_build_query( $form_data );
			$asd         = Utility::postData( $url, $post_string );
			$res         = json_decode( $asd['res'], true );

			if ( $res['result'] == true && isset( $res['data']['token'] ) && $res['data']['token'] != "" ) {
				$_SESSION['token']             = $res['data']['token'];
				$_SESSION['user_id']           = $res['data']['id'];
				$this->view->params["user_id"] = $res['data']['id'];
				$this->user_id                 = $res['data']['id'];

				$this->view->params["is_login"] = true;
				$_SESSION['log_name']           = $this->postValue["login"];

				$this->redirect( array( '/profile' ) );
			} else {
				$session = Yii::$app->session;
				$session->setFlash( 'alerts', $res['data'] );
				$this->redirect( array( '/auth-reg/signup' ) );
			}
		} else {
			$this->redirect( array( '/auth-reg/signup' ) );
		}
	}

	public function actionContact() {
		$model = new ContactForm();
		if ( $model->load( Yii::$app->request->post() ) && $model->contact( Yii::$app->params['adminEmail'] ) ) {
			Yii::$app->session->setFlash( 'contactFormSubmitted' );

			return $this->refresh();
		}

		return $this->render( 'contact', [
			'model' => $model,
		] );
	}

	public function actionAbout() {
		//print_r('Вхід');
		return $this->render( 'about' );
	}

	public function actionLanguages() {
		$session = Yii::$app->session;
		if ( ! $session->isActive ) {
			$session->open();
		}

		if ( $this->request->isGet ) {
			//$lang = Config::getValueByKey( Constant::$key_default_language );
			if ( isset( $this->getValue['language'] ) && $this->getValue['language'] != "" ) {
				$lang      = $this->getValue['language'];
				$url_ctgrs = Constant::$root_rest_url . "help/categories?language=" . $lang;
			}
		}
		$_res = Utility::getData( $url_ctgrs );
		//$_res = Utility::getData($url_leng);
		if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
			$_list_categs = json_decode( $_res['res'], true );
			if ( isset( $_list_categs["result"] ) && $_list_categs["result"] != "" && isset( $_list_categs["data"] ) ) {
				$this->view->params["list_categs"] = [];
				foreach ( $_list_categs["data"] as $val ) {

					$this->view->params["list_categs"][] = [ "label" => $val["russian"] ];
				}
			}
		}
		$session['lang_title'] = $this->arr_lang["$lang"];
		$session['categories'] = $this->view->params["list_categs"];

		return $this->render( 'index' );
	}

	public function actionAuthReg() {
		if ( isset( $this->getValue["id"] ) ) {
			$page = $this->getValue["id"];
		} else {
			$page = "login";
		}

		/*
		if ( isset( $_COOKIE ) && isset( $_COOKIE["token"] ) && $_COOKIE["token"] != "" && $page === "login" ) {
			$_tmp = explode( "_", $_COOKIE["token"] );

			if ( isset( $_tmp[0] ) && isset( $_tmp[1] ) && $_tmp[1] != "" && $_tmp[0] != "" ) {
				$_SESSION["token"]   = $_tmp[0];
				$_SESSION["user_id"] = $_tmp[1];
			}

			$url       = Constant::$root_rest_url . "user/user-auth";
			$out_token = [
				'token' => $_SESSION['token']
			];

			$post_string = http_build_query( $out_token );
			$_res        = Utility::postData( $url, $post_string ); //, $user, $password);

			if ( isset( $_res ) && isset( $_res["res"] ) && $_res["res"] != "" ) {
				$_tmp = json_decode( $_res["res"], true );
				if ( isset( $_tmp ) && isset( $_tmp["result"] ) && isset( $_tmp["data"] ) && $_tmp["data"] == "no_open_session" ) {
					unset( $_SESSION['token'] );
				}
			}
		}
		*/

		if ( $this->isUserOnline() ) {
			return $this->redirect( '/profile' );
		} else {
			$this->buildBreadCrumbs();


			$model_signin = new LoginForm();
			$model_signup = new SignUpForm();

			return $this->render( 'auth-reg',
				[
					"page"         => $page,
					"model_signin" => $model_signin,
					"model_signup" => $model_signup
				]
			);
		}
	}

	public function actionRestorePass() {
		if ( $this->isUserOnline() ) {
			return $this->redirect( '/profile' );
		} else {
			return $this->render( 'restore-pass', [] );
		}
	}

	public function actionTerms() {
		return $this->render( 'terms', [] );
	}

	/*
		public function actionGetProfile() {
			$res = [ 'data' => '' ];
			$err = '';
			print_r( $_SESSION['token'] . "\n" );

			if ( isset( $_SESSION['token'] ) ) {
				$url      = Constant::$root_rest_url . "user/profile?token=" . $_SESSION['token'];
				$get_prof = Utility::getData( $url );

				print_r( $url );

				$res = json_decode( $get_prof['res'], true );
				$err = json_decode( $get_prof['err'], true );

				$this->view->params["profile_data"] = $res["data"];
				var_dump( $this->view->params["profile_data"] );
				$model = new UserProfile();

				return $this->render( 'user_profile', [
					'model' => $model,
					'res'   => $res,
					'err'   => $err
				] );
			} else {
				return $this->render( 'index' );
			}
		}

		public function actionUpdateProfile() {
			$res   = [ 'data' => '' ];
			$err   = '';
			$model = new UserProfile();
			if ( $model->load( Yii::$app->request->post() ) && isset( $_SESSION['token'] ) ) {
				$url       = Constant::$root_rest_url . "user/profile";
				$form_data = [
					'token'         => $_SESSION['token'],
					'title'         => $model->getTitle(),
					'description'   => $model->getDescription(),
					'first_name'    => $model->getFirstName(),
					'last_name'     => $model->getLastName(),
					'email'         => $model->getEmail(),
					'mobile_number' => $model->getMobileNumber(),
					'about'         => $model->getAbout(),
					'meta_title'    => $model->getMetaTitle(),
					'meta_desc'     => $model->getMetaDesc(),
					'keywords'      => $model->getKeywords(),
					'id_currency'   => $model->getIdCurrency(),
					'phone'         => $model->getPhone(),
					'address'       => $model->getAddress(),
					'name'          => $model->getName()
				];

				foreach ( $form_data as $key => $value ) {
					if ( $value == '' ) {
						$form_data[ $key ] = null;
					}
				}

				var_dump( $form_data );
				$post_string = http_build_query( $form_data );
				var_dump( $post_string );

				$set_prof = Utility::postData( $url, $post_string );
				var_dump( $set_prof );

				$res = json_decode( $set_prof['res'], true );
				$err = json_decode( $set_prof['err'], true );
				$res['result'] == true ? $res['result'] = 'Request passed' : $res['result'] = 'Request not passed';

				return $this->actionGetProfile();
			} else {
				print_r( 'HET' );
			}
		}

		public function actionUserProfile() {
			// print_r('Вход');
			$res = [ 'data' => '' ];
			$err = '';
			//print_r($_SESSION['token']);
			$model = new UserProfile();

			if ( $model->load( Yii::$app->request->post() ) && isset( $_SESSION['token'] ) ) {
				$url       = Constant::$root_rest_url . "user/profile";
				$form_data = [
					'token'         => $_SESSION['token'],
					'title'         => $model->getTitle(),
					'description'   => $model->getDescription(),
					'first_name'    => $model->getFirstName(),
					'last_name'     => $model->getLastName(),
					'email'         => $model->getEmail(),
					'mobile_number' => $model->getMobileNumber(),
					'about'         => $model->getAbout(),
					'meta_title'    => $model->getMetaTitle(),
					'meta_desc'     => $model->getMetaDesc(),
					'keywords'      => $model->getKeywords(),
					'id_currency'   => $model->getIdCurrency(),
					'phone'         => $model->getPhone(),
					'address'       => $model->getAddress(),
					'name'          => $model->getName()
				];

				foreach ( $form_data as $key => $value ) {
					if ( $value == '' ) {
						$form_data[ $key ] = null;
					}
				}

				//var_dump( $form_data );
				$post_string = http_build_query( $form_data );
				//var_dump( $post_string );

				$set_prof = Utility::postData( $url, $post_string );
				//var_dump( $set_prof );

				$res = json_decode( $set_prof['res'], true );
				$err = json_decode( $set_prof['err'], true );
				$res['result'] == true ? $res['result'] = 'Request passed' : $res['result'] = 'Request not passed';
			}

			if ( isset( $_SESSION['token'] ) ) {

				$url                                = Constant::$root_rest_url . "user/profile?token=" . $_SESSION['token'];
				$get_prof                           = Utility::getData( $url );
				$res                                = json_decode( $get_prof['res'], true );
				$err                                = json_decode( $get_prof['err'], true );
				$this->view->params["profile_data"] = $res["data"];

				return $this->render( 'user_profile', [
					'model' => $model,
					'res'   => $res,
					'err'   => $err
				] );
			} else {
				return $this->goBack();
			}
		}


	*/

	private function getProfileUser() {
		if ( count( $this->view->params["profile_user"] ) == 0 ) {
			$url      = Constant::$root_rest_url . "user/profile?token=" . $_SESSION['token'];
			$get_prof = Utility::getData( $url );
			//dd($get_prof);
			//print_r($get_prof);
			//exit();
			$res      = json_decode( $get_prof['res'], true );

			if ( isset( $res['result'] ) && $res["result"] == true && isset( $res["data"] ) ) {
				$this->view->params["profile_user"] = $res["data"];
			}
		}
	}

	private function isUserOnline() {
		$result = false;
		if ( isset( $_SESSION['token'] ) && $_SESSION['token'] != "" ) {
			$url       = Constant::$root_rest_url . "user/user-online";
			$out_token = [
				'token' => $_SESSION['token']
			];

			$post_string = http_build_query( $out_token );
			$_res        = Utility::postData( $url, $post_string ); //, $user, $password);

			if ( isset( $_res ) && isset( $_res["res"] ) && $_res["res"] != "" ) {
				$_tmp = json_decode( $_res["res"], true );
				if ( isset( $_tmp ) && isset( $_tmp["result"] ) && isset( $_tmp["data"] ) && $_tmp["data"] == "no_open_session" ) {
					unset( $_SESSION['token'] );
					$result = false;
				} else {
					$result = true;
				}
			}
		}

		return $result;
	}

	public function actionProfile() {
		if ( $this->isUserOnline() ) {
			$this->buildBreadCrumbs();

			return $this->render( 'profile', [
				'affiliation' => $this->affiliation,
				'page'        => 'main'
			] );
		} else {
			return $this->redirect( '/' );
		}
	}

	public function actionProfileMyAds() {
		if ( $this->isUserOnline() ) {
			$this->buildBreadCrumbs();

			$_SESSION["page_advert"] = 0;
			$url_ads      = Constant::$root_rest_url . "advert/get-list-my-advert?token=" . $_SESSION['token'];
			$get_my_ads   = Utility::getData( $url_ads );
			$my_ads       = json_decode( $get_my_ads['res'], true );

			$list_adverts = [];

			if ( isset( $my_ads['result'] ) && $my_ads['result'] == true && isset( $my_ads['data'] ) ) {
				$list_adverts = $this->getSlice( $my_ads['data'], $_SESSION["page_advert"] );
			}

			return $this->render( 'profile', [
				'list_adverts' => $list_adverts,
				'count_page'   => $this->calculationNumberPages( $my_ads['data'] ),
				'active_page'  => $_SESSION["page_advert"],
				'city'         => $this->list_cities,
				'page'         => 'myAds'
			] );
		} else {
			return $this->redirect( '/' );
		}
	}

	public function actionProfileMessage() {
	    $type = ($this->getValue['id']) ? $this->getValue['id'] : "inbox";
		if ( $this->isUserOnline() ) {
			$this->buildBreadCrumbs();
			$model = [];
			$url   = Constant::$root_rest_url . 'message/list-my-messages?token=' . $_SESSION['token'];

			if ( isset( $_SESSION["message_search"] ) && $_SESSION["message_search"] != "" ) {
				$url .= "&text_search=" . $_SESSION["message_search"];
			}

			Yii::info( $url );
			$_res = Utility::getData( $url );
            //dd($_res);

			if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
				$_list_messages = json_decode( $_res['res'], true );
                //dd($_list_messages);
				if ( isset( $_list_messages["result"] ) && $_list_messages["result"] != "" && isset( $_list_messages["data"] ) ) {
					$model = $_list_messages["data"];
				}
			}

			return $this->render( 'profile', [
				'model' => $model,
                'type' => $type,
				'page'  => 'message'
			] );
		} else {
			return $this->redirect( '/' );
		}
	}

	public function actionProfileMessageChat() {
		if ( $this->isUserOnline() ) {
			$this->buildBreadCrumbs();
			$model = [];
			$this_user = [];
			$interlocutor = [];

			$form_login = [
				"token"     => $_SESSION['token'],
				"idMessage" => $this->getValue["id"]
			];

			$url         = Constant::$root_rest_url . "message/read-message";
			$post_string = http_build_query( $form_login );
			$_post       = Utility::postData( $url, $post_string );

			$_res = Utility::getData( Constant::$root_rest_url . 'message/get-chain-message?token=' . $_SESSION['token'] . "&idMessage=" . $this->getValue["id"] );
//dd($_res);
			//			print_r($_res);exit();
			if ( isset( $_res['res'] ) && $_res['res'] != "" ) {
				$_list_messages = json_decode( $_res['res'], true );
				if ( isset( $_list_messages["result"] ) && $_list_messages["result"] != "" && isset( $_list_messages["data"] ) ) {
					$model = $_list_messages["data"]['msgs'];
                    $this_user = $_list_messages["data"]['this_user'];
                    $interlocutor = $_list_messages["data"]['interlocutor'];
//                    print_r($_list_messages["data"]['interlocutor']);exit();
				}
			}

			return $this->render( 'profile', [
				'model'     => $model,
				'this_user'     => $this_user,
				'interlocutor'     => $interlocutor,
				'page'      => 'message-chat',
				"idMessage" => $this->getValue["id"]
			] );
		} else {
			return $this->redirect( '/' );
		}
	}

	public function actionProfileFavourite() {
		if ( $this->isUserOnline() ) {
			$this->buildBreadCrumbs();

			$_SESSION["page_advert"] = 0;

			$url_favourite = Constant::$root_rest_url . "advert/get-list-my-favorites-advert?token=" . $_SESSION['token'];

			$get_favourite = Utility::getData( $url_favourite );
			$favourite     = json_decode( $get_favourite['res'], true );

			$list_adverts = [];

			if ( isset( $favourite['result'] ) && $favourite['result'] == true && isset( $favourite['data'] ) ) {
				$list_adverts = $this->getSlice( $favourite['data'], $_SESSION["page_advert"] );
			}

			return $this->render( 'profile', [
				'list_adverts' => $list_adverts,
				'count_page'   => $this->calculationNumberPages( $favourite['data'] ),
				'active_page'  => $_SESSION["page_advert"],
				'city'         => $this->list_cities,
				'page'         => 'favourite'
			] );
		} else {
			return $this->redirect( '/' );
		}
	}

	public function actionProfileDeleteAcc() {
		if ( $this->isUserOnline() ) {
			$this->buildBreadCrumbs();

			return $this->render( 'profile', [
				'page' => 'deleteAcc'
				//'res'   => $res,
				//'err'   => $err
			] );
		} else {
			return $this->redirect( '/' );
		}
	}

	public function actionEditAdvert() {
		if ( $this->isUserOnline() ) {
			$this->buildBreadCrumbs();

			$type = "";

			if ( isset( $this->getValue["id"] ) && $this->getValue["id"] == "new" ) {
				$model = [];
				$type  = "new";
			} else {
				//Получить данные по объявлению
				$model      = [];
				$url_ads    = Constant::$root_rest_url . "advert/get-info-advert?token=" . $_SESSION['token'] . "&advert_id=" . $this->getValue["id"];
				$get_my_ads = Utility::getData( $url_ads );

				$my_ads     = json_decode( $get_my_ads['res'], true );
				if ( isset( $my_ads['result'] ) && $my_ads['result'] == true && isset( $my_ads['data'] ) ) {
					$model = $my_ads['data'];
				}
			}

			return $this->render( 'edit_advert', [
				"default_lang"  => $this->default_language,
				"model"         => $model,
                "profile_user"  => $this->view->params["profile_user"]["profile_user"],
				"list_category" => $this->list_category,
				"list_country"  => $this->list_countries,
				"list_currency" => $this->list_currency,
				"affiliation"   => $this->affiliation,
				"type"          => $type,
				"advert_id"     => $this->getValue["id"]
				//"edit_mark"     => $edit_mark
			] );
		} else {
			return $this->redirect( '/auth-reg/login' );
		}
	}

	public function actionStartSearch() {

		if ( $this->request->isAjax ) {
			if ( isset( $this->postValue ) && $this->postValue != [] ) {
				$_SESSION["page_advert"] = 0;

				$this->status = "true";
				$this->data   = $this->postValue;

				if ( isset( $_SESSION["filter"] ) && $_SESSION["filter"] != [] ) {
					$_SESSION["filter"] = array_merge( $_SESSION["filter"], $this->postValue );
				} else {
					$_SESSION["filter"] = $this->postValue;
				}
			} else {
				$this->status = "false";
				$this->data   = $this->postValue;
			}
			$this->createResponce();
		}
	}

	public function actionProfileMyPayments() {
		if ( $this->isUserOnline() ) {
			$content = "";
			if ( $this->request->isPost ) {
				if ( isset( $this->postValue ) && isset( $this->postValue["is_save"] ) &&
				     $this->postValue["is_save"] == "yes" &&
				     isset( $this->postValue["slider-money"] ) ) {
					unset( $this->postValue["is_save"] );

					$form_login  = [
						"token" => $_SESSION['token'],
						"sum"   => $this->postValue["slider-money"]
					];
					$url         = Constant::$root_rest_url . "payments/money-transfer";
					$post_string = http_build_query( $form_login );
					$_post       = Utility::postData( $url, $post_string );
					$res         = json_decode( $_post['res'], true );
					if ( isset( $res ) && isset( $res["result"] ) && $res["result"] == true ) {
						$content = $res["data"];
					}

				}
			}

			return $this->render( 'profile-my-payments', [
				'content' => $content
			] );
		} else {
			return $this->redirect( '/' );
		}
	}

	public function actionQuestion() {
		return $this->render( 'question', [] );
	}

	public function actionGaranty() {
		return $this->render( 'garanty', [] );
	}

	public function actionAdvertising() {
		return $this->render( 'advertising', [] );
	}

	public function actionAddPro() {
		if ( $this->isUserOnline() ) {
			if ( isset( $this->getValue["id"] ) && $this->getValue["id"] !== "" ) {
				$model      = [];
				$url_ads    = Constant::$root_rest_url . "advert/get-info-advert?token=" . $_SESSION['token'] . "&advert_id=" . $this->getValue["id"];
				$get_my_ads = Utility::getData( $url_ads );
				$my_ads     = json_decode( $get_my_ads['res'], true );
				if ( isset( $my_ads['result'] ) && $my_ads['result'] == true && isset( $my_ads['data'] ) ) {
					$model = $my_ads['data'];
				}
			}

			return $this->render( 'add-pro', [
				"model" => $model
			] );
		} else {
			return $this->redirect( '/' );
		}
	}

    public function actionPageMessage() {
	    $msg = $this->getValue["id"];

        $params = [
            "title" => "",
            "description" => "",
            "type" => "success",
            "hasHomeLink" => true
        ];
        if($msg == "success-added"){
            $params["title"] = "Спасибо за публикацию объявления.";
            $params["description"] = "Объявление скоро появится на сервисе после проверки модератором.";
        }else if($msg == "success-payment"){
            $params["title"] = "Платёж получен.";
            $params["description"] = "Деньги в течении 15-ти минут зачислиться на Ваш счёт.";
        }else if($msg == "fail-payment"){
            $params["title"] = "Платёж был отклонён.";
            $params["description"] = "Сервер по обработке платежей отклонил запрос.";
            $params["type"] = "error";
        }
        return $this->render( 'page-message', $params);
    }

	public function actionPaymentSuccessful() {
		return $this->render( 'payment-successful', [] );
	}

	public function actionPaymentFail() {
		return $this->render( 'payment-fail', [] );
	}

	public function actionCallbackPayment() {
		if ( $this->request->isPost ) {
			$url         = Constant::$root_rest_url . "payments/call-back-walletone";
			$post_string = http_build_query( $this->postValue );
			$_post       = Utility::postData( $url, $post_string );
			$res         = json_decode( $_post['res'], true );
			if ( isset( $res ) && isset( $res["data"] ) ) {
				echo $res["data"];
			}
		}
	}
}
