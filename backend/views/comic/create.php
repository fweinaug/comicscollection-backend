<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Comics */

$this->title = 'Create Comic';
$this->params['breadcrumbs'][] = ['label' => 'Comics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comics-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'next' => true,
    ]) ?>

</div>
