<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Affiliation $model
 */
$this->title = 'Update Affiliation: ' . $model->id;
?>

<?=
$this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'affiliation',
   'divClass' => 'affiliation-update',
])
?>

<?php
$this->params['breadcrumbs'][] = ['label' => 'Affiliations', 'url' => ['index', 'studentId' => $student->id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<?=
$this->render('_form', [
   'model' => $model,
])
?>

<?= $this->render('/student/update-footer', []) ?>