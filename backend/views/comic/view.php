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
        <?= Html::a('Add Issue', ['issue/create', 'comic_id' => $model->id, 'number' => $model->issues_count + 1], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Manage Creators', ['/comic-creators', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'label' => 'Publisher',
                'value' => Html::a($model->publisher->name, ['publisher/view', 'id' => $model->publisher->id]),
                'format' => 'raw',
            ],
            [
                'label' => 'Creators',
                'format' => 'html',
                'value' => function ($model) {
                    $creators = $model->creators;
                    if (empty($model->creators)) {
                        return null;
                    }

                    $items = array_map(function ($creator) {
                        $text = Html::a($creator->person->name, ['person/view', 'id' => $creator->person->id]);

                        if (!empty($creator->contribution)) {
                            $text .= " ($creator->contribution)";
                        }

                        return $text;
                    }, $creators);

                    return Html::ul($items, ['encode' => false, 'class' => 'list-unstyled', 'style' => 'margin:0']);
                }
            ],
            [
                'label' => 'Image',
                'format' => 'html',
                'value' => function ($model) {
                    $url = $model->getImageUrl();
                    return $url !== null ? Html::a(
                        Html::img($url, [ 'width'=>'150','height'=>'200' ]),
                        ['image/view', 'id' => $model->image_id]
                    ) : null;
                }
            ],
            'issues_count',
            'issues_total',
            'concluded:boolean',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <h2>Issues</h2>

    <?= GridView::widget([
        'dataProvider' => $issuesDataProvider,
        'columns' => [
            [
                'format' => 'html',
                'content' => function($model) {
                    $url = $model->getImageUrl();
                    return $url !== null ? Html::a(Html::img($url, [ 'width'=>'75','height'=>'100' ]), ['issue/view', 'id' => $model->id]) : null;
                },
                'contentOptions' => ['style' => 'width:100px;'],
            ],
            'number',
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->title, ['issue/view', 'id' => $model->id]);
                },
            ],
            'release_date',

            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['issue/'.$action, 'id' => $model->id]);
                },
                'contentOptions' => ['style' => 'width:100px;'],
            ],
        ],
    ]); ?>

</div>
