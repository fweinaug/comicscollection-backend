<?php
namespace api\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;
use common\models\Issues;
use common\models\IssueSettings;

/**
 * Issue controller
 */
class IssueController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update' => ['PATCH'],
                    'settings' => ['PUT'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $profileId = Yii::$app->request->headers->get('ProfileID');

        return Issues::getIssuesWithSettings($profileId);
    }

    public function actionView($id) {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $profileId = Yii::$app->request->headers->get('ProfileID');

        return Issues::getIssueWithSettings($id, $profileId);
    }

    public function actionUpdate($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $model = Issues::findOne($id);
        if ($model !== null && $model->load(\Yii::$app->request->post(), '') && $model->save()) {
            $profileId = Yii::$app->request->headers->get('ProfileID');

            return Issues::getIssueWithSettings($id, $profileId);
        }

        Yii::$app->response->statusCode = 304;
    }

    public function actionSettings($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $profileId = Yii::$app->request->headers->get('ProfileID');
        $read      = (int)\Yii::$app->request->post('read');

        $conditions = [
            'profile_id' => $profileId,
            'issue_id' => $id,
        ];

        if (IssueSettings::updateAll([ 'read' => $read ], $conditions) > 0) {
            return Issues::getIssueWithSettings($id, $profileId);
        }

        Yii::$app->response->statusCode = 304;
    }
}
