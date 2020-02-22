<?php

use common\models\Comics;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Issues */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issues-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $comics = ArrayHelper::map(Comics::find()->orderBy('name')->asArray()->all(), 'id', 'name') ?>
    <?= $form->field($model, 'comic_id')->dropDownList($comics)->label('Comic') ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'release_date')->textInput() ?>

    <?= $form->field($model, 'summary')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
