<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Promotion $model
 * @var app\models\Student $student
 */
$this->title = 'Update Promotion: ' . $model->id;
?>

<?=
$this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'promotion',
   'divClass' => 'promotion-update',
])
?>

<?php
$this->params['breadcrumbs'][] = ['label' => 'Promotions', 'url' => ['index', 'studentId' => $student->id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<?=
$this->render('_form', [
   'student' => $student,
   'model' => $model,
])
?>

<?= $this->render('/student/update-footer', []) ?>