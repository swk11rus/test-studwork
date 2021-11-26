<?php

namespace common\components;

use common\models\User;
use Yii;

class Utility
{
    public static function getDateNow(\DateTimeZone $timezone = null, $format = 'Y-m-d H:i:s'): string
    {
        if (!$timezone) {
            $timezone = new \DateTimeZone(Yii::$app->params['timezone']);
        }
        $date = new \DateTime('now', $timezone);
        return $date->format($format);
    }

    public static function getModelErrorsString(\yii\base\Model $model): string
    {
        $errorList = $model->getFirstErrors();

        if (empty($errorList) || !is_array($errorList)) {
            return "";
        }

        return implode(PHP_EOL, $errorList);
    }

    public static function calculatePageCount(int $count, int $pageSize): int
    {
        return $count / $pageSize + (($count % $pageSize) ? 1 : 0);
    }

    public static function getCurrentUserId(): ?int
    {
        return !empty(Yii::$app->user->id)
            ? Yii::$app->user->id
            : null;
    }

    public static function getCurrentUser(): ?User
    {
        return User::findOne(static::getCurrentUserId());
    }
}