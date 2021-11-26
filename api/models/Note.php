<?php

namespace api\models;

class Note extends \common\models\Note
{
    public function fields(): array
    {
        $fields = [
            'id',
            'title',
            'date_publication',
        ];

        $fields['username'] = function (self $model) {
            return $model->user->username;
        };

        return $fields;
    }
}