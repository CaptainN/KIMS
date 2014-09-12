<?php

use app\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\StudentPhone $model
 * @var app\models\Student $student
 */

$this->title = $model->name;
?>

<?= $this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'phone',
   'divClass' => 'student-phone-view',
]) ?>

<?php
$this->params['breadcrumbs'][] = ['label' => 'Student Phones', 'url' => ['index', 'studentId' => $student->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
   <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
   <?= Html::a('Delete', ['delete', 'id' => $model->id], [
       'class' => 'btn btn-danger',
       'data' => [
           'confirm' => 'Are you sure you want to delete this item?',
           'method' => 'post',
       ],
   ]) ?>
</p>

<?= DetailView::widget([
   'model' => $model,
   'attributes' => [
       'id',
       'ord',
       'student_id',
       'number',
       'name',
       'active',
   ],
]) ?>

<?= $this->render('/student/update-footer', []) ?>