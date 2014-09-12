<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/**
 * @var yii\web\View $this
 * @var app\models\Student $student
 */

$this->registerJsFile('/js/student-update.js', ['\app\assets\AppAsset']);

$this->title = 'Update Student: ' . $student->name;
?>
<?= $this->render('update-header', [
   'student' => $student,
   'tab' => 'general',
]) ?>
<?= $this->render('_form', [
   'model' => $student,
]) ?>
<?= $this->render('update-footer', []) ?>