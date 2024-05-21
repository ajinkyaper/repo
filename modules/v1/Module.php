<?php



namespace app\modules\v1;

use Yii;

/**
 * v1 module definition class
 */
class Module extends \yii\base\Module
{

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\v1\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        Yii::$app->setComponents([
            'request' => [
                'cookieValidationKey' => 's3dXsgmYFWs_pQwiXGdVF6BW9YVqI_yh',
                'csrfCookie' => ['httpOnly' => true, 'secure' => true],
                'class' => 'yii\web\Request',
                'csrfParam' => '_csrf-api',
                'parsers' => [
                    'application/json' => 'yii\web\JsonParser',
                ]
            ],
            'response' => [
                'class' => 'yii\web\Response',
                'on beforeSend' => function ($event) {

                    $response = $event->sender;

                    if ($response->statusCode == 200) {
                        if ($response->data == null) {
                            $response->data = [
                                'status' => $response->isSuccessful,
                                'code' => $response->statusCode,
                                'message' => $response->content,
                                // 'data' => $response->data
                            ];
                        } else {
                            $response->data = [
                                'status' => $response->isSuccessful,
                                'code' => $response->statusCode,
                                'message' => $response->content,
                                'data' => $response->data
                            ];
                        }
                    } else {

                        $response->data = [
                            'status' => false,
                            'code' => $response->statusCode,
                            'message' => $response->data['name'],
                        ];
                    }
                    $response->data = ['data' => Yii::$app->api->jwtEncode($response->data)];
                },
                'formatters' => [
                    \yii\web\Response::FORMAT_JSON => [
                        'class' => 'yii\web\JsonResponseFormatter',
                        'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                        'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                        // ...
                    ],
                ],
            ]
        ]);

        // custom initialization code goes here
    }
}
