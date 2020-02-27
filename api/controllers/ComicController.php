<?php
namespace api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use common\models\Comics;
use common\models\Issues;

/**
 * Comic controller
 */
class ComicController extends Controller
{
    public function actionIndex()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $profileId = Yii::$app->request->headers->get('ProfileID');

        return Comics::getComicsWithSettings($profileId);
    }

    public function actionView($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $profileId = Yii::$app->request->headers->get('ProfileID');

        return Comics::getComicWithSettings($profileId, $id);
    }

    public function actionIssues($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $profileId = Yii::$app->request->headers->get('ProfileID');

        return Issues::getIssuesOfComicWithSettings($id, $profileId);
    }
}
