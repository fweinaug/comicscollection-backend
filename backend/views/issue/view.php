<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Issues */

$this->title = $model->comic->name.' #'.$model->number;
$this->params['breadcrumbs'][] = ['label' => 'Issues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issues-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Upload Image', ['upload-image', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Comic',
                'value' => Html::a($model->comic->name, ['comic/view', 'id' => $model->comic->id]),
                'format' => 'raw',
            ],
            'number',
            'title',
            [
                'label' => 'Image',
                'format' => 'html',
                'value' => function ($model) {
                    $url = $model->getImageUrl();
                    return $url !== null ? Html::a(
                        Html::img($url, [ 'height'=>'200' ]),
                        ['image/view', 'id' => $model->image_id]
                    ) : null;
                }
            ],
            'release_date:date',
            'summary:ntext',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
