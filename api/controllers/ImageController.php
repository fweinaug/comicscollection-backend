<?php
namespace api\controllers;

use yii\rest\Controller;
use common\models\Images;

/**
 * Image controller
 */
class ImageController extends Controller
{
    public function actionRaw($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        $image = Images::find()
            ->select('image_data')
            ->where([ 'id' => $id ])
            ->scalar();

        return $image;
    }
}