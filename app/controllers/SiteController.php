<?php

namespace app\controllers;

use app\components\TreeBuilder;
use app\models\Advertisement;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Utility;
use app\models\SignUpForm;
use app\models\Translations;
use app\models\UserProfile;
use app\models\AdForm;
use linslin\yii2\curl;
use app\components\RestManager;

use yii\helpers\Url;

class SiteController extends WebController
{
    public $defaultAction = 'index';
	private $list_category;
	private $list_lang;
	private $default_language;
	private $select_language;
	private $default_id_language;
	private $status = false;
	private $value = '';
	private $data = [];
	private $config;
	private $list_countries;
	private $list_currency;
	private $list_cities;
	private $content_site;
	private $user_id;
	private $list_advert;
	private $affiliation;
	private $title_advert;
	private $name_category;
	private $sysname_category;
	private $languages = [];

	public function behaviors() {
        $behaviours = parent::behaviors();
		return $behaviours;
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	private function setViewParams($tags){
	    if(!$tags || !is_array($tags)) return [];
	    foreach ($tags as $k => $v){
            $this->view->params[$k] = $v;
        }
    }

	public function beforeAction($action) {
        $dependencies = $this->dependencies;

        $language = $this->locale->getLanguage('code');

        $this->setViewParams(ArrayHelper::merge($dependencies, [
            'is_index' => false,
            'user_id' => false,
            'is_login' => false,
            'language' => $language
        ]));
//        $this->getListConfig();
//	    $this->getListCategories();
//	    $this->getListCountries();
//	    $this->getListCurrency();
//	    $this->getListCities();
//	    $this->getPageInfo();
//
//		$this->getListLanguage();
//        $this->getListAffiliation();
//		$this->getContentSite();

		if(isset($_SESSION['token']) && $_SESSION['token'] != "" && $_SESSION['token'] != "0") {
            $this->setViewParams([
                'token' => $_SESSION['token'],
                'user_id' => $_SESSION['user_id'],
                'is_login' => true
            ]);
		}
        //$this->getProfileUser();

		if(! isset($_SESSION["is_first"])) {
			$_SESSION["is_first"] = 0;
		}

		return $action;
	}

	//--------------------------------------------------------------------------------------------------------------

	public function actionChangeLanguage() {
	    $lang = $this->get("language");
        if ($lang) {
            $this->locale->setLanguage($lang);
        }

		return true;
	}

	public function actionChangePage() {

		if($this->request->isAjax) {
			if ($this->post("page")) {
				if($this->post("page") == "prev") {
					if($_SESSION["page_advert"] != 0) {
						$_SESSION["page_advert"] = $_SESSION["page_advert"] - 1;
					}
				} elseif($this->post("page") == "next") {
					if($_SESSION["page_advert"] !=($this->calculationNumberPages($this->list_advert) - 1)) {
						$_SESSION["page_advert"] = $_SESSION["page_advert"] + 1;
					}
				} else {
					$_SESSION["page_advert"] = $this->post("page") - 1;
				}
			}
		}

		return true;
	}

	public function actionChangeCategory() {
		if($this->request->isAjax) {
			if ($this->post("type")) {
				if($this->post("type") == "category") {
					$_SESSION["category"] = $this->post("category");
					$_SESSION["sub_category"] = 0;
				} elseif($this->post("type") == "sub_category") {
					$_SESSION["sub_category"] = $this->post("category");
				}
			}
		}

		return true;
	}

	private function getBreadCrumbs($cur_url) {
		$result = "Главная";
		if($cur_url == "profile") {
			$result = 'Профайл';
		} elseif($cur_url == "profile-my-ads") {
			$result = "Мои объявления";
		} elseif($cur_url == "profile-message") {
			$result = "Мои сообщения";
		} elseif($cur_url == "profile-favourite") {
			$result = "Избранные";
		} elseif($cur_url == "profile-delete-acc") {
			$result = "Удалить аккаунт";
		} elseif($cur_url == "edit-advert") {
			$result = "Редактирование объявления";
		}

		return $result;
	}

	public function buildBreadCrumbs() {
		$request = $_SERVER['REQUEST_URI'];
		$_tmp = [];

		$pr_find = false;
		if(isset($_SESSION["BreadCrumbs"]) && isset($_SESSION["BreadCrumbs"][1]) && $_SESSION["BreadCrumbs"][1] !== "") {
			$pr_find = true;
			$item = $_SESSION["BreadCrumbs"][1];
		}

		$_SESSION["BreadCrumbs"] = [];
		$_SESSION["BreadCrumbs"][] = [ 'label' => $this->getBreadCrumbs("/"), 'url' => "/" ];
		$tmp = $_SESSION["BreadCrumbs"];

		if(strpos($request, '/sign-out') === false &&
		     strpos($request, '/auth-reg') === false &&
		     strpos($request, 'profile-my-payments') === false
		) {
			$_url = explode("/", $request);
			if($_url[1] == "profile") {
				$tmp[] = [ 'label' => $this->getBreadCrumbs($_url[1]), 'url' => $request ];
			} elseif($_url[1] == "profile-my-ads") {
				$tmp[] = [ 'label' => $this->getBreadCrumbs("profile"), 'url' => "/profile" ];
				$tmp[] = [ 'label' => $this->getBreadCrumbs($_url[1]), 'url' => $request ];
			} elseif($_url[1] == "profile-message") {
				$tmp[] = [ 'label' => $this->getBreadCrumbs("profile"), 'url' => "/profile" ];
				$tmp[] = [ 'label' => $this->getBreadCrumbs($_url[1]), 'url' => $request ];
			} elseif($_url[1] == "profile-favourite") {
				$tmp[] = [ 'label' => $this->getBreadCrumbs("profile"), 'url' => "/profile" ];
				$tmp[] = [ 'label' => $this->getBreadCrumbs($_url[1]), 'url' => $request ];
			} elseif($_url[1] == "profile-delete-acc") {
				$tmp[] = [ 'label' => $this->getBreadCrumbs("profile"), 'url' => "/profile" ];
				$tmp[] = [ 'label' => $this->getBreadCrumbs($_url[1]), 'url' => $request ];
			} elseif($_url[1] == "edit-advert") {
				$tmp[] = [ 'label' => $this->getBreadCrumbs("profile"), 'url' => "/profile" ];
				$tmp[] = [ 'label' => $this->getBreadCrumbs("profile-my-ads"), 'url' => "/profile-my-ads" ];
				$tmp[] = [ 'label' => $this->getBreadCrumbs($_url[1]), 'url' => $request ];
			} elseif($_url[1] == "advert") {
				if($pr_find) {
					$tmp[] = $item;
					$tmp[] = [ 'label' => $this->title_advert, 'url' => $request ];
				} else {
					$tmp[] = [ 'label' => $this->name_category, 'url' => "/category/" . $this->sysname_category ];
					$tmp[] = [ 'label' => $this->title_advert, 'url' => $request ];
				}
			} elseif($_url[1] == "category") {
				$tmp[] = [ 'label' => $this->name_category, 'url' => $request ];
			} elseif(strpos($_url[1], "search") !== false) {
				$tmp[] = [
					'label' => "Поиск (" . @$this->view->params["filter"]["search"] != "" ? @$this->view->params["filter"]["search"] : "Поиск по параметрам" . ")",
					'url' => "#",
					'notlink' => true
				];
			}

			$_SESSION["BreadCrumbs"] = $tmp;

			$_tmp = $tmp;
		}
		$this->view->params["BreadCrumbs"] = $_tmp;
	}

	public function actionMessSearch() {
		if ($this->request->isAjax) {
			if ($this->post("text_search")) {
				$_SESSION["message_search"] = $this->post("text_search");
			}
		}

		return true;
	}

	//==============================================================================================================
	private function calculationNumberPages($array) {
		return ceil(count($array) / Yii::$app->params['count_advert_in_page']);
	}

	private function getSlice($array, $page) {
		$start = $page * Yii::$app->params['count_advert_in_page'];

		return array_slice($array, $start, Yii::$app->params['count_advert_in_page']);
	}


	public function actionError() {
		$exception = Yii::$app->errorHandler->exception;
		if($exception !== null) {
			return $this->render('error', [ 'exception' => $exception ]);
		}
	}

    public function actionIndex()
    {
        $categories = $this->getTreeCategories();
        $vip = $this->rest->vip([
            'random' => true
        ]);
        $contents = $this->getDependence('contents');
        $page = $this->getPageInfo();
        $brands = [];
        $banners = [];
        $mainSlider = [];
        foreach ($contents as $content){
            if($content['container'] === 'banner-box'){
                $banners[] = $content['html'];
            }
            if($content['container'] === 'brand-box'){
                $brands[] = $content['html'];
            }
            if($content['container'] === 'main-slider'){
                $mainSlider[] = $content['html'];
            }
        }
        $this->setViewParams([
            "is_index" => true,
            'mainSlider' => $mainSlider
        ]);

		$this->buildBreadCrumbs();

		return $this->render('index', compact(
		    'page',
		    'categories',
		    'brands',
		    'banners',
            'vip'
        ));
	}

	public function initStatusAdverts(){
	    $currentDate = date('Y-m-d H:i:s');
        $nextDate = date('Y-m-d 13:45:00');
        $prevDate = date('Y-m-d 13:30:00');
//        if($currentDate < $nextDate && $currentDate > $prevDate){
//            $response = $this->rest->post('advert/check-status');
//        }
    }

	public function actionSearchAdverts()
    {
//	    $this->rest->responseType = 'json';
//        $this->initStatusAdverts();
        $view = $this->view;
        $adverts = [];
        $vip = [];
        $count = 0;
        $category = [];

        if($this->get("slug")) {
            $category = $this->getCategory($this->get("slug"));
        }

        $response = $this->rest->get('adverts', $this->get());
        if($response){
            $adverts = $response['adverts'];
            $vip = $response['vip'];
            $count = $response['count'];
        }

        $pagination = new Pagination(['totalCount' => $count]);

        $this->setMetaTags([
            "title" => $category['seo_title'],
            "description" => $category['seo_desc']
        ]);

        $params = [
            'adverts' => $adverts,
            'vip' => $vip,
            'pagination' => $pagination,
            'categories' => $this->getTreeCategories(),
            'category' => $category,
        ];

		$this->buildBreadCrumbs();

		return $this->render('poster',  $params);
	}

	public function getIdCategoryBySysName($sys_name = false) {
		if(isset($this->list_category) && isset($this->list_category[ $sys_name ])) {
			return [ "category" => $this->list_category["$sys_name"]["id_category"] ];
		} else {
			foreach($this->list_category as $item) {
				if(isset($item) && isset($item["child"])) {
					foreach($item["child"] as $val) {
						if(isset($val) && isset($val["sys_name"]) && $val["sys_name"] == $sys_name) {
							return [ "category" => $item["id_category"], "category2" => $val["id_category"] ];
						}
					}
				}
			}
		}
	}

	public function getCategoryBySysName($sys_name = false) {
		if(isset($this->list_category) && isset($this->list_category[ $sys_name ])) {
			return $this->list_category[ $sys_name ];
		} else {
			foreach($this->list_category as $item) {
				if(isset($item) && isset($item["child"])) {
					foreach($item["child"] as $val) {
						if(isset($val) && isset($val["sys_name"]) && $val["sys_name"] == $sys_name) {
							return $val;
						}
					}
				}
			}
		}
	}

	public function actionCategory() {

		if(isset($_SESSION["filter"]) && $_SESSION["filter"] != []) {
			//TODO :: добавить вызов рест метода фильтров
			$_SESSION["filter"] = array_merge($_SESSION["filter"], $this->getIdCategoryBySysName($this->get("id")));
			$this->view->params["filter"] = $_SESSION["filter"];
			$response = $this->rest->get('advert/get-list-advert-filter', $_SESSION["filter"]);
			if(isset($response['res']) && $response['res'] != "") {
				$_list_adverts = json_decode($response['res'], true);
				if(isset($_list_adverts["result"]) && $_list_adverts["result"] != "" && isset($_list_adverts["data"])) {
					$this->list_advert = $_list_adverts["data"];
					$list_adverts = $this->getSlice($this->list_advert, $_SESSION["page_advert"]);
				}
			}
		} else {
			if ($this->get("id")) {
				if($this->getAdvertByCategory($this->get("id"))) {
					$list_adverts = $this->getSlice($this->list_advert, $_SESSION["page_advert"]);
				}
			}
		}
        $category = $this->getCategoryBySysName($this->get("id"));

		$this->setViewParams([
		    "title" => $category['seo_title'],
            "description" => $category['seo_desc']
        ]);

		$this->name_category = $category['value'];
		$this->buildBreadCrumbs();

		return $this->render('category', [
			'name_category' => $category['value'],
			"id_category" => $this->getIdCategoryBySysName($this->get("id")),
			'list_adverts' => $list_adverts,
			'count_page' => $this->calculationNumberPages($this->list_advert),
			'active_page' => $_SESSION["page_advert"]
		]);
	}

	public function actionAdvert() {
		$data_advert = [];
		if ($this->get("id")) {
			$response = $this->rest->get('advert/get-info-advert', [
			    'ext_meta_title' => $this->get("id")
            ]);

			if(isset($response['res']) && $response['res'] != "") {
				$_data_advert = json_decode($response['res'], true);
				if(isset($_data_advert["result"]) && $_data_advert["result"] != "" && isset($_data_advert["data"])) {
					$data_advert = $_data_advert["data"];
					$this->rest->get('/help/view-advert', [
					    'advert_id' => $data_advert['id_ads']
                    ]);
				}
			}
		}
		$advert_similar = [];
		if(isset($data_advert) && isset($data_advert["id_ads"]) && $data_advert["id_ads"] != "") {

			$response = $this->rest->get('advert/get-list-advert-similar', [
                'advert_id' => $data_advert['id_ads']
            ]);
			//dd($response);
			if(isset($response['res']) && $response['res'] != "") {
				$_list_adverts = json_decode($response['res'], true);
				if(isset($_list_adverts["result"]) && $_list_adverts["result"] != "" && isset($_list_adverts["data"])) {
					$this->list_advert = $_list_adverts["data"];
					$advert_similar = $this->getSlice($this->list_advert, $_SESSION["page_advert"]);
				}
			}

		}

		$this->title_advert = $data_advert['title'];
		$this->name_category = $data_advert["category"]['name_category'] != "" ? $data_advert["category"]['name_category'] : $data_advert["category"]['name_sub_category'];
		$this->sysname_category = $data_advert["category"]['sys_name'] != "" ? $data_advert["category"]['sys_name'] : $data_advert["category"]['sys_name_sub_category'];

        $this->setViewParams([
            "title" => $data_advert['title'] . " | " . $this->name_category,
            "description" => (($data_advert['price'] > 0) ? $data_advert['price'] . " ₸ (KZT). " : "") . $data_advert['title'] . " | " . $this->name_category
        ]);

		$this->buildBreadCrumbs();

		return $this->render('advert', [
			'data_advert' => $data_advert,
			"advert_similar" => $advert_similar
		]);
	}

	public function actionSignIn() {
		if(isset($_SESSION) && isset($_SESSION["token"]) && $_SESSION["token"] != "") {
			$this->view->params["user_id"] = $_SESSION['user_id'];
			$this->view->params["is_login"] = true;
			$_SESSION["filter"] = [];

			$this->redirect(array('/profile'));
		} else {
			$this->redirect(array('/auth-reg/login'));
		}
	}

	public function actionSignOut() {
		if(isset($_SESSION['token'])) {
			$response = $this->rest->post("user/sign-out", [
                'token' => $_SESSION['token']
            ]);

			$res = json_decode($response['res'], true);
			$err = json_decode($response['err'], true);

			if($res == true) {
				unset($_SESSION['token']);
			} else {
				unset($_SESSION['token']);
			}

			return $this->goBack();
		} else {
			return $this->goBack();
		}
	}

	public function actionSignUp()
    {
		$this->session->setFlash('alerts', "");
		$login = $this->post("login");
		$password = $this->post("password");
		$password_repeat = $this->post("password_repeat");
		$email = $this->post("email");

		if ($login && $password && $password_repeat) {
			$this->status = true;

			$result = $this->rest->post("user/sign-up", [
                'username' => $login,
                'password' => $password,
                'email' => $email,
                'ra' => $this->post("check-term")
            ]);
			$res = json_decode($result['res'], true);

			if($res['result'] == true && isset($res['data']['token']) && $res['data']['token'] != "") {
				$_SESSION['token'] = $res['data']['token'];
				$_SESSION['user_id'] = $res['data']['id'];
				$this->view->params["user_id"] = $res['data']['id'];
				$this->view->params["is_login"] = true;
				$_SESSION['log_name'] = $this->post("login");

				$this->redirect(['profile']);
			} else {
				$session = Yii::$app->session;
				$session->setFlash('alerts', $res['data']);
				$this->redirect(['auth-reg/signup']);
			}
		} else {
			$this->redirect(['auth-reg/signup']);
		}
	}

	public function actionContact() {
		$model = new ContactForm();
		if($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
			Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		}

		return $this->render('contact', [
			'model' => $model,
		]);
	}

	public function actionAbout() {
		return $this->render('about');
	}

	public function actionLanguages() {
		$session = $this->session;
        $language = $this->get("language");
		if (!$session->isActive) {
			$session->open();
		}

		if ($this->request->isGet) {
			if ($language) {
                $response = $this->rest->get('help/categories', [
                    'language' => $this->get("language")
                ]);
                if ($response['res']) {
                    $_list_categs = json_decode($response['res'], true);
                    if(isset($_list_categs["result"]) && $_list_categs["result"] != "" && isset($_list_categs["data"])) {
                        $this->view->params["list_categs"] = [];
                        foreach($_list_categs["data"] as $val) {
                            $this->view->params["list_categs"][] = [ "label" => $val["russian"] ];
                        }
                    }
                }
			}
		}

		$session['lang_title'] = $this->languages[$language];
		$session['categories'] = $this->view->params["list_categs"];

		return $this->render('index');
	}

	public function actionAuthReg()
    {
		if($this->get("id")) {
			$page = $this->get("id");
		}else{
			$page = "login";
		}

		if($this->isUserOnline()) {
			return $this->redirect('/profile');
		} else {
			$this->buildBreadCrumbs();

			$model_signin = new LoginForm();
			$model_signup = new SignUpForm();

			return $this->render('auth-reg', [
                "page" => $page,
                "model_signin" => $model_signin,
                "model_signup" => $model_signup
            ]);
		}
	}

	public function actionRestorePass()
    {
		if ($this->isUserOnline()) {
            return $this->redirect('/profile');
        }else{
			return $this->render('restore-pass', []);
		}
	}

	public function actionTerms()
    {
		return $this->render('terms', []);
	}



	private function isUserOnline() {
		$result = false;
		if(isset($_SESSION['token']) && $_SESSION['token'] != "") {

			$response = $this->rest->post("user/user-online", [
                'token' => $_SESSION['token']
            ]);

			if(isset($response) && isset($response["res"]) && $response["res"] != "") {
				$_tmp = json_decode($response["res"], true);
				if(isset($_tmp) && isset($_tmp["result"]) && isset($_tmp["data"]) && $_tmp["data"] == "no_open_session") {
					unset($_SESSION['token']);
					$result = false;
				} else {
					$result = true;
				}
			}
		}

		return $result;
	}

	public function actionProfile() {
		if($this->isUserOnline()) {
			$this->buildBreadCrumbs();

			return $this->render('profile', [
				'affiliation' => $this->affiliation,
				'page' => 'main'
			]);
		} else {
			return $this->redirect('/');
		}
	}

	public function actionProfileMyAds() {
		if($this->isUserOnline()) {
			$this->buildBreadCrumbs();

			$_SESSION["page_advert"] = 0;
			$url_ads = Yii::$app->params['root_rest_url'] . "advert/get-list-my-advert?token=" . $_SESSION['token'];
			$get_my_ads = $this->rest->get($url_ads);
			$my_ads = json_decode($get_my_ads['res'], true);

			$list_adverts = [];

			if(isset($my_ads['result']) && $my_ads['result'] == true && isset($my_ads['data'])) {
				$list_adverts = $this->getSlice($my_ads['data'], $_SESSION["page_advert"]);
			}

			return $this->render('profile', [
				'list_adverts' => $list_adverts,
				'count_page' => $this->calculationNumberPages($my_ads['data']),
				'active_page' => $_SESSION["page_advert"],
				'city' => $this->list_cities,
				'page' => 'myAds'
			]);
		} else {
			return $this->redirect('/');
		}
	}

	public function actionProfileMessage() {
	    $type = ($this->get("id")) ? $this->get("id") : "inbox";
		if($this->isUserOnline()) {
			$this->buildBreadCrumbs();
			$model = [];
			$url = Yii::$app->params['root_rest_url'] . 'message/list-my-messages?token=' . $_SESSION['token'];

			if(isset($_SESSION["message_search"]) && $_SESSION["message_search"] != "") {
				$url .= "&text_search=" . $_SESSION["message_search"];
			}

			Yii::info($url);
			$response = $this->rest->get($url);
            //dd($response);

			if(isset($response['res']) && $response['res'] != "") {
				$_list_messages = json_decode($response['res'], true);
                //dd($_list_messages);
				if(isset($_list_messages["result"]) && $_list_messages["result"] != "" && isset($_list_messages["data"])) {
					$model = $_list_messages["data"];
				}
			}

			return $this->render('profile', [
				'model' => $model,
                'type' => $type,
				'page' => 'message'
			]);
		} else {
			return $this->redirect('/');
		}
	}

	public function actionProfileMessageChat() {
		if($this->isUserOnline()) {
			$this->buildBreadCrumbs();
			$model = [];
			$this_user = [];
			$interlocutor = [];

			$_post = $this->rest->post("message/read-message", [
                "token" => $_SESSION['token'],
                "idMessage" => $this->get("id")
            ]);

			$response = $this->rest->get('message/get-chain-message', [
                'token' => $_SESSION['token'],
                'idMessage' => $this->get("id")
            ]);

			if(isset($response['res']) && $response['res'] != "") {
				$_list_messages = json_decode($response['res'], true);
				if(isset($_list_messages["result"]) && $_list_messages["result"] != "" && isset($_list_messages["data"])) {
					$model = $_list_messages["data"]['msgs'];
                    $this_user = $_list_messages["data"]['this_user'];
                    $interlocutor = $_list_messages["data"]['interlocutor'];
//                    print_r($_list_messages["data"]['interlocutor']);exit();
				}
			}

			return $this->render('profile', [
				'model' => $model,
				'this_user' => $this_user,
				'interlocutor' => $interlocutor,
				'page' => 'message-chat',
				"idMessage" => $this->get("id")
			]);
		} else {
			return $this->redirect('/');
		}
	}

	public function actionProfileFavourite() {
		if($this->isUserOnline()) {
			$this->buildBreadCrumbs();

			$_SESSION["page_advert"] = 0;

            $favourite = $this->rest->get('advert/get-list-my-favorites-advert', [
			    'token' => $_SESSION['token']
            ]);

			$list_adverts = [];

			if(isset($favourite['result']) && $favourite['result'] == true && isset($favourite['data'])) {
				$list_adverts = $this->getSlice($favourite['data'], $_SESSION["page_advert"]);
			}

			return $this->render('profile', [
				'list_adverts' => $list_adverts,
				'count_page' => $this->calculationNumberPages($favourite['data']),
				'active_page' => $_SESSION["page_advert"],
				'city' => $this->list_cities,
				'page' => 'favourite'
			]);
		} else {
			return $this->redirect('/');
		}
	}

	public function actionProfileDeleteAcc() {
		if ($this->isUserOnline()) {
			$this->buildBreadCrumbs();

			return $this->render('profile', [
				'page' => 'deleteAcc'
			]);
		} else {
			return $this->redirect('/');
		}
	}

	public function actionEditAdvert() {
        $model = [];
        $type = "";

		if($this->isUserOnline()) {
			$this->buildBreadCrumbs();

			if ($this->get("id") == "new") {
				$type = "new";
			}else if((int)$this->get("id")){
                $type = "edit";
				$model = [];

				$get_my_ads = $this->rest->get('advert/get-info-advert', [
				    'token' => $_SESSION['token'],
                    'advert_id' => $this->get("id")
                ]);

				$my_ads = json_decode($get_my_ads['res'], true);
				if(!$my_ads['result']){
				    return $this->redirect('/404');
                }
				if(isset($my_ads['result']) && $my_ads['result'] == true && isset($my_ads['data'])) {
					$model = $my_ads['data'];
				}
			}

			return $this->render('edit_advert', [
				"model" => $model,
                "profile_user" => $this->view->params["profile_user"]["profile_user"],
				"list_category" => $this->list_category,
				"list_country" => $this->list_countries,
				"list_currency" => $this->list_currency,
				"affiliation" => $this->affiliation,
				"type" => $type,
				"advert_id" => $this->get("id")
			]);
		} else {
			return $this->redirect('/auth-reg/login');
		}
	}

	public function actionStartSearch()
    {
        $response = [];
        $response['data'] = $this->post();
		if($this->request->isAjax) {
			if ($this->post()) {
				$_SESSION["page_advert"] = 0;

                $response['status'] = true;

				if(isset($_SESSION["filter"]) && $_SESSION["filter"] != []) {
					$_SESSION["filter"] = array_merge($_SESSION["filter"], $this->post());
				} else {
					$_SESSION["filter"] = $this->post();
				}
			} else {
				$response['status'] = false;
			}
		}
        return $this->json = $response;
	}

	public function actionProfileMyPayments() {
		if ($this->isUserOnline()) {
			$content = "";
			if($this->request->isPost) {
				if ($this->post("is_save") && $this->post("slider-money")) {
					$_post = $this->rest->post("payments/money-transfer", [
                        "token" => $_SESSION['token'],
                        "sum" => $this->post("slider-money")
                    ]);
					$res = json_decode($_post['res'], true);
					if(isset($res) && isset($res["result"]) && $res["result"] == true) {
						$content = $res["data"];
					}

				}
			}

			return $this->render('profile-my-payments', [
				'content' => $content
			]);
		} else {
			return $this->redirect('/');
		}
	}

	public function actionQuestion() {
		return $this->render('question', []);
	}

	public function actionGaranty() {
		return $this->render('garanty', []);
	}

	public function actionAdvertising() {
		return $this->render('advertising', []);
	}

	public function actionAddPro()
    {
        $this->getListConfig();
	    $ads = new Advertisement();
	    $ads->setPackages($this->config);
        $model = [];

        $this->setViewParams([
            "packages" => $ads->getPackages(),
            "addons" => $ads->getAddons()
        ]);
		if($this->isUserOnline()) {
			if ($this->get("id")) {
				$get_my_ads = $this->rest->get('advert/get-info-advert', [
				    'token' => $_SESSION['token'],
                    'advert_id' => $this->get("id")
                ]);

				$my_ads = json_decode($get_my_ads['res'], true);
				if(isset($my_ads['result']) && $my_ads['result'] == true && isset($my_ads['data'])) {
					$model = $my_ads['data'];
				}
			}

			return $this->render('add-pro', [
				"model" => $model
			]);
		} else {
			return $this->redirect('/');
		}
	}

    public function actionPageMessage()
    {
	    $msg = $this->get("id");

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
        return $this->render('page-message', $params);
    }

	public function actionPaymentSuccessful() {
		return $this->render('payment-successful', []);
	}

	public function actionPaymentFail() {
		return $this->render('payment-fail', []);
	}

	public function actionCallbackPayment() {
		if($this->request->isPost) {
			$_post = $this->rest->post("payments/call-back-walletone", $this->post());
			$res = json_decode($_post['res'], true);
			if(isset($res) && isset($res["data"])) {
				echo $res["data"];
			}
		}
	}

	public function setMetaTags($data)
    {
        $view = $this->view;
        if(isset($data['title']) && $data['title']){
            $view->title = $data['title'];
        }
        if(isset($data['description']) && $data['description']){
            $view->registerMetaTag(['name' => 'description', 'content' => $data['description']], 'description');
        }
    }

	public function getPageInfo($url = false)
    {
        $contents = $this->getDependence('contents');
        $url = ($url) ? $url : $this->url;
        foreach ($contents as $content) {
            if($content['link'] == $url){
                return $content;
            }
        }
        return [];
    }

	public function getCategory($slug = false)
    {
        $categories = $this->getDependence('categories');
        if($categories) {
            foreach ($categories as $category) {
                if ($category['sys_name'] == $slug) {
                    return $category;
                }
            }
        }
        return $categories;
    }

	public function getTreeCategories()
    {
        $treeBuilder = new TreeBuilder($this->getDependence('categories'), 'id_category', 'id_parent');
        $categories = $treeBuilder->buildTree();
        return $categories;
    }
}
