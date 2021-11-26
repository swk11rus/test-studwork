<?php

namespace common\models\query;

use common\components\Utility;
use common\models\User;

/**
 * This is the ActiveQuery class for [[\common\models\Note]].
 *
 * @see \common\models\Note
 */
class NoteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Note[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Note|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function notDeleted(): self
    {
        return $this->andWhere(['date_deleted' => null]);
    }

    public function accessed(): self
    {
        $user = Utility::getCurrentUser();

        if (!$user) {
            return $this->published();
        }

        $this->andWhere([
            'OR',
            ['user_id' => $user->id],
            ['<=', 'date_publication', Utility::getDateNow()]
        ]);

        return $this;
    }

    public function published(): self
    {
        return $this->andWhere(['<=', 'date_publication', Utility::getDateNow()]);
    }

}
