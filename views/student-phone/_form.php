<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\StudentPhone $model
 * @var app\models\Student $student
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="student-phone-form">

   <?php $form = ActiveForm::begin(); ?>
   
   <?= Html::activeHiddenInput($model, 'student_id', ['value' => $student->id]) ?>
   
   <?= Html::activeHiddenInput($model, 'ord', ['value' => count($student->phones) + 1]) ?>

   <?= $form->field($model, 'number')->widget('\yii\widgets\MaskedInput', [
      'mask' => '(999) 999 9999']) ?>
   
   <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>

   <div class="form-group">
       <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   </div>

   <?php ActiveForm::end(); ?>

</div>
