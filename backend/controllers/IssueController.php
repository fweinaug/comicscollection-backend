<?php

namespace backend\controllers;

use Yii;
use common\models\Images;
use common\models\Issues;
use common\models\IssuesSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * IssueController implements the CRUD actions for Issues model.
 */
class IssueController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Issues models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IssuesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'defaultOrder' => [ 'comic_id' => SORT_ASC, 'number' => SORT_ASC ],
            'attributes' => [
                'comic_id' => [
                    'asc' => [ 'comics.name' => SORT_ASC ],
                    'desc' => [ 'comics.name' => SORT_DESC ],
                ],
                'number',
                'title',
            ],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Issues model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Issues model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Issues();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->load(Yii::$app->request->get(), '');

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Issues model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Issues model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUploadImage($id)
    {
        $model = new Images();
        $issue = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'image_file');

            if ($file && !$file->hasError && $model->setData($file)) {
                if ($issue->updateImage($model)) {
                    return $this->redirect(['view', 'id' => $issue->id]);
                }
            } else {
                $message = 'Image could not be uploaded.';
                if ($file && $file->hasError)
                    $message .= " (Error Code: $file->error)";

                \Yii::$app->session->setFlash('error', $message);
            }
        }

        return $this->render('upload-image', [
            'model' => $model,
            'issue' => $issue,
        ]);
    }

    /**
     * Finds the Issues model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Issues the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Issues::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
