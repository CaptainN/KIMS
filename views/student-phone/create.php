<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\StudentPhone $model
 */

$this->title = 'Create Phone';
?>

<?= $this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'phone',
   'divClass' => 'student-phone-create',
]) ?>

<?php
$this->params['breadcrumbs'][] = ['label' => 'Phones', 'url' => ['index', 'studentId' => $student->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
   'student' => $student,
   'model' => $model,
]) ?>

<?= $this->render('/student/update-footer', []) ?>