<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Images */

$this->title = $model->filename;
$this->params['breadcrumbs'][] = ['label' => 'Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="images-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
                'label' => 'Image',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a(
                        Html::img($model->getOriginalUrl(), [ 'height'=>'600' ]),
                        ['render', 'id' => $model->id]
                    );
                }
            ],
            [
                'label' => 'Resolution',
                'format' => 'raw',
                'value' => function ($model) {
                    return "$model->width x $model->height";
                }
            ],
            'size:shortSize',
            'mime',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
