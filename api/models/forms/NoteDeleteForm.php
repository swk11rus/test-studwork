<?php

namespace api\models\forms;

use common\components\Utility;
use common\models\Note;

class NoteDeleteForm extends AbstractNoteForm
{
    public int $deleteId;

    /**
     * @param int $id
     * @param array|null $config
     */
    public function __construct($id, ?array $config = [])
    {
        parent::__construct($config);
        $this->deleteId = $id;
    }

    public function rules()
    {
        return [
            [['deleteId'], 'required'],
            [['deleteId'], 'integer'],
            [['deleteId'], 'checkAccess']
        ];
    }

    /**
     * @throws \yii\db\StaleObjectException
     * @throws \Throwable
     */
    function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $note = Note::findOne(['id' => $this->deleteId]);

        if (!$note->delete()) {
            $this->addErrors($note->getErrors());
            return false;
        }

        return true;
    }

    function getSuccessMessage(): string
    {
        return 'Заметка удалена';
    }
}