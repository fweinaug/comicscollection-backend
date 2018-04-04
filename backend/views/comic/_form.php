<?php

use common\models\Publishers;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Comics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comics-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_id')->textInput() ?>

    <?= $form->field($model, 'issues_total')->textInput(['readonly' => true]) ?>

    <?php $publishers = ArrayHelper::map(Publishers::find()->orderBy('name')->asArray()->all(), 'id', 'name') ?>
    <?= $form->field($model, 'publisher_id')->dropDownList($publishers)->label('Publisher') ?>

    <?= $form->field($model, 'concluded')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
