<?php
namespace api\controllers;

use yii\rest\Controller;
use common\models\Profiles;

/**
 * Profile controller
 */
class ProfileController extends Controller
{
    public function actionProfiles()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        return Profiles::find()->all();
    }
}
