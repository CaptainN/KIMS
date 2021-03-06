<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\StudentPhone $model
 * @var app\models\Student $student
 */
$this->title = 'Update Student Phone: ' . $model->name;
?>

<?=
$this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'phone',
   'divClass' => 'student-phone-update',
])
?>

<?php
$this->params['breadcrumbs'][] = ['label' => 'Student Phones', 'url' => ['index', 'studentId' => $student->id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<?=
$this->render('_form', [
   'student' => $student,
   'model' => $model,
])
?>

<?= $this->render('/student/update-footer', []) ?>