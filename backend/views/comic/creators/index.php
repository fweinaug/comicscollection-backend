<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $comic common\models\Comics */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $comic->name.': Creators';
$this->params['breadcrumbs'][] = ['label' => 'Comics', 'url' => ['comic/index']];
$this->params['breadcrumbs'][] = ['label' => $comic->name, 'url' => ['comic/view', 'id' => $comic->id]];
$this->params['breadcrumbs'][] = 'Creators';
?>
<div class="comic-creators-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add Creator', ['create', 'comic_id' => $comic->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->person->name, ['person/view', 'id' => $model->person->id]);
                },
            ],
            'contribution',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'contentOptions' => ['style' => 'width:100px;'],
            ],
        ],
    ]); ?>
</div>
