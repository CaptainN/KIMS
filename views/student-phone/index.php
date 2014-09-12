<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\StudentPhoneSearch $searchModel
 * @var app\models\Student $student
 */
$dataProvider->pagination = false;

$this->title = 'Update Phones: ' . $student->name;
?>

<?=
$this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'phone',
   'divClass' => 'student-phone-index',
])
?>

<?php
$this->params['breadcrumbs'][] = ['label' => 'Phones'];
?>

<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

<p>
   <?=
   Html::a('Create Phone', ['create', 'studentId' => get('studentId')], ['class' => 'btn btn-success'])
   ?>
</p>

<?=
GridView::widget([
   'dataProvider' => $dataProvider,
   'filterModel' => $searchModel,
   'columns' => [
      'ord',
      'active',
      'number',
      'name',
      ['class' => 'yii\grid\ActionColumn'],
   ],
]);
?>

<?= $this->render('/student/update-footer', []) ?>