<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Affiliation $model
 */

$this->title = 'Create Affiliation';
?>

<?= $this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'affiliation',
   'divClass' => 'affiliation-create',
]) ?>

<?php
$this->params['breadcrumbs'][] = ['label' => 'Affiliations', 'url' => ['index', 'studentId' => $student->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
   'student' => $student,
]) ?>

<?= $this->render('/student/update-footer', []) ?>