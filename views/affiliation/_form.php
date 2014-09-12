<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;
use \app\models\School;
use \app\models\Role;

/**
 * @var \yii\web\View $this
 * @var \app\models\Affiliation $model
 * @var \yii\widgets\ActiveForm $form
 * @var \app\models\Student $student
 */
?>

<div class="affiliation-form">

   <?php $form = ActiveForm::begin(); ?>

   <?= Html::activeHiddenInput($model, 'active', ['value' => 1]) ?>

   <?= Html::activeHiddenInput($model, 'student_id', ['value' => $student->id]) ?>

   <?= $form->field($model, 'school_id')->dropDownList(School::getMap()) ?>

   <?= $form->field($model, 'role_id')->dropDownList(Role::getMap()) ?>

   <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   </div>

   <?php ActiveForm::end(); ?>

</div>
