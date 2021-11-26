<?php

namespace api\base;

use Yii;

class Response
{

    public static function success($message = null, $data = null, $customOptions = []): array
    {
        Yii::$app->response->setStatusCode(200);
        return array_merge($customOptions, [
            'success'   => true,
            'message'   => $message,
            'data'      => $data,
        ]);
    }

    public static function error($message = null, $errors = [],$data = null): array
    {
        Yii::$app->response->setStatusCode(400);
        return [
            'success'   => false,
            'message'   => $message,
            'data'      => $data,
        ];
    }
}