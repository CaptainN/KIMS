<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use \yii\helpers\Json;

use app\models\Division;
use app\models\AClass;
use app\models\Student;

/**
 * @var yii\web\View $this
 * @var \app\models\Student $model
 */

$options = [];
$options['checkNameUrl'] = Url::to(['/student/check-name']);
$options['getClassesUrl'] = Url::to(['/class/create-student-hand-anchors']);
$this->registerJs("var options = " . JSON::encode($options) . ";", $this::POS_HEAD, 'my-options');
$this->registerJsFile('/js/student-create.js', ['\app\assets\AppAsset']);

$this->title = 'Create Student';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="student-create">
   <h1><?= Html::encode($this->title) ?></h1>
   <?php
   $form = ActiveForm::begin();
   echo Form::widget([
       'model' => $model,
       'form' => $form,
       'columns' => 3,
       'attributes' => [
           'gender' => [
              'type' => Form::INPUT_DROPDOWN_LIST,
              'options' => [
              ],
              'items' => ['M' => 'Male', 'F' => 'Female'],
            ],
           'fname' => [
              'type' => Form::INPUT_TEXT,
              'options' => [],
            ],
           'lname' => [
              'type' => Form::INPUT_TEXT,
              'options' => [],
            ],
            'dob' => [
               'type' => Form::INPUT_WIDGET,
               'widgetClass' => '\kartik\datecontrol\DateControl',
               'options' => [
                  'widgetClass' => '\yii\widgets\MaskedInput',
                  'options' => [
                     'mask' => '99/99/9999'
                  ],
               ],
               'hint' => 'Use mm/dd/yyyy format',
            ],
           'bestPhone' => [
              'type' => Form::INPUT_WIDGET,
              'widgetClass' => '\yii\widgets\MaskedInput',
              'options' => [
                 'mask' => '(999) 999 9999',
                 'value' => '',
                 'name' => 'StudentPhone[number]',
              ],
            ],
            'belt_size' => [
               'type' => Form::INPUT_DROPDOWN_LIST,
               'items' => Student::getGiSizeMap(),
            ],
           'division_id' => [
              'type' => Form::INPUT_DROPDOWN_LIST,
              'options' => [],
              'items' => [null => ''] + Division::getMap(), //default to blank
            ],
           'handAnchor' => [
              'type' => Form::INPUT_DROPDOWN_LIST,
              'options' => [
                 'value' => 0,
                 'name' => 'Affiliation[hand_anchor_id]',
              ],
              //'items' => ArrayHelper::map($model->handAnchors, 'id', 'fullName'),
              'items' => [null => ''], //will populate when div changes
            ],
       ]
   ]);
   ?>
   <div class="form-group">
      <!--input type="hidden" name="action" id="action" value="" /-->
      <?= Html::submitButton('Save and Exit', ['class' => 'btn btn-success', 'icon' => 'floppy-disk']) ?>
      <?= Html::submitButton('Save and Add Another', ['name' => 'then-add', 'class' => 'btn btn-success', 'icon' => 'floppy-disk']) ?>
      <?= Html::a('Cancel', Url::to(['/student']), ['class' => 'btn btn-primary', 'icon' => 'remove']) ?>
   </div>
</div>