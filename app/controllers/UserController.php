<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class UserController extends WebController
{
    public function behaviors()
    {
        $behaviours = parent::behaviors();
        $behaviours['access'] = [
            'class' => AccessControl::className(),
            'only' => [ 'logout' ],
            'rules' => [
                [
                    'actions' => [ 'logout' ],
                    'allow' => true,
                    'roles' => [ '@' ],
                ],
            ],
        ];
        $behaviours['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => [ 'post' ],
            ],
        ];
        return $behaviours;
    }
}