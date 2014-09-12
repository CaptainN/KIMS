<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\StudentAddress $model
 * @var yii\widgets\ActiveForm $form
 * @var app\models\Student $student
 */
?>

<div class="student-address-form">

   <?php $form = ActiveForm::begin(); ?>

   <?= Html::activeHiddenInput($model, 'student_id', ['value' => $student->id]) ?>

   <?= Html::activeHiddenInput($model, 'ord', ['value' => end($student->addresses)->ord + 1]) ?>

   <?= $form->field($model, 'active')->textInput() ?>

   <?= $form->field($model, 'line1')->textInput(['maxlength' => 64]) ?>

   <?= $form->field($model, 'line2')->textInput(['maxlength' => 64]) ?>

   <?= $form->field($model, 'city')->textInput(['maxlength' => 32]) ?>

   <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>

   <?= $form->field($model, 'state_abbr')->textInput(['maxlength' => 2]) ?>

   <?= $form->field($model, 'zip')->textInput(['maxlength' => 10]) ?>

   <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   </div>

   <?php ActiveForm::end(); ?>

</div>
