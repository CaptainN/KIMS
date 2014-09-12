<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\StudentAddress $model
 * @var app\models\Student $student
 */
$this->title = 'Create Student Address';
?>

<?=
$this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'address',
   'divClass' => 'student-address-create',
])
?>

<?php
$this->params['breadcrumbs'][] = ['label' => 'Student Addresses', 'url' => ['index', 'studentId' => $student->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?=
$this->render('_form', [
   'student' => $student,
   'model' => $model,
])
?>

<?= $this->render('/student/update-footer', []) ?>