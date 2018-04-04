<?php
namespace api\controllers;

use yii\rest\Controller;
use common\models\Publishers;

/**
 * Publisher controller
 */
class PublisherController extends Controller
{
    public function actionPublishers()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        return Publishers::find()->all();
    }

    public function actionPublisher($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $publisher = Publishers::find()
            ->where([ 'id' => $id ])
            ->one();

        return $publisher;
    }
}
