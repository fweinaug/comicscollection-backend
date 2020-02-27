<?php
namespace api\controllers;

use yii\rest\Controller;
use yii\web\Response;
use common\models\Publishers;

/**
 * Publisher controller
 */
class PublisherController extends Controller
{
    public function actionIndex()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        
        return Publishers::find()->all();
    }

    public function actionView($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        
        return Publishers::findOne($id);
    }
}
