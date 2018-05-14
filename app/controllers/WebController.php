<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller as YiiController;
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

class WebController extends YiiController
{
    protected $app;
    protected $rest;
    protected $language;
    protected $currency;
    protected $request;
    protected $headers;
    protected $session;
    protected $json;
    protected $url;
    protected $dependencies = [];

    public function init(){
        parent::init();

        $app = $this->app = Yii::$app;
        $this->headers = $app->request->headers;
        $this->rest = $app->rest;
        $this->request = $app->request;
        $this->session = $app->session;
        $this->language = $app->language;
        $this->url = $app->request->url;
        $this->currency = 5;

        $app->session->open();
    }

    public function behaviors() {
        return [];
    }

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        return $result;
    }

    public function getDependence($route)
    {
        $deps = $this->rest->dependencies();
        if(isset($deps[$route])){
            return $deps[$route];
        }
        return [];
    }

    /**
     * Get parameter or all parameters from GET(PUT|PATCH|DELETE|HEAD) method's
     *
     * @param string $val the parameter key.
     * @return mixed.
     */
    public function get($val = null)
    {
        $request = $this->request;
        $params = $this->request->bodyParams;
        if($request->isGet){
            if($val){
                return $request->get($val);
            }else{
                return $request->get();
            }
        }else{
            if($val){
                return $params[$val];
            }else{
                return $params;
            }
        }
    }

    /**
     * Get parameter or all parameters from POST method's
     *
     * @param string $val the parameter key.
     * @return mixed.
     */
    public function post($val = null)
    {
        $request = $this->request;
        if($val){
            return $request->post($val);
        }else{
            return $request->post();
        }
    }
}