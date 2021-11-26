<?php

namespace api\components;

use api\base\Response;
use api\models\forms\AbstractNoteForm;
use common\models\exceptions\ModelNotValidateException;
use Exception;
use Yii;

class NoteExecuteFormService
{
    private AbstractNoteForm $_form;

    /**
     * @param AbstractNoteForm $form
     */
    public function __construct(\api\models\forms\AbstractNoteForm $form)
    {
       $this->_form = $form;
    }

    public function exec(): array
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$this->_form->save()) {
                throw new ModelNotValidateException($this->_form);
            }

            $transaction->commit();

        } catch (Exception $e) {
            $transaction->rollBack();
            return Response::error('Ошибка: ' . $e->getMessage());
        }

        return Response::success(
            $this->_form->getSuccessMessage(),
            $this->_form->generateResponseData()
        );
    }
}