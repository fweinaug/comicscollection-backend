<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Images */
/* @var $publisher common\models\Publishers */

$this->title = 'Upload Image';
$this->params['breadcrumbs'][] = ['label' => 'Publishers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $publisher->name, 'url' => ['view', 'id' => $publisher->id]];
$this->params['breadcrumbs'][] = 'Upload Image';
?>
<div class="upload-image">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('../image/_form', [
        'model' => $model,
    ]) ?>

</div>
