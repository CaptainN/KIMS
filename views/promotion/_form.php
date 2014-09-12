<?php

use yii\helpers\Html;
use \kartik\widgets\ActiveForm;
use \app\models\Rank;
use \kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var app\models\Promotion $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="promotion-form">

   <?php $form = ActiveForm::begin(); ?>

   <?= Html::activeHiddenInput($model, 'student_id', ['value' => $student->id]) ?>

   <?= $form->field($model, 'rank_id')->dropDownList(Rank::getMap()) ?>

   <?= $form->field($model, 'testing_session_id')->textInput() ?>

   <?=
   $form->field($model, 'date')->widget(DateControl::classname(), [
      'widgetClass' => '\yii\widgets\MaskedInput',
      'options' => ['mask' => '99/99/9999'],
   ]);
   ?>

   <div class="form-group">
   <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   </div>

<?php ActiveForm::end(); ?>

</div>
