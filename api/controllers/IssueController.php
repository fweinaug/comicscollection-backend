<?php
namespace api\controllers;

use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\UploadedFile;
use common\models\Comics;
use common\models\Issues;
use common\models\Images;

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
                    'create' => ['post'],
                    'update' => ['post'],
                ],
            ],
        ];
    }

    public function actionIssues($profileId, $comicId)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return Issues::getIssuesOfComicWithSettings($comicId, $profileId);
    }

    public function actionCreate($profileId)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $model = new Issues();
            if ($model->load(\Yii::$app->request->post(), ''))
            {
                $file = UploadedFile::getInstanceByName('upload');

                $image = new Images();

                if ($image->setData($file) && $image->save()) {
                    $model->image_id = $image->id;
                    $model->number = Issues::getNextIssueNumber($model->comic_id);

                    if ($model->save()) {
                        $transaction->commit();

                        return Comics::getComicWithSettings($profileId, $model->comic_id);
                    }
                }
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return null;
    }

    public function actionUpdate($profileId, $issueId)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = Issues::findOne($issueId);
        if ($model !== null && $model->load(\Yii::$app->request->post(), '') && $model->save()) {
            return Issues::getIssueWithSettings($issueId, $profileId);
        }

        return null;
    }
}
