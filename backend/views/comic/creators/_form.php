<?php

use common\models\People;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ComicCreators */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comic-creators-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $people = ArrayHelper::map(People::find()->orderBy('first_name, last_name')->all(), 'id', 'name') ?>
    <?= $form->field($model, 'person_id')->dropDownList($people)->label('Person') ?>

    <?= $form->field($model, 'contribution')->textInput(['maxlength' => true, 'placeholder' => 'e.g. Writer,Artist']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
