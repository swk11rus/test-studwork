<?php

namespace api\models\forms;

use common\models\Note;

/**
 * @property string $title
 * @property string $text
 * @property string $datePublication
 * @property Note $note
 * @property int $updateId
 */

class NoteUpdateForm extends AbstractNoteForm
{
    public string $title;
    public string $text;
    public string $datePublication;
    public Note $note;
    public int $updateId;

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['datePublication'], 'safe'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 32],
            [['updateId'], 'integer'],
            [['updateId'], 'required'],
            [['updateId'], 'validateExistNote'],
            [['updateId'], 'checkAccess'],
        ];
    }

    public function validateExistNote($attribute)
    {
        $note = \common\models\Note::findOne(['id' => $this->$attribute]);
        if (!$note) {
            $this->addError($attribute, "Не найдена заметка с ID [{$this->$attribute}]");
        }
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $note = Note::findOne(['id' => $this->updateId]);

        if ($note->user_id !== \Yii::$app->user->id) {
            $this->addError('updateId', "Доступ к изменению только у создателя заметки");
            return false;
        }

        $note->title = $this->title;
        $note->text = $this->text ?: $note->text;
        $note->date_publication = $this->datePublication ?: $note->date_publication ;

        if (!$note->save()) {
            $this->addErrors($note->getErrors());
            return false;
        }
        $this->note = $note;

        return true;
    }

    public function getSuccessMessage(): string
    {
        return 'Заявка обновлена';
    }

    public function generateResponseData(): ?\api\models\Note
    {
        return \api\models\Note::findOne(['id' => $this->note->id]);
    }

}