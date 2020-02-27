<?php
namespace api\controllers;

use yii\rest\Controller;
use yii\web\Response;
use common\models\Images;

/**
 * Image controller
 */
class ImageController extends Controller
{
    public function actionView($id)
    {
        \Yii::$app->response->format = Response::FORMAT_RAW;

        return Images::find()
            ->select('image_data')
            ->where([ 'id' => $id ])
            ->scalar();
    }

    public function actionThumbnail($id)
    {
        \Yii::$app->response->format = Response::FORMAT_RAW;

        return Images::find()
            ->select('thumb_data')
            ->where([ 'id' => $id ])
            ->scalar();
    }
}
