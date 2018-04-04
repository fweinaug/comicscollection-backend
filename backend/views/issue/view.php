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
                'value' => $model->getImageUrl(),
                'format' => [ 'image', [ 'width'=>'150','height'=>'200' ]],
            ],
            'summary:ntext',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
