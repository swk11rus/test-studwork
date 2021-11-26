<?php

namespace common\models\exceptions;

use common\components\Utility;
use yii\base\Model;

class ModelNotValidateException extends \Exception
{
    private $_model;

    public function __construct(Model $model = null, $message = null, $code = 0, \Exception $previous = null)
    {
        $this->_model = $model;
        if ($message === null && $model) {
            $message = Utility::getModelErrorsString($model);
        }
        parent::__construct($message, $code, $previous);
    }

    public final function getModel(): Model
    {
        return $this->_model;
    }
}