<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ComicCreators */
/* @var $comic common\models\Comics */

$this->title = 'Update Creator: '.$comic->name;
$this->params['breadcrumbs'][] = ['label' => 'Comics', 'url' => ['comic/index']];
$this->params['breadcrumbs'][] = ['label' => $comic->name, 'url' => ['comic/view', 'id' => $comic->id]];
$this->params['breadcrumbs'][] = ['label' => 'Creators', 'url' => ['/comic-creators', 'id' => $comic->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comic-creators-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
