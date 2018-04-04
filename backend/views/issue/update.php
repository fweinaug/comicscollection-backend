<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Issues */

$this->title = 'Update: '.$model->comic->name.' #'.$model->number;
$this->params['breadcrumbs'][] = ['label' => 'Issues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->comic->name.' #'.$model->number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="issues-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
