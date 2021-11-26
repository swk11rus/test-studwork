<?php

namespace api\controllers;

use common\components\events\behavior\EventCheckStatusAccount;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class RestController extends \yii\rest\Controller
{

    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::class,
                'optional' => ['*']
            ],
            'corsFilter' => [
                'class' => Cors::class,
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ]);
    }
    public function actionTest()
    {
        return \Yii::$app->user->identity->getId();
    }

}