<?php

namespace api\models;

use yii\helpers\ArrayHelper;

class NoteView extends Note
{
    public function fields(): array
    {
        return ArrayHelper::merge(parent::fields(), [
            'text'
        ]);
    }
}