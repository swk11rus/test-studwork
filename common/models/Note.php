<?php

namespace common\models;

use common\components\Utility;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "note".
 *
 * @property int $id
 * @property string $title
 * @property string|null $text
 * @property int $user_id
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_publication
 * @property string $date_deleted
 *
 * @property User $user
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'note';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => ['date_created', 'date_publication' ] ,
                'updatedAtAttribute' => 'date_updated',
                'value' => Utility::getDateNow(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'user_id'], 'required'],
            [['text'], 'string'],
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['date_created', 'date_updated', 'date_publication', 'date_deleted'], 'safe'],
//            [['date_publication'], 'default', 'value' => Utility::getDateNow()],
            [['title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'user_id' => 'User ID',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'date_publication' => 'Date Publication',
            'date_deleted' => 'Date Deleted',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\NoteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\NoteQuery(get_called_class());
    }

    public function delete(): bool
    {
        $this->date_deleted = Utility::getDateNow();
        return $this->save();
    }
}
