<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Promotion $model
 * @var app\models\Student $student
 */

$this->title = 'Create Promotion';
?>
<?=
$this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'promotion',
   'divClass' => 'promotion-create',
])
?>

<?php
$this->params['breadcrumbs'][] = ['label' => 'Promotions', 'url' => ['index', 'studentId' => $student->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?=
$this->render('_form', [
   'student' => $student,
   'model' => $model,
])
?>

<?= $this->render('/student/update-footer', []) ?>