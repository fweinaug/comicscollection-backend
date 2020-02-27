<?php
namespace api\controllers;

use yii\rest\Controller;
use yii\web\Response;
use common\models\Profiles;

/**
 * Profile controller
 */
class ProfileController extends Controller
{
    public function actionIndex()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return Profiles::find()->all();
    }
}
