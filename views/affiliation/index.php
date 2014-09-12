<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\ToggleColumn;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\AffiliationSearch $searchModel
 */
$dataProvider->pagination = false;

$this->title = 'Affiliations';
?>

<?=
$this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'affiliation',
   'divClass' => 'affiliation-index',
])
?>

<?php
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<p>
   <?= Html::a('Create Affiliation', ['create', 'studentId' => $student->id], ['class' => 'btn btn-success']) ?>
</p>

<?=
GridView::widget([
   'dataProvider' => $dataProvider,
   'filterModel' => $searchModel,
   'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
      [
         'class' => ToggleColumn::className(),
         'attribute' => 'active',
         'filter' => ['1' => 'Y', '0' => 'N', '' => 'All'],
         'headerOptions' => ['style' => 'width:20px'],
         'contentOptions' => ['class' => 'text-center'],
      ],
      'school.name',
      'role.name',
      'handAnchor.name',
      'weaponAnchor.name',
      'date',
      ['class' => 'yii\grid\ActionColumn'],
   ],
]);
?>

<?= $this->render('/student/update-footer', []) ?>