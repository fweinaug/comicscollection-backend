<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Comics */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Comics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comics-view">

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
        <?= Html::a('Add Issue', ['issue/create', 'comic_id' => $model->id, 'number' => $model->issues_total + 1], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'image_data',
                'label' => 'Image',
                'value' => $model->getImageUrl(),
                'format' => [ 'image', [ 'width'=>'150','height'=>'200' ]],
            ],
            'issues_total',
            [
                'label' => 'Publisher',
                'value' => Html::a($model->publisher->name, ['publisher/view', 'id' => $model->publisher->id]),
                'format' => 'raw',
            ],
            'concluded:boolean',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <h2>Issues</h2>

    <?= GridView::widget([
        'dataProvider' => $issuesDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'number',
            'title',
            [
                'label' => 'Image',
                'format' => 'html',
                'content' => function($model) {
                    $url = $model->getImageUrl();
                    return Html::img($url, [ 'width'=>'75','height'=>'100' ]);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['issue/'.$action, 'id' => $model->id]);
            }
        ],
        ],
    ]); ?>

</div>
