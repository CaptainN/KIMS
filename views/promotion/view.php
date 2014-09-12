<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\Promotion $model
 * @var app\models\Student $student
 */
$this->title = $model->id;
?>

<?=
$this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'promotion',
   'divClass' => 'promotion-view',
])
?>

<?php
$this->params['breadcrumbs'][] = ['label' => 'Promotions', 'url' => ['index', 'studentId' => $student->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
   <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
   <?=
   Html::a('Delete', ['delete', 'id' => $model->id], [
      'class' => 'btn btn-danger',
      'data' => [
         'confirm' => 'Are you sure you want to delete this item?',
         'method' => 'post',
      ],
   ])
   ?>
</p>

<?=
DetailView::widget([
   'model' => $model,
   'attributes' => [
      'id',
      'active',
      'student.name',
      'rank.name',
      'date',
      'testing_session_id',
   ],
])
?>

<?= $this->render('/student/update-footer', []) ?>