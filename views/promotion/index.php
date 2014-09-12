<?php

use yii\helpers\Html;
use \kartik\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\PromotionSearch $searchModel
 * @var app\models\Student $student
 */

$this->title = 'Promotions';
?>

<?=
$this->render('/student/update-header', [
   'student' => $student,
   'tab' => 'promotion',
   'divClass' => 'promotion-index',
])
?>

<?php
$this->params['breadcrumbs'][] = $this->title;
?>


<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<p>
   <?= Html::a('Create Promotion', ['create', 'studentId' => $student->id], ['class' => 'btn btn-success']) ?>
</p>

<?=
GridView::widget([
   'dataProvider' => $dataProvider,
   'filterModel' => $searchModel,
   'columns' => [
      ['class' => 'yii\grid\SerialColumn'],
      [
         'class' => '\kartik\grid\BooleanColumn',
         'attribute' => 'active',
      ],
      [
         'attribute' => 'rank_id',
         'value' => 'rank.name',
      ],
      'date',
      // 'testing_session_id',
      ['class' => 'yii\grid\ActionColumn'],
   ],
]);
?>

<?= $this->render('/student/update-footer', []) ?>