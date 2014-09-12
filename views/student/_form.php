<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\ActiveField;
use kartik\builder\TabularForm;
use app\models\Division;
use app\models\AClass;
use app\models\Student;
use app\models\StudentPhone;
use app\models\search\StudentPhoneSearch;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var app\models\Student $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="student-form">

   <?php
   $form = ActiveForm::begin([
      'options' => [
      ],
   ]);
   ?>
  
   <table>
      <tr>
         <td><?= $form->field($model, 'active')->checkbox() ?></td>
         <td><?= $form->field($model, 'kai_number')->textInput(['maxlength' => 6]) ?></td>
         <td><?= $form->field($model->affiliation, 'date')->widget(DateControl::classname(), [
            'widgetClass' => '\yii\widgets\MaskedInput',
            'options' => ['mask' => '99/99/9999'],
         ]);?>
         </td>
         <td><?= $form->field($model, 'dob')->widget(DateControl::classname(), [
            'widgetClass' => '\yii\widgets\MaskedInput',
            'options' => ['mask' => '99/99/9999'],
         ]);?>
         </td>
      </tr>
      <tr>
         <td><?= $form->field($model, 'gender')->dropDownList(['?' => 'Unspecified', 'M' => 'Male', 'F' => 'Female']) ?></td>
         <td/>
         
         <td><?= $form->field($model, 'fname')->textInput(['maxlength' => 45]) ?></td>
         <td><?= $form->field($model, 'lname')->textInput(['maxlength' => 45]) ?></td>
      </tr>
      <tr>
         <td colspan="2"><?= $form->field($model, 'belt_size')->dropDownList(Student::getGiSizeMap()) ?></td>
         <td colspan="2"><?= $form->field($model, 'division_id')->dropDownList(Division::getMap()) ?></td>
      </tr>
      <tr>
         <td colspan="2"><?= $form->field($model->affiliation, 'hand_anchor_id')->dropDownList(ArrayHelper::map($model->handAnchors, 'id', 'fullName')) ?></td>
         <td colspan="2"><?= $form->field($model->affiliation, 'weapon_anchor_id')->dropDownList(ArrayHelper::map([null] + $model->weaponAnchors, 'id', 'fullName')) ?></td>
      </tr>
      <tr>
         <td colspan="4"><?= $form->field($model, 'email')->textInput(['maxlength' => 254]) ?></td>
      </tr>
      <tr>
         <td td colspan="4"><?= $form->field($model, 'sparAuth')->checkBoxList(Student::getSparAuthList(true), ['inline' => true]) ?></td>
      </tr>
      <tr>
         <td td colspan="4"><?= $form->field($model, 'grappleAuth')->checkboxList(Student::getGrappleAuthList(true), ['inline' => true]) ?></td>
      </tr>
      <tr>
         <td colspan="4"><?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?></td>
      </tr>
   </table>

   <div class="form-group">
       <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   </div>
   
   <?php ActiveForm::end(); ?>
   
</div>