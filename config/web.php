<?php

$params = require( __DIR__ . '/params.php' );
$db     = require( __DIR__ . '/db.php' );

$config = [
	'id'         => 'basic',
	'basePath'   => dirname( __DIR__ ),
	'bootstrap'  => [ 'log' ],
	'components' => [
		'request'      => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => 'asdfaksd;kq;3234;das;fladsf95-asdfasdf',
		],
		'cache'        => [
			'class' => 'yii\caching\FileCache',
		],
		'user'         => [
			'identityClass'   => 'app\models\User',
			'enableAutoLogin' => true,
		],
		'errorHandler' => [
			'errorAction'    => 'site/error',
			'maxSourceLines' => 20,
		],
		'mailer'       => [
			'class'            => 'yii\swiftmailer\Mailer',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => true,
		],
		'log'          => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets'    => [
				[
					'class'   => 'yii\log\FileTarget',
					'levels'  => [ 'error', 'info' ],
					'logVars' => []
				],
				[
					'class'      => 'yii\log\FileTarget',
					'categories' => [ 'debug' ],
					'logFile'    => '@app/runtime/logs/debug.log',
				]

			],
		],
		'db'           => $db,

		'urlManager' => [
			'enablePrettyUrl'     => true,
			'showScriptName'      => false,
			'enableStrictParsing' => true,
			'rules'               => [
				//'<action:(.*)>' => 'site/<action>',
				//'<action:(.*)>/<id:\w+>' => 'site/<action>/<id>',
				'/'                              => 'site/index',
				'sign-up'                        => 'site/sign-up',
				'sign-in'                        => 'site/sign-in',
				'sign-out'                       => 'site/sign-out',
				'auth-reg/<id:(.*)>'             => 'site/auth-reg',
				'category/<id:(.*)>'             => 'site/search',
				'advert/<id:(.*)>'               => 'site/advert/',
				'profile'                        => 'site/profile',
				'edit-advert/<id:(.*)>'          => 'site/edit-advert/',
				'add-advert'                     => 'site/add-advert',
				'change-language'                => 'site/change-language',
				'send-img'                       => 'site/send-img',
				'restore-pass'                   => 'site/restore-pass',
				'terms'                          => 'site/terms',
				'images'                         => '/images',
				'user-profile'                   => 'site/user-profile',
				'profile-my-ads'                 => 'site/profile-my-ads',
				'profile-message/<id:(.*)>'                => 'site/profile-message',
				'profile-message'                => 'site/profile-message',
				'profile-favourite'              => 'site/profile-favourite',
				'profile-message-chat/<id:(.*)>' => 'site/profile-message-chat',
				'profile-delete-acc'             => 'site/profile-delete-acc',
				'my-ads-page'                    => 'site/my-ads-page',
				'exempl'                         => 'site/exempl',
				'profile-my-ads-ajax'            => 'site/profile-my-ads-ajax',
				'profile-favourite-ajax'         => 'site/profile-favourite-ajax',
				'category-ajax'                  => 'site/category-ajax',
				'change-page'                    => 'site/change-page',
				'change-category'                => 'site/change-category',
				'start-search'                   => 'site/start-search',
				'profile-my-payments'            => 'site/profile-my-payments',
				'callback-payment'               => 'site/callback-payment',
				'payment-successful'             => 'site/payment-successful',
				'payment-fail'                   => 'site/payment-fail',
				'search'                         => 'site/search',
				'mess-search'                    => 'site/mess-search',
				'question'                       => 'site/question',
				'garanty'                        => 'site/garanty',
				'advertising'                    => 'site/advertising',
				'add-pro/<id:(.*)>'              => 'site/add-pro/',
                'message/<id:(.*)>'            => 'site/page-message', ///<msg: (.*)>

				'delete-advert'          => 'rest/delete-advert',
				'upload-image'           => 'rest/upload-image',
				'delete-image'           => 'rest/delete-image',
				'save-advert'            => 'rest/save-advert',
				'save-profile'           => 'rest/save-profile',
				'send-message'           => 'rest/send-message',
				'get-phone-user'         => 'rest/get-phone-user',
                'check-msgs'             => 'rest/check-msgs-by-id',
				'get-city'               => 'rest/get-city',
				'add-advert-favorite'    => 'rest/add-advert-favorite',
				'remove-advert-favorite' => 'rest/remove-advert-favorite',
				'sign_up'                => 'rest/sign-up',
				'sign_in'                => 'rest/sign-in',
				'delete-account'         => 'rest/delete-account',
				'add-money'              => 'rest/add-money',
				'liftup-advert'          => 'rest/liftup-advert',
				'feedback'               => 'rest/feedback',
				'add-pro-advert'         => 'rest/add-pro-advert',
				'restore-password'       => 'rest/restore-password',
				'delete-message'         => 'rest/delete-message'

			],
		],

	],
	'params'     => $params,
];

if ( YII_ENV_DEV ) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][]      = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		//'allowedIPs' => ['127.0.0.1', '::1'],
	];

	$config['bootstrap'][]    = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		//'allowedIPs' => ['127.0.0.1', '::1'],
	];
}

return $config;
