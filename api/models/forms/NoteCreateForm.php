<?php

namespace api\models\forms;

use common\components\Utility;
use common\models\Note;

/**
 * @property string $title
 * @property string $text
 * @property string $datePublication
 * @property Note $note
 */

class NoteCreateForm extends AbstractNoteForm
{
    public string $title;
    public string $text;
    public string $datePublication;
    public Note $note;

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['datePublication'], 'safe'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 32],
        ];
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $note = new Note();
        $note->user_id = \Yii::$app->user->id;
        $note->title = $this->title;
        $note->text = $this->text ?? null;
        $note->date_publication = $this->datePublication ?? Utility::getDateNow();

        if (!$note->save()) {
            $this->addErrors($note->getErrors());
            return false;
        }
        $this->note = $note;

        return true;
    }

    public function getSuccessMessage(): string
    {
        return 'Заявка создана';
    }

    public function generateResponseData(): ?\api\models\Note
    {
        return \api\models\Note::findOne(['id' => $this->note->id]);
    }
}