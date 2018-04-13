<?php

use common\models\Comics;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\IssuesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Issues';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issues-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Issue', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'comic_id',
                'label' => 'Comic',
                'value' => 'comic.name',
                'filter' => ArrayHelper::map(Comics::find()->orderBy('name')->asArray()->all(), 'id', 'name'),

            ],
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
                'contentOptions' => ['style' => 'width:100px;'],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
