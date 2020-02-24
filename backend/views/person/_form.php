<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\People */
/* @var $form yii\widgets\ActiveForm */
/* @var $next boolean */
?>

<div class="people-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

        <?php if ($next): ?>
            <?= Html::submitButton('Next Person', ['class' => 'btn btn-default', 'name' => 'next']) ?>
        <?php endif ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
