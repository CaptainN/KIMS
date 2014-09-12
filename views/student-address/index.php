<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\StudentAddressSearch $searchModel
 * @var app\models\Student $student
 */
$dataProvider->pagination = false;

$this->title = 'Student Addresses';
?>

<?=
$this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'address',
   'divClass' => 'student-address-index',
])
?>

<?php
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

<p>
<?= Html::a('Create Student Address', ['create', 'studentId' => $student->id], ['class' => 'btn btn-success']) ?>
</p>

<?=
GridView::widget([
   'dataProvider' => $dataProvider,
   'filterModel' => $searchModel,
   'columns' => [
      'ord',
      'id',
      'student_id',
      'line1',
      'line2',
      'city',
      'state_abbr',
      'zip',
      'name',
      'active',
      ['class' => 'yii\grid\ActionColumn'],
   ],
]);
?>

<?= $this->render('/student/update-footer', []) ?>