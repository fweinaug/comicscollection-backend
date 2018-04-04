<?php
namespace api\controllers;

use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\UploadedFile;
use common\models\Comics;
use common\models\Issues;
use common\models\IssueSettings;

/**
 * Comic controller
 */
class ComicController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'read'   => ['post'],
                ],
            ],
        ];
    }

    public function actionComics($profileId)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return Comics::getComicsWithSettings($profileId);
    }

    public function actionCreate($profileId)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new Comics();
        $model->load(\Yii::$app->request->post(), '');
        if ($model->save()) {
            return Comics::getComicWithSettings($profileId, $model->id);
        }

        return null;
    }

    public function actionRead()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $profileId = \Yii::$app->request->post('profileId');
        $comicId   = \Yii::$app->request->post('comicId');
        $issueId   = \Yii::$app->request->post('issueId');
        $read      = (bool)\Yii::$app->request->post('read');

        $conditions = [
            'profile_id' => $profileId,
            'comic_id' => $comicId,
        ];

        if ($issueId != null)
            $conditions['issue_id'] = $issueId;

        IssueSettings::updateAll([ 'read' => $read ], $conditions);

        return Comics::getComicWithSettings($profileId, $comicId);
    }
}
