<?php

namespace backend\controllers;

use Yii;
use common\models\Comics;
use common\models\ComicCreators;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComicCreatorsController implements the CRUD actions for ComicCreators model.
 */
class ComicCreatorsController extends Controller
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
     * @inheritdoc
     */
    public function getViewPath()
    {
        return Yii::getAlias('@backend/views/comic/creators');
    }

    /**
     * Lists all ComicCreators models.
     * @param $id
     * @return mixed
     */
    public function actionIndex($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ComicCreators::find()->where(['comic_id' => $id]),
        ]);

        $comic = Comics::findOne(['id' => $id]);

        return $this->render('index', [
            'comic' => $comic,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ComicCreators model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $comic_id
     * @return mixed
     */
    public function actionCreate($comic_id)
    {
        $model = new ComicCreators();
        $model->comic_id = $comic_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->comic_id]);
        }

        $comic = Comics::findOne(['id' => $comic_id]);

        return $this->render('create', [
            'comic' => $comic,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ComicCreators model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->comic_id]);
        }

        $comic = $model->comic;

        return $this->render('update', [
            'comic' => $comic,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ComicCreators model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index', 'id' => $model->comic_id]);
    }

    /**
     * Finds the ComicCreators model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ComicCreators the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComicCreators::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
