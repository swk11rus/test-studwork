<?php

namespace api\controllers;

use api\base\Response;
use api\components\NoteExecuteFormService;
use api\models\forms\NoteCreateForm;
use api\models\forms\NoteDeleteForm;
use api\models\forms\NoteUpdateForm;
use api\models\Note;
use api\models\NoteView;
use common\components\Utility;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class NoteController extends RestController
{

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors = ArrayHelper::merge($behaviors, [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET'],
                    'create' => ['POST'],
                    'update' => ['PUT'],
                    'delete' => ['DELETE'],
                ],
            ],
        ]);

        return $behaviors;
    }

    public function actionIndex(int $p = 0): array
    {
        $query = Note::find()
            ->notDeleted()
            ->accessed()
            ->orderBy([
            'date_publication' => SORT_DESC,
            'date_created' => SORT_ASC,
            'id' => SORT_ASC
        ]);
        $pageSize = 5;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $p,
            ]
        ]);

        return ArrayHelper::merge([
            'count' => $query->count(),
            'pageCount' => Utility::calculatePageCount($query->count(), $pageSize),
            'currentPage' => $p,
        ], $dataProvider->getModels());
    }

    public function actionView($id)
    {
        $note =  NoteView::find()
            ->notDeleted()
            ->accessed()
            ->andWhere(['id' => $id])
            ->one();
        return  $note ?: Response::error('Нет доступа') ;
    }

    public function actionCreate(): array
    {
        $service = new NoteExecuteFormService(new NoteCreateForm(Yii::$app->request->post()));
        return $service->exec();
    }

    public function actionUpdate(): array
    {
        $service = new NoteExecuteFormService(new NoteUpdateForm(Yii::$app->request->post()));
        return $service->exec();
    }

    public function actionDelete($id): array
    {
        $service = new NoteExecuteFormService(new NoteDeleteForm($id));
        return $service->exec();
    }
}