<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Images */
/* @var $issue common\models\Issues */

$this->title = 'Upload Image';
$this->params['breadcrumbs'][] = ['label' => 'Issues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $issue->comic->name.' #'.$issue->number, 'url' => ['view', 'id' => $issue->id]];
$this->params['breadcrumbs'][] = 'Upload Image';
?>
<div class="upload-image">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('../image/_form', [
        'model' => $model,
    ]) ?>

</div>
