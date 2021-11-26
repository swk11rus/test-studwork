<?php

namespace api\models\forms;

use common\models\Note;
use yii\base\Model;

/**
 *
 * @property-read string $successMessage
 */
abstract class AbstractNoteForm extends Model
{
    abstract public function save(): bool;
    abstract public function getSuccessMessage(): string;

    public function generateResponseData()
    {
        return null;
    }

    /**
     * @throws \Exception
     */
    public function checkAccess($attribute): void
    {
        $note = Note::findOne(['id' => $this->$attribute]);

        if (!$note) {
            $this->addError($attribute, "Заметки по id [{$this->$attribute}] не существует");
            return;
        }
        if ($note->user_id !== \Yii::$app->user->id) {
            $this->addError($attribute, "Доступ к действию только у создателя заметки");
            return;
        }

        $dateCreated = (new \DateTime($note->date_created))->modify('+1 day');
        $dateAction = new \DateTime();

        if ($dateCreated < $dateAction) {
            $this->addError($attribute, "Истек срок действий у заметки");
        }
    }
}