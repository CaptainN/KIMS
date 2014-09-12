<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\AClass $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="aclass-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'day_id')->textInput() ?>

    <? /*$form->field($model, 'division_id')->textInput()*/ ?>

    <?= $form->field($model, 'room_id')->textInput() ?>

    <?= $form->field($model, 'instructor_id')->textInput() ?>

    <?= $form->field($model, 'type_id')->textInput() ?>

    <?= $form->field($model, 'frequency_id')->textInput() ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'start_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
