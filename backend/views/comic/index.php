<?php

use common\models\Publishers;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ComicsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comics-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Comic', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'publisher_id',
                'label' => 'Publisher',
                'content' => function ($model) {
                    return Html::a($model->publisher->name, ['publisher/view', 'id' => $model->publisher->id]);
                },
                'filter' => ArrayHelper::map(Publishers::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
            ],
            'issues_count',
            'issues_total',
            'concluded:boolean',
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width:100px;'],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
