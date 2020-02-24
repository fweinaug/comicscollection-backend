<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\People */

$this->title = 'Create Person';
$this->params['breadcrumbs'][] = ['label' => 'People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="people-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'next' => true,
    ]) ?>

</div>
