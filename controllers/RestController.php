<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\OrderForm;
use app\models\Order;
use app\models\Consts;
use app\models\Config;

class RestController extends Controller
{

    private $dataType = "json";
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
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


    public function beforeAction()
    {
        $request = new \yii\web\Request;
        $restAPI = $request->getHeaders()->get('REST_API');
        if($restAPI !== Config::REST_API_KEY){
            return $this->send([ "result" => false, "msg" => "invalid_data" ]);
        }
        return true;
    }

    public function actionGetOrders()
    {
        $orders = Order::getAll();
        return $this->send([ "result" => !(!($orders)), "data" => $orders ]);
    }

    public function actionGetConsts()
    {
        $consts = Consts::getAll();
//        print_r($consts);exit();
        return $this->send([ "result" => !(!($consts)), "data" => $consts ]);
    }

    public function actionUpdateOrder()
    {
        $response = [ "result" => false, "msg" => "invalid_data" ];
        $post = Yii::$app->request->post();

        if((int)$post['order_id'] && $post['data']){
            $response = Order::updateOrder($post);
        }
        return $this->send($response);
    }

    public function actionUpdateConst()
    {
        $response = [ "result" => false, "msg" => "invalid_data" ];
        $post = Yii::$app->request->post();

        if((int)$post['const_id'] && $post['data']){
            $response = Consts::updateConst($post);
        }
        return $this->send($response);
    }

    public function actionCreateOrder()
    {
        $post = Yii::$app->request->post();
        $response = [ "result" => false, "msg" => "invalid_data" ];
        $model = new OrderForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $order = new Order();
            foreach ($post['data'] as $k => $v) {
                $order->$k = $v;
            }
            $order->save();
            if($order->save()) {
                $response = [
                    'msg' => "success_added_order",
                    'result' => true
                ];
            }
        }

        return $this->send($response);
    }

    public function send($data){
        if($this->dataType == "json"){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $data;
        }else if($this->dataType == "html"){
            return htmlspecialchars_decode(str_replace(['\n', '\r', "\\"], "", $data));
        }else{
            return $data;
        }
    }
}
